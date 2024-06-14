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
        // After Insert Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER product_log_after_insert
            AFTER INSERT ON products FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App\Models\Product",
                    NEW.id,
                    "INSERT",
                    SESSION_USER_ID(),
                    NOW(),
                    NULL
                );
            END;
        ');

        // After Update Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER product_log_after_update
            AFTER UPDATE ON products FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App\Models\Product",
                    NEW.id,
                    "UPDATE",
                    SESSION_USER_ID(),
                    NOW(),
                    NULL
                );
            END;
        ');

        // Before Delete Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER product_log_before_delete
            BEFORE DELETE ON products FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App\Models\Product",
                    OLD.id,
                    "DELETE",
                    SESSION_USER_ID(),
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
        DB::statement('DROP TRIGGER IF EXISTS product_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS product_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS product_log_before_delete');
    }
};
