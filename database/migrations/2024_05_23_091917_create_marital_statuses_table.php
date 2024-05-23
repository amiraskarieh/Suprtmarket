<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaritalStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('marital_status_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('marital_statuses');

        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['marital_status_id']);
            $table->dropColumn('marital_status_id');
        });
    }
}
