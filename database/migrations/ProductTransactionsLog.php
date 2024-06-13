<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductTransactionLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Product Transaction Logs
        DB::unprepared('
            CREATE TRIGGER product_transaction_log_after_insert 
            AFTER INSERT ON ProductTransactions FOR EACH ROW
            BEGIN
                INSERT INTO product_transaction_logs (
                    product_transaction_id,
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

        // After Update Trigger for Product Transaction Logs
        DB::unprepared('
            CREATE TRIGGER product_transaction_log_after_update 
            AFTER UPDATE ON ProductTransactions FOR EACH ROW
            BEGIN
                IF OLD.product_id <> NEW.product_id OR OLD.transaction_id <> NEW.transaction_id OR 
                    OLD.count <> NEW.count
                THEN
                    INSERT INTO product_transaction_logs (
                        product_transaction_id,
                        operation_type,
                        old_value,
                        new_value,
                        user_id,
                        timestamp
                    )
                    VALUES (
                        NEW.id,
                        "UPDATE",
                        JSON_OBJECT(
                            "product_id", OLD.product_id,
                            "transaction_id", OLD.transaction_id,
                            "count", OLD.count
                        ),
                        NEW.*,
                        SESSION_USER_ID(),
                        NOW()
                    );
                END IF;
            END;
        ');

        // Before Delete Trigger for Product Transaction Logs
        DB::unprepared('
            CREATE TRIGGER product_transaction_log_before_delete 
            BEFORE DELETE ON ProductTransactions FOR EACH ROW
            BEGIN
                INSERT INTO product_transaction_logs (
                    product_transaction_id,
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
        DB::statement('DROP TRIGGER IF EXISTS product_transaction_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS product_transaction_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS product_transaction_log_before_delete');
    }
}