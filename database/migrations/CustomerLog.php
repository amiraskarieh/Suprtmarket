<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomerLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Customer Logs
        DB::unprepared('
            CREATE TRIGGER customer_log_after_insert 
            AFTER INSERT ON Customer FOR EACH ROW
            BEGIN
                INSERT INTO customer_logs (
                    customer_id,
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

        // After Update Trigger for Customer Logs
        DB::unprepared('
            CREATE TRIGGER customer_log_after_update 
            AFTER UPDATE ON Customer FOR EACH ROW
            BEGIN
                IF OLD.name <> NEW.name OR OLD.age <> NEW.age OR 
                    OLD.phone <> NEW.phone OR OLD.address <> NEW.address
                THEN
                    INSERT INTO customer_logs (
                        customer_id,
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
                            "address", OLD.address
                        ),
                        NEW.*,
                        SESSION_USER_ID(),
                        NOW()
                    );
                END IF;
            END;
        ');

        // Before Delete Trigger for Customer Logs
        DB::unprepared('
            CREATE TRIGGER customer_log_before_delete 
            BEFORE DELETE ON Customer FOR EACH ROW
            BEGIN
                INSERT INTO customer_logs (
                    customer_id,
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
        DB::statement('DROP TRIGGER IF EXISTS customer_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS customer_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS customer_log_before_delete');
    }
}