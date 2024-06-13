<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateProductLogTriggers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // After Insert Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER product_log_after_insert 
            AFTER INSERT ON Product FOR EACH ROW
            BEGIN
                INSERT INTO product_logs (
                    product_id,
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

        // After Update Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER product_log_after_update 
            AFTER UPDATE ON Product FOR EACH ROW
            BEGIN
                IF OLD.name <> NEW.name OR OLD.sell_price <> NEW.sell_price OR 
                    OLD.discount <> NEW.discount OR OLD.available <> NEW.available OR 
                    OLD.description <> NEW.description OR OLD.production_date <> NEW.production_date OR
                    OLD.is_perishable <> NEW.is_perishable OR OLD.perishable_data <> NEW.perishable_data OR
                    OLD.sell_number <> NEW.sell_number OR OLD.buy_price <> NEW.buy_price
                THEN
                    INSERT INTO product_logs (
                        product_id,
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
                            "sell_price", OLD.sell_price,
                            "discount", OLD.discount,
                            "available", OLD.available,
                            "description", OLD.description,
                            "production_date", OLD.production_date,
                            "is_perishable", OLD.is_perishable,
                            "perishable_data", OLD.perishable_data,
                            "sell_number", OLD.sell_number,
                            "buy_price", OLD.buy_price
                        ),
                        NEW.*,
                        SESSION_USER_ID(),
                        NOW()
                    );
                END IF;
            END;
        ');

        // Before Delete Trigger for Product Logs
        DB::unprepared('
            CREATE TRIGGER product_log_before_delete 
            BEFORE DELETE ON Product FOR EACH ROW
            BEGIN
                INSERT INTO product_logs (
                    product_id,
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
        DB::statement('DROP TRIGGER IF EXISTS product_log_after_insert');
        DB::statement('DROP TRIGGER IF EXISTS product_log_after_update');
        DB::statement('DROP TRIGGER IF EXISTS product_log_before_delete');
    }
}