<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    // Nama tabel
    protected $table = 'faq';

    // Primary key
    protected $primaryKey = 'id_faq';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'pertanyaan',
        'jawaban',
        'aktif'
    ];

    // Timestamp
    // Tabel FAQ tidak memiliki created_at & updated_at
    protected $useTimestamps = false;
    protected $createdField  = null;
    protected $updatedField  = null;

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'pertanyaan' => 'required|min_length[5]',
        'jawaban'    => 'required|min_length[5]',
        'aktif'      => 'in_list[0,1]'
    ];

    protected $validationMessages = [
        'pertanyaan' => [
            'required' => 'Pertanyaan wajib diisi'
        ],
        'jawaban' => [
            'required' => 'Jawaban wajib diisi'
        ]
    ];

    protected $skipValidation = false;
}
