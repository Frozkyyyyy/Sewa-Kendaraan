<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\SyaratKetentuanModel;
use CodeIgniter\HTTP\ResponseInterface;

class SyaratKetentuanController extends BaseController
{
    protected $syaratModel;

    public function __construct()
    {
        $this->syaratModel = new SyaratKetentuanModel();
    }

    // =========================
    // GET: /api/syarat
    // Ambil semua syarat
    // =========================
    public function index()
    {
        $data = $this->syaratModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // GET: /api/syarat/aktif
    // Ambil syarat yang aktif saja
    // =========================
    public function aktif()
    {
        $data = $this->syaratModel
            ->where('aktif', 1)
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/syarat
    // Tambah syarat baru
    // =========================
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->syaratModel->insert($data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->syaratModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'Syarat & ketentuan berhasil ditambahkan'
            ]);
    }

    // =========================
    // GET: /api/syarat/{id}
    // =========================
    public function show($id)
    {
        $data = $this->syaratModel->find($id);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // PUT: /api/syarat/{id}
    // =========================
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->syaratModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
        }

        if (!$this->syaratModel->update($id, $data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->syaratModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Syarat & ketentuan berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/syarat/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->syaratModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
        }

        $this->syaratModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Syarat & ketentuan berhasil dihapus'
        ]);
    }
}
