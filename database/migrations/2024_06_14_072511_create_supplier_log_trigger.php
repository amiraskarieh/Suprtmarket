<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // After Insert Trigger for Supplier Logs
        DB::unprepared('
            CREATE TRIGGER supplier_log_after_insert
            AFTER INSERT ON suppliers FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/Supplier",
                    NEW.id,
                    "INSERT",
                    NOW(),
                    NULL
                );
            END;
        ');

        // After Update Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER supplier_log_after_update
            AFTER UPDATE ON suppliers FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/Supplier",
                    NEW.id,
                    "UPDATE",
                    NOW(),
                    NULL
                );
            END;
        ');

        // Before Delete Trigger for Supplier Logs
        DB::unprepared('
            CREATE TRIGGER supplier_log_before_delete
            BEFORE DELETE ON suppliers FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/Supplier",
                    OLd.id,
                    "DELETE",
                    NOW(),
                    NULL
                );
            END;
        ');
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS supplier_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS supplier_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS supplier_log_before_delete');
    }
};
