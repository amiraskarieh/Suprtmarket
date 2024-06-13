<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMaritalStatusLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Marital Status Logs
        DB::unprepared('
            CREATE TRIGGER marital_status_log_after_insert 
            AFTER INSERT ON MaritalStatus FOR EACH ROW
            BEGIN
                INSERT INTO marital_status_logs (
                    marital_status_id,
                    operation_type,
                    old_value,
                    new_value,
                    user_id,
                    timestamp
                )
                VALUES (
                    NEW.MaritalStatusID,
                    "INSERT",
                    NULL,
                    NEW.*,
                    SESSION_USER_ID(),
                    NOW()
                );
            END;
        ');

        // Before Delete Trigger for Marital Status Logs
        DB::unprepared('
            CREATE TRIGGER marital_status_log_before_delete 
            BEFORE DELETE ON MaritalStatus FOR EACH ROW
            BEGIN
                INSERT INTO marital_status_logs (
                    marital_status_id,
                    operation_type,
                    old_value,
                    new_value,
                    user_id,
                    timestamp
                )
                VALUES (
                    OLD.MaritalStatusID,
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
        DB::statement('DROP TRIGGER IF EXISTS marital_status_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS marital_status_log_before_delete');
    }
}