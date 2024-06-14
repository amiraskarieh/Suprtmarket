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
        // After Insert Trigger for Product Transaction Logs
        DB::unprepared('
            CREATE TRIGGER product_transaction_log_after_insert
            AFTER INSERT ON product_transactions FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/ProductTransactions",
                    NEW.id,
                    "INSERT",
                    NOW(),
                    NULL
                );
            END;
        ');

        // After Update Trigger for Product Transaction Logs
        DB::unprepared('
            CREATE TRIGGER product_transaction_log_after_update
            AFTER UPDATE ON product_transactions FOR EACH ROW
            BEGIN
            INSERT INTO `logs` (
                `logable_type`,
                `logable_id`,
                `operation_type`,
                `created_at`,
                `updated_at`
            ) VALUES (
                "App/Models/ProductTransactions",
                NEW.id,
                "UPDATE",
                NOW(),
                NULL
            );
            END;
        ');

        // Before Delete Trigger for Product Transaction Logs
        DB::unprepared('
            CREATE TRIGGER product_transaction_log_before_delete
            BEFORE DELETE ON product_transactions FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App/Models/ProductTransactions",
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
     */
    public function down()
    {
        DB::statement('DROP TRIGGER IF EXISTS product_transaction_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS product_transaction_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS product_transaction_log_before_delete');
    }
};
