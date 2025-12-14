<?php

namespace App\Models;

use CodeIgniter\Model;

class KendaraanFotoModel extends Model
{
    // Nama tabel
    protected $table = 'kendaraan_foto';

    // Primary key
    protected $primaryKey = 'id_foto';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'id_kendaraan',
        'foto'
    ];

    // Timestamp
    // Tabel kendaraan_foto TIDAK memiliki created_at & updated_at
    protected $useTimestamps = false;

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'id_kendaraan' => 'required|integer',
        'foto'         => 'required'
    ];

    protected $validationMessages = [
        'id_kendaraan' => [
            'required' => 'ID kendaraan wajib diisi'
        ],
        'foto' => [
            'required' => 'File foto kendaraan wajib diisi'
        ]
    ];

    protected $skipValidation = false;
}
