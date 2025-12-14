<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama tabel
    protected $table = 'users';

    // Primary key
    protected $primaryKey = 'id_user';

    // Auto increment
    protected $useAutoIncrement = true;

    // Return type (object / array)
    protected $returnType = 'array';

    // Field yang boleh diisi (wajib!)
    protected $allowedFields = [
        'nama_lengkap',
        'email',
        'no_telepon',
        'password',
        'role',
        'foto'
    ];

    // Timestamp
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi (opsional tapi disarankan)
    protected $validationRules = [
        'nama_lengkap' => 'required|min_length[3]',
        'email'        => 'required|valid_email|is_unique[users.email,id_user,{id_user}]',
        'no_telepon'   => 'required|min_length[10]',
        'password'     => 'required|min_length[6]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah terdaftar'
        ]
    ];

    protected $skipValidation = false;
}
