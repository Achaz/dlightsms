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
        Schema::create('mo_sms', function (Blueprint $table) {
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->bigInteger('sender')->nullable();
            $table->text('request')->nullable();
            $table->text('reply')->nullable();
            $table->string('keywd')->nullable();
            $table->string('level');
            $table->bigInteger('dest')->nullable();
            $table->timestamp('created')->nullable();
            $table->string('charset')->nullable();
            $table->enum('status',['open', 'answered', 'closed'])->nullable();
            $table->integer('sms_id')->unique();
            $table->string('network')->nullable();
            $table->timestamp('ts_stamp')->nullable();
            $table->timestamp('recvtime')->nullable();
            $table->string('msgid')->nullable();
            $table->string('msgtype')->nullable();
            $table->string('phonenum')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mo_sms');
    }
};
