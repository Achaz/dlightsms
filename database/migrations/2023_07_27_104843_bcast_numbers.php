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
        Schema::table('bcast_numbers', function (Blueprint $table) {
            $table->string('field1')->nullable()->change();
            $table->string('field2')->nullable()->change();
            $table->string('field3')->nullable()->change();
            $table->string('field4')->nullable()->change();
            $table->string('field5')->nullable()->change();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bcast_numbers', function (Blueprint $table) {
            $table->string('field1')->change();
            $table->string('field2')->change();
            $table->string('field3')->change();
            $table->string('field4')->change();
            $table->string('field5')->change();
        });
    }
};
