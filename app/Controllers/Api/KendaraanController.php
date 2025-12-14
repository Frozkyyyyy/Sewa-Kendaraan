<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KendaraanModel;
use CodeIgniter\HTTP\ResponseInterface;

class KendaraanController extends BaseController
{
    protected $kendaraanModel;

    public function __construct()
    {
        $this->kendaraanModel = new KendaraanModel();
    }

    // =========================
    // GET: /api/kendaraan
    // =========================
    public function index()
    {
        $data = $this->kendaraanModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // GET: /api/kendaraan/{id}
    // =========================
    public function show($id)
    {
        $data = $this->kendaraanModel->find($id);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data kendaraan tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/kendaraan
    // =========================
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->kendaraanModel->insert($data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status'  => false,
                    'errors'  => $this->kendaraanModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'Data kendaraan berhasil ditambahkan'
            ]);
    }

    // =========================
    // PUT: /api/kendaraan/{id}
    // =========================
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->kendaraanModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data kendaraan tidak ditemukan'
                ]);
        }

        if (!$this->kendaraanModel->update($id, $data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->kendaraanModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data kendaraan berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/kendaraan/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->kendaraanModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data kendaraan tidak ditemukan'
                ]);
        }

        $this->kendaraanModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data kendaraan berhasil dihapus'
        ]);
    }
}
