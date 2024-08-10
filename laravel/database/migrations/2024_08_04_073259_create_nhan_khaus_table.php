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
        Schema::create('nhan_khaus', function (Blueprint $table) {
            $table->id();
            $table->integer('hop_dong_id');
            $table->integer('cong_dan_id');
            $table->string('mqh_chu_phong',20);
            $table->string('status', 10);
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
        Schema::dropIfExists('nhan_khaus');
    }
};
