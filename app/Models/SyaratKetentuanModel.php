<?php

namespace App\Models;

use CodeIgniter\Model;

class SyaratKetentuanModel extends Model
{
    // Nama tabel
    protected $table = 'syarat_ketentuan';

    // Primary key
    protected $primaryKey = 'id_syarat';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'isi',
        'aktif'
    ];

    // Timestamp
    // Tabel syarat_ketentuan TIDAK punya created_at & updated_at
    protected $useTimestamps = false;

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'isi'   => 'required',
        'aktif' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'isi' => [
            'required' => 'Isi syarat dan ketentuan tidak boleh kosong'
        ]
    ];

    protected $skipValidation = false;
}
