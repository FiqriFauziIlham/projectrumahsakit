<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->integer('NomorRekamMedis')->unique();
            $table->string('namaPasien');
            $table->date('tanggalLahir');
            $table->enum('jenisKelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamatPasien');
            $table->string('kotaPasien');
            $table->string('usiaPasien');
            $table->string('penyakitPasien');
            $table->unsignedBigInteger('idDokter');
            $table->foreign('idDokter')->references('id')->on('dokters')->onDelete('cascade');
            $table->date('tanggalMasuk');
            $table->date('tanggalKeluar')->nullable();
            $table->unsignedBigInteger('nomorKamar'); // Tambahkan kolom baru untuk foreign key ke id ruangan
            $table->foreign('nomorKamar')->references('id')->on('ruangan')->onDelete('cascade'); // Foreign key ke id ruangan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
};
