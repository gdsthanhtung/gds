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
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->integer('hop_dong_id');

            $table->date('tu_ngay');
            $table->date('den_ngay');

            $table->integer('chi_so_dien_ky_truoc');
            $table->integer('chi_so_nuoc_ky_truoc');
            $table->integer('chi_so_dien');
            $table->integer('chi_so_nuoc');

            $table->boolean('huong_dinh_muc_dien');
            $table->boolean('huong_dinh_muc_nuoc');
            $table->string('is_city', 10);

            $table->text('range_dien');   //json
            $table->text('range_nuoc');   //json

            $table->longText('chi_tiet_dien');   //json
            $table->longText('chi_tiet_nuoc');   //json

            $table->integer('tien_phong');  //Hop-dong
            $table->integer('tien_dien');   //Range-dinh-muc-enum
            $table->integer('tien_nuoc');   //Range-dinh-muc-enum
            $table->integer('tien_net');    //Enum
            $table->integer('tien_rac');    //Enum
            $table->integer('tong_cong');

            $table->string('chi_phi_khac'); //json

            $table->string('status', 10);
            $table->string('ghi_chu')->nullable();

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
        Schema::dropIfExists('hoa_dons');
    }
};
