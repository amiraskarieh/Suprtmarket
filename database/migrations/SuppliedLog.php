<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSuppliedLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Supplied Logs
        DB::unprepared('
            CREATE TRIGGER supplied_log_after_insert 
            AFTER INSERT ON Supplied FOR EACH ROW
            BEGIN
                INSERT INTO supplied_logs (
                    supplied_id,
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

        // Before Delete Trigger for Supplied Logs
        DB::unprepared('
            CREATE TRIGGER supplied_log_before_delete 
            BEFORE DELETE ON Supplied FOR EACH ROW
            BEGIN
                INSERT INTO supplied_logs (
                    supplied_id,
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
        DB::statement('DROP TRIGGER IF EXISTS supplied_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS supplied_log_before_delete');
    }
}