<?php

namespace App\Models;

use CodeIgniter\Model;

class PersetujuanSyaratModel extends Model
{
    // Nama tabel
    protected $table = 'persetujuan_syarat';

    // Primary key
    protected $primaryKey = 'id_persetujuan';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'id_sewa',
        'disetujui',
        'waktu_setuju'
    ];

    // Timestamp
    // Tabel persetujuan_syarat TIDAK memiliki created_at & updated_at
    protected $useTimestamps = false;

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'id_sewa'      => 'required|integer',
        'disetujui'    => 'permit_empty|in_list[0,1]',
        'waktu_setuju' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'id_sewa' => [
            'required' => 'ID sewa wajib diisi'
        ]
    ];

    protected $skipValidation = false;
}
