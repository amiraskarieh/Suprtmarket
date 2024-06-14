<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Employee Logs
        DB::unprepared('
            CREATE TRIGGER employee_log_after_insert
            AFTER INSERT ON employees FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/Employee",
                    NEW.id,
                    "INSERT",
                    NOW(),
                    NULL
                );
            END;
        ');

        // After Update Trigger for Employee Logs
        DB::unprepared('
            CREATE TRIGGER employee_log_after_update
            AFTER UPDATE ON employees FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/Employee",
                    NEW.id,
                    "UPDATE",
                    NOW(),
                    NULL
                );
            END;
        ');

        // Before Delete Trigger for Employee Logs
        DB::unprepared('
            CREATE TRIGGER employee_log_before_delete
            BEFORE DELETE ON employees FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/Employee",
                    OLD.id,
                    "DELETE",
                    NOW(),
                    NULL
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
        DB::statement('DROP TRIGGER IF EXISTS employee_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS employee_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS employee_log_before_delete');
    }
};
