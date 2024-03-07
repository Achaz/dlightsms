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
        Schema::create('keywordlogs', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->bigInteger('sender')->nullable();
            $table->text('request')->nullable();
            $table->text('reply')->nullable();
            $table->string('keywd')->nullable();
            $table->string('level')->nullable();
            $table->bigInteger('dest')->nullable();
            $table->dateTime('created')->nullable();
            $table->string('charset')->nullable();
            $table->enum('status',['open','answered','closed'])->nullable();
            $table->integer('sms_id')->nullable();
            $table->string('network')->nullable();
            $table->timestamp('ts_stamp')->nullable();
            $table->dateTime('recvtime')->nullable();
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
        Schema::dropIfExists('keywordlogs');
    }
};
