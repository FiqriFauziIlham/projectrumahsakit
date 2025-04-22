<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'NomorRekamMedis', 'namaPasien', 'tanggalLahir', 'jenisKelamin',
        'alamatPasien', 'kotaPasien', 'usiaPasien', 'penyakitPasien',
        'idDokter', 'tanggalMasuk', 'tanggalKeluar', 'nomorKamar'
    ];

    // Relasi ke Model Dokter (Foreign Key: idDokter)
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'idDokter');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'nomorKamar');
    }
}
