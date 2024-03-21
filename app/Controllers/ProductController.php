<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class ProductController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $model = new ProductModel();
        $data = $model->findAll();
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $model = new ProductModel();
        $data = $model->find(['id' => $id]);
        if ($data) {
            return $this->respond($data[0]);
        }
        return $this->failNotFound('Data tidak ditemukan');
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $json = $this->request->getJSON();
        $data = [
            'title' => $json->title,
            'price' => $json->price,
        ];
        $model = new ProductModel();
        $productId = $model->insert($data);
        if (!$productId) {
            return $this->fail('Gagal tersimpan', 400);
        }
        return $this->respondCreated($productId);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $json = $this->request->getJSON();
        $data = [
            'title' => $json->title,
            'price' => $json->price,
        ];
        $model = new ProductModel();

        $cekId = $model->find(['id' => $id]);
        if (!$cekId) {
            return $this->fail('Data tidak ditemukan', 404);
        }

        $isUpdated = $model->update($id, $data);
        if (!$isUpdated) {
            return $this->fail('Gagal tersimpan', 400);
        }
        return $this->respondUpdated($isUpdated, 'Data berhasil diupdate');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $model = new ProductModel();

        $cekId = $model->find(['id' => $id]);
        if (!$cekId) {
            return $this->fail('Data tidak ditemukan', 404);
        }

        $isDeleted = $model->delete($id);
        if (!$isDeleted) {
            return $this->fail('Gagal terhapus', 400);
        }
        return $this->respondDeleted($isDeleted, 'Data berhasil Terhapus');
    }
}
