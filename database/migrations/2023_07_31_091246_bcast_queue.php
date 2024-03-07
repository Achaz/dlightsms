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
        Schema::table('bcast_queue', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
            $table->string('job_id')->nullable()->change();
            $table->string('sender_id')->nullable()->change();          

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bcast_queue', function (Blueprint $table) {
            $table->string('title')->change();
            $table->string('job_id')->change();
            $table->string('sender_id')->change();
        });
    }
};
