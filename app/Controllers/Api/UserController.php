<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // =========================
    // GET: /api/users
    // =========================
    public function index()
    {
        $users = $this->userModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $users
        ]);
    }

    // =========================
    // POST: /api/users
    // =========================
    public function create()
    {
        $data = $this->request->getJSON(true);

        $insertData = [
            'nama_lengkap' => $data['nama_lengkap'] ?? null,
            'email'        => $data['email'] ?? null,
            'no_telepon'   => $data['no_telepon'] ?? null,
            'password'     => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'         => $data['role'] ?? 'penyewa',
        ];

        if (!$this->userModel->insert($insertData)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->userModel->errors()
                ]);
        }

        return $this->response->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'User berhasil dibuat'
            ]);
    }

    // =========================
    // GET: /api/users/{id}
    // =========================
    public function show($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'User tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $user
        ]);
    }

    // =========================
    // PUT: /api/users/{id}
    // =========================
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->userModel->find($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status' => false,
                    'message' => 'User tidak ditemukan'
                ]);
        }

        $updateData = [
            'nama_lengkap' => $data['nama_lengkap'] ?? null,
            'email'        => $data['email'] ?? null,
            'no_telepon'   => $data['no_telepon'] ?? null,
            'role'         => $data['role'] ?? null,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (!$this->userModel->update($id, $updateData)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->userModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'User berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/users/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->userModel->find($id)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status' => false,
                    'message' => 'User tidak ditemukan'
                ]);
        }

        $this->userModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'User berhasil dihapus'
        ]);
    }

    // =========================
    // POST: /api/login
    // =========================
    public function login()
    {
        $data = $this->request->getJSON(true);

        $user = $this->userModel
            ->where('email', $data['email'])
            ->first();

        if (!$user || !password_verify($data['password'], $user['password'])) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                ->setJSON([
                    'status' => false,
                    'message' => 'Email atau password salah'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'id_user' => $user['id_user'],
                'nama'    => $user['nama_lengkap'],
                'email'   => $user['email'],
                'role'    => $user['role']
            ]
        ]);
    }
}
