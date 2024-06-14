<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // After Insert Trigger for Transaction Logs
        DB::unprepared('
            CREATE TRIGGER transaction_log_after_insert
            AFTER INSERT ON transactions FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App\Models\Transaction",
                    NEW.id,
                    "INSERT",
                    SESSION_USER_ID(),
                    NOW(),
                    NULL
                );
            END;
        ');

        // Before Delete Trigger for Transaction Logs
        DB::unprepared('
            CREATE TRIGGER transaction_log_before_delete
            BEFORE DELETE ON transactions FOR EACH ROW
            BEGIN
                INSERT INTO `logs` (
                    `logable_type`,
                    `logable_id`,
                    `operation_type`,
                    `user_id`,
                    `created_at`,
                    `updated_at`
                ) VALUES (
                    "App\Models\Transaction",
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
    public function down(): void
    {
        DB::statement('DROP TRIGGER IF EXISTS transaction_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS transaction_log_before_delete');
    }
};
