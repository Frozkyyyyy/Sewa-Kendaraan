<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\KendaraanFotoModel;
use CodeIgniter\HTTP\ResponseInterface;

class KendaraanFotoController extends BaseController
{
    protected $fotoModel;

    public function __construct()
    {
        $this->fotoModel = new KendaraanFotoModel();
    }

    // =========================
    // GET: /api/foto-kendaraan/{id_kendaraan}
    // =========================
    public function index($id_kendaraan)
    {
        $data = $this->fotoModel
            ->where('id_kendaraan', $id_kendaraan)
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/foto-kendaraan
    // =========================
    public function create()
    {
        $id_kendaraan = $this->request->getPost('id_kendaraan');
        $file         = $this->request->getFile('foto');

        if (!$file || !$file->isValid()) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status'  => false,
                    'message' => 'File foto tidak valid'
                ]);
        }

        // Validasi ekstensi
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($file->getExtension(), $allowed)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Format foto tidak didukung'
                ]);
        }

        // Generate nama file
        $namaFoto = $file->getRandomName();
        $file->move('uploads/kendaraan', $namaFoto);

        $this->fotoModel->insert([
            'id_kendaraan' => $id_kendaraan,
            'foto'         => $namaFoto
        ]);

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'Foto kendaraan berhasil diupload',
                'foto'    => $namaFoto
            ]);
    }

    // =========================
    // DELETE: /api/foto-kendaraan/{id_foto}
    // =========================
    public function delete($id_foto)
    {
        $data = $this->fotoModel->find($id_foto);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Foto tidak ditemukan'
                ]);
        }

        // Hapus file fisik
        $path = 'uploads/kendaraan/' . $data['foto'];
        if (file_exists($path)) {
            unlink($path);
        }

        $this->fotoModel->delete($id_foto);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Foto kendaraan berhasil dihapus'
        ]);
    }
}
