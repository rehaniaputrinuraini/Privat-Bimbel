<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tr_keuangan', function (Blueprint $table) {
            $table->id('id_keuangan');
            $table->date('tanggal');
            $table->enum('kategori', ['pemasukan', 'pengeluaran', 'piutang', 'uang_muka']);
            $table->string('rincian', 255);
            $table->decimal('jumlah', 15, 0);
            $table->string('nama_murid', 100)->nullable();
            $table->string('bulan_periode', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tr_keuangan');
    }
};