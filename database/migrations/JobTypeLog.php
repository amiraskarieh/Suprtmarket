<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateJobTypeLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Job Type Logs
        DB::unprepared('
            CREATE TRIGGER job_type_log_after_insert 
            AFTER INSERT ON JobType FOR EACH ROW
            BEGIN
                INSERT INTO job_type_logs (
                    job_type_id,
                    operation_type,
                    old_value,
                    new_value,
                    user_id,
                    timestamp
                )
                VALUES (
                    NEW.JobTypeID,
                    "INSERT",
                    NULL,
                    NEW.*,
                    SESSION_USER_ID(),
                    NOW()
                );
            END;
        ');

        // Before Delete Trigger for Job Type Logs
        DB::unprepared('
            CREATE TRIGGER job_type_log_before_delete 
            BEFORE DELETE ON JobType FOR EACH ROW
            BEGIN
                INSERT INTO job_type_logs (
                    job_type_id,
                    operation_type,
                    old_value,
                    new_value,
                    user_id,
                    timestamp
                )
                VALUES (
                    OLD.JobTypeID,
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
        DB::statement('DROP TRIGGER IF EXISTS job_type_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS job_type_log_before_delete');
    }
}