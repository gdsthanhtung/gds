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
        Schema::create('hop_dongs', function (Blueprint $table) {
            $table->id();
            $table->integer('ma_hop_dong');
            $table->integer('cong_dan_id');
            $table->integer('phong_id');
            $table->date('thue_tu_ngay');
            $table->date('thue_den_ngay');
            $table->integer('gia_phong');
            $table->integer('chi_so_dien');
            $table->integer('chi_so_nuoc');
            $table->boolean('huong_dinh_muc_dien');
            $table->boolean('huong_dinh_muc_nuoc');
            $table->boolean('use_internet');
            $table->string('status', 10);
            $table->string('ghi_chu');

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
        Schema::dropIfExists('hop_dongs');
    }
};
