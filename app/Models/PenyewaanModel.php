<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyewaanModel extends Model
{
    // Nama tabel
    protected $table = 'penyewaan';

    // Primary key
    protected $primaryKey = 'id_sewa';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'kode_booking',
        'id_user',
        'id_kendaraan',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'total_harga',
        'status'
    ];

    // Timestamp
    // Tabel penyewaan hanya memiliki created_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // tidak ada updated_at

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'kode_booking'    => 'required|min_length[5]|is_unique[penyewaan.kode_booking,id_sewa,{id_sewa}]',
        'id_user'         => 'required|integer',
        'id_kendaraan'    => 'required|integer',
        'tanggal_mulai'   => 'required|valid_date',
        'tanggal_selesai' => 'required|valid_date',
        'durasi'          => 'required|integer',
        'total_harga'     => 'required|decimal',
        'status'          => 'permit_empty|in_list[aktif,selesai,ditolak]'
    ];

    protected $validationMessages = [
        'kode_booking' => [
            'is_unique' => 'Kode booking sudah digunakan'
        ],
        'tanggal_mulai' => [
            'valid_date' => 'Tanggal mulai tidak valid'
        ],
        'tanggal_selesai' => [
            'valid_date' => 'Tanggal selesai tidak valid'
        ]
    ];

    protected $skipValidation = false;
}
