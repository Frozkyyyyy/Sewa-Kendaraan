<?php

namespace App\Models;

use CodeIgniter\Model;

class DataPenyewaModel extends Model
{
    // Nama tabel
    protected $table = 'data_penyewa';

    // Primary key
    protected $primaryKey = 'id_data';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'id_sewa',
        'nik',
        'alamat',
        'no_hp',
        'foto_ktp',
        'foto_jaminan'
    ];

    // Timestamp
    // Tabel hanya memiliki created_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'id_sewa'       => 'required|integer',
        'nik'           => 'required|min_length[10]|max_length[20]',
        'alamat'        => 'required|min_length[5]',
        'no_hp'         => 'required|min_length[10]|max_length[20]',
        'foto_ktp'      => 'required',
        'foto_jaminan'  => 'required'
    ];

    protected $validationMessages = [
        'nik' => [
            'required' => 'NIK wajib diisi'
        ],
        'no_hp' => [
            'required' => 'Nomor HP wajib diisi'
        ]
    ];

    protected $skipValidation = false;
}
