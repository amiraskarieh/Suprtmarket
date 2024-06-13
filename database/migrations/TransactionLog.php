<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTransactionLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Transaction Logs
        DB::unprepared('
            CREATE TRIGGER transaction_log_after_insert
            AFTER INSERT ON Transactions
            FOR EACH ROW
            BEGIN
                INSERT INTO transaction_logs (
                    transaction_id,
                    operation_type,
                    old_value,
                    new_value,
                    user_id,
                    timestamp
                )
                VALUES (
                    NEW.id,
                    "INSERT",
                    NULL,
                    NEW.*,
                    SESSION_USER_ID(),
                    NOW()
                );
            END;
        ');

        // Before Delete Trigger for Transaction Logs
        DB::unprepared('
            CREATE TRIGGER transaction_log_before_delete
            BEFORE DELETE ON Transactions
            FOR EACH ROW
            BEGIN
                INSERT INTO transaction_logs (
                    transaction_id,
                    operation_type,
                    old_value,
                    new_value,
                    user_id,
                    timestamp
                )
                VALUES (
                    OLD.id,
                    "DELETE",
                    OLD.*,
                    NULL,
                    SESSION_USER_ID(),
                    NOW()
                );
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP TRIGGER IF EXISTS transaction_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS transaction_log_before_delete');
    }
}