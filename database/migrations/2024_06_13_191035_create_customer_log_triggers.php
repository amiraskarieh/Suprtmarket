<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER customer_log_after_insert
            AFTER INSERT ON customers FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App\Models\Customer",
                    NEW.id,
                    "INSERT",
                    SESSION_USER_ID(),
                    NOW(),
                    NULL
                );
            END;
        ');

        // After Update Trigger for Customer Logs
        DB::unprepared('
            CREATE TRIGGER customer_log_after_update
            AFTER UPDATE ON customers FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_id`,
                    `logable_type`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    NEW.id,
                    "App\Models\Customer",
                    "UPDATE",
                    SESSION_USER_ID(),
                    NOW(),
                    NULL
                );
            END;
        ');

        // Before Delete Trigger for Customer Logs
        DB::unprepared('
            CREATE TRIGGER customer_log_before_delete
            BEFORE DELETE ON customers FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_id`,
                    `logable_type`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    OLD.id,
                    "App\Models\Customer",
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
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS customer_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS customer_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS customer_log_before_delete');
    }
};
