<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DataPenyewaModel;
use CodeIgniter\HTTP\ResponseInterface;

class DataPenyewaController extends BaseController
{
    protected $dataPenyewaModel;

    public function __construct()
    {
        $this->dataPenyewaModel = new DataPenyewaModel();
    }

    // =========================
    // GET: /api/data-penyewa
    // =========================
    public function index()
    {
        $data = $this->dataPenyewaModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // GET: /api/data-penyewa/{id}
    // =========================
    public function show($id)
    {
        $data = $this->dataPenyewaModel->find($id);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data penyewa tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/data-penyewa
    // =========================
    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->dataPenyewaModel->insert($data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->dataPenyewaModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'Data penyewa berhasil ditambahkan'
            ]);
    }

    // =========================
    // PUT: /api/data-penyewa/{id}
    // =========================
    public function update($id)
    {
        if (!$this->dataPenyewaModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data penyewa tidak ditemukan'
                ]);
        }

        $data = $this->request->getRawInput();

        if (!$this->dataPenyewaModel->update($id, $data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->dataPenyewaModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data penyewa berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/data-penyewa/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->dataPenyewaModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data penyewa tidak ditemukan'
                ]);
        }

        $this->dataPenyewaModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data penyewa berhasil dihapus'
        ]);
    }

    // =========================
    // GET: /api/data-penyewa/sewa/{id_sewa}
    // =========================
    public function bySewa($id_sewa)
    {
        $data = $this->dataPenyewaModel
            ->where('id_sewa', $id_sewa)
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }
}
