<?php

namespace App\Models;

use CodeIgniter\Model;

class KendaraanModel extends Model
{
    // Nama tabel
    protected $table = 'kendaraan';

    // Primary key
    protected $primaryKey = 'id_kendaraan';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'jenis',
        'nama_kendaraan',
        'tahun',
        'kapasitas',
        'warna',
        'transmisi',
        'harga_per_hari',
        'status',
        'deskripsi'
    ];

    // Timestamp
    // Tabel hanya memiliki created_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'jenis'           => 'required|in_list[mobil,motor]',
        'nama_kendaraan'  => 'required|min_length[3]',
        'tahun'           => 'required|numeric|exact_length[4]',
        'kapasitas'       => 'required|integer',
        'transmisi'       => 'required|in_list[manual,matic]',
        'harga_per_hari'  => 'required|decimal',
        'status'          => 'in_list[tersedia,tidak tersedia]'
    ];

    protected $validationMessages = [
        'jenis' => [
            'in_list' => 'Jenis kendaraan harus mobil atau motor'
        ],
        'transmisi' => [
            'in_list' => 'Transmisi harus manual atau matic'
        ],
        'status' => [
            'in_list' => 'Status tidak valid'
        ]
    ];

    protected $skipValidation = false;
}
