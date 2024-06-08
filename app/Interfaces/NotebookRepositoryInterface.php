<?php

namespace App\Interfaces;

interface NotebookRepositoryInterface
{
    public function index($page, $perPage);
    public function getById($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
