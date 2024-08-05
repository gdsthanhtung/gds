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
        Schema::create('cong_dans', function (Blueprint $table) {
            $table->id();
            $table->string('cccd_number', 20);
            $table->date('cccd_dos');
            $table->string('fullname', 100);
            $table->string('gender', 1);
            $table->date('dob');
            $table->string('address');
            $table->string('phone', 20);
            $table->string('status', 10);
            $table->string('avatar', 50);
            $table->string('cccd_image_front', 50);
            $table->string('cccd_image_rear', 50);
            $table->integer('created_by');
            $table->timestamp('created', 0)->nullable();
            $table->integer('modified_by');
            $table->timestamp('modified', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cong_dans');
    }
};
