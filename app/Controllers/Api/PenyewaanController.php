<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PenyewaanModel;
use CodeIgniter\HTTP\ResponseInterface;

class PenyewaanController extends BaseController
{
    protected $penyewaanModel;

    public function __construct()
    {
        $this->penyewaanModel = new PenyewaanModel();
    }

    // =========================
    // GET: /api/penyewaan
    // =========================
    public function index()
    {
        $data = $this->penyewaanModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // GET: /api/penyewaan/{id}
    // =========================
    public function show($id)
    {
        $data = $this->penyewaanModel->find($id);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data penyewaan tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/penyewaan
    // =========================
    public function create()
    {
        $data = $this->request->getJSON(true);

        // Hitung durasi otomatis
        $mulai   = new \DateTime($data['tanggal_mulai']);
        $selesai = new \DateTime($data['tanggal_selesai']);
        $durasi  = $mulai->diff($selesai)->days + 1;

        $insertData = [
            'kode_booking'    => strtoupper(uniqid('BOOK-')),
            'id_user'         => $data['id_user'],
            'id_kendaraan'    => $data['id_kendaraan'],
            'tanggal_mulai'   => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'durasi'          => $durasi,
            'total_harga'     => $data['total_harga'],
            'status'          => 'aktif'
        ];

        if (!$this->penyewaanModel->insert($insertData)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->penyewaanModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'Penyewaan berhasil dibuat',
                'kode_booking' => $insertData['kode_booking']
            ]);
    }

    // =========================
    // PUT: /api/penyewaan/{id}
    // =========================
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->penyewaanModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data penyewaan tidak ditemukan'
                ]);
        }

        $this->penyewaanModel->update($id, $data);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data penyewaan berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/penyewaan/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->penyewaanModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data penyewaan tidak ditemukan'
                ]);
        }

        $this->penyewaanModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Penyewaan berhasil dihapus'
        ]);
    }

    // =========================
    // GET: /api/penyewaan/user/{id_user}
    // =========================
    public function byUser($id_user)
    {
        $data = $this->penyewaanModel
            ->where('id_user', $id_user)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // PUT: /api/penyewaan/status/{id}
    // =========================
    public function updateStatus($id)
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['status'])) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Status wajib diisi'
                ]);
        }

        $this->penyewaanModel->update($id, [
            'status' => $data['status']
        ]);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Status penyewaan berhasil diperbarui'
        ]);
    }
}
