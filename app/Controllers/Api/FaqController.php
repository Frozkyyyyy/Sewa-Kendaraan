<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\FaqModel;
use CodeIgniter\HTTP\ResponseInterface;

class FaqController extends BaseController
{
    protected $faqModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
    }

    // =========================
    // GET: /api/faq
    // =========================
    public function index()
    {
        $data = $this->faqModel->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // GET: /api/faq/{id}
    // =========================
    public function show($id)
    {
        $data = $this->faqModel->find($id);

        if (!$data) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'FAQ tidak ditemukan'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    // =========================
    // POST: /api/faq
    // =========================
    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$this->faqModel->insert($data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->faqModel->errors()
                ]);
        }

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON([
                'status'  => true,
                'message' => 'FAQ berhasil ditambahkan'
            ]);
    }

    // =========================
    // PUT: /api/faq/{id}
    // =========================
    public function update($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->faqModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'FAQ tidak ditemukan'
                ]);
        }

        if (!$this->faqModel->update($id, $data)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->faqModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'FAQ berhasil diperbarui'
        ]);
    }

    // =========================
    // DELETE: /api/faq/{id}
    // =========================
    public function delete($id)
    {
        if (!$this->faqModel->find($id)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'status'  => false,
                    'message' => 'FAQ tidak ditemukan'
                ]);
        }

        $this->faqModel->delete($id);

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'FAQ berhasil dihapus'
        ]);
    }

    // =========================
    // GET: /api/faq/aktif
    // =========================
    public function aktif()
    {
        $data = $this->faqModel->where('aktif', 1)->findAll();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }
}
