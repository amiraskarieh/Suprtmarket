<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateEmployeeLogTriggers extends Migration
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
            AFTER INSERT ON Employee FOR EACH ROW
            BEGIN
                INSERT INTO employee_logs (
                    employee_id,
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

        // After Update Trigger for Employee Logs
        DB::unprepared('
            CREATE TRIGGER employee_log_after_update 
            AFTER UPDATE ON Employee FOR EACH ROW
            BEGIN
                IF OLD.name <> NEW.name OR OLD.age <> NEW.age OR 
                    OLD.phone <> NEW.phone OR OLD.salary <> NEW.salary OR 
                    OLD.emplyment_date <> NEW.emplyment_date OR OLD.address <> NEW.address OR
                    OLD.MaritalStatusID <> NEW.MaritalStatusID OR OLD.JobTypeID <> NEW.JobTypeID
                THEN
                    INSERT INTO employee_logs (
                        employee_id,
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
                            "name", OLD.name,
                            "age", OLD.age,
                            "phone", OLD.phone,
                            "salary", OLD.salary,
                            "emplyment_date", OLD.emplyment_date,
                            "address", OLD.address,
                            "MaritalStatusID", OLD.MaritalStatusID,
                            "JobTypeID", OLD.JobTypeID
                        ),
                        NEW.*,
                        SESSION_USER_ID(),
                        NOW()
                    );
                END IF;
            END;
        ');

        // Before Delete Trigger for Employee Logs
        DB::unprepared('
            CREATE TRIGGER employee_log_before_delete 
            BEFORE DELETE ON Employee FOR EACH ROW
            BEGIN
                INSERT INTO employee_logs (
                    employee_id,
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
        DB::statement('DROP TRIGGER IF EXISTS employee_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS employee_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS employee_log_before_delete');
    }
}