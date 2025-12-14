<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PersetujuanSyaratModel;
use CodeIgniter\HTTP\ResponseInterface;

class PersetujuanSyaratController extends BaseController
{
    protected $persetujuanModel;

    public function __construct()
    {
        $this->persetujuanModel = new PersetujuanSyaratModel();
    }

    // =========================
    // GET: /api/persetujuan
    // =========================
    public function index()
    {
        $data = $this->persetujuanModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // GET: /api/persetujuan/{id}
    // =========================
    public function show($id)
    {
        $data = $this->persetujuanModel->find($id);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data persetujuan tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/persetujuan
    // =========================
    public function create()
    {
        $data = $this->request->getJSON(true);

        $insertData = [
            'id_sewa'      => $data['id_sewa'] ?? null,
            'disetujui'    => $data['disetujui'] ?? 1,
            'waktu_setuju' => date('Y-m-d H:i:s')
        ];

        if (!$this->persetujuanModel->insert($insertData)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->persetujuanModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'Persetujuan syarat berhasil disimpan'
            ]);
    }

    // =========================
    // PUT: /api/persetujuan/{id}
    // =========================
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->persetujuanModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data persetujuan tidak ditemukan'
                ]);
        }

        if (!isset($data['disetujui'])) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Field disetujui wajib diisi'
                ]);
        }

        $updateData = [
            'disetujui'    => $data['disetujui'],
            'waktu_setuju' => $data['disetujui'] ? date('Y-m-d H:i:s') : null
        ];

        $this->persetujuanModel->update($id, $updateData);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Persetujuan syarat berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/persetujuan/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->persetujuanModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Data persetujuan tidak ditemukan'
                ]);
        }

        $this->persetujuanModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data persetujuan berhasil dihapus'
        ]);
    }

    // =========================
    // GET: /api/persetujuan/sewa/{id_sewa}
    // =========================
    public function bySewa($id_sewa)
    {
        $data = $this->persetujuanModel
            ->where('id_sewa', $id_sewa)
            ->first();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }
}
