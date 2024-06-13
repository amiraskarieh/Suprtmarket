<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSupplierLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Supplier Logs
        DB::unprepared('
                    CREATE TRIGGER supplier_log_after_insert
                    AFTER INSERT ON Supplier
                    FOR EACH ROW
                    BEGIN
                        INSERT INTO supplier_logs (
                            supplier_id,
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

        // Before Delete Trigger for Supplier Logs
        DB::unprepared('
                    CREATE TRIGGER supplier_log_before_delete
                    BEFORE DELETE ON Supplier
                    FOR EACH ROW
                    BEGIN
                        INSERT INTO supplier_logs (
                            supplier_id,
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
        DB::statement('DROP TRIGGER IF EXISTS supplier_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS supplier_log_before_delete');
    }
}
