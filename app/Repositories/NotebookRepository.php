<?php

namespace App\Repositories;

use App\Models\Notebook;
use App\Interfaces\NotebookRepositoryInterface;

class NotebookRepository implements NotebookRepositoryInterface
{
   public function index($page, $perPage){
      return Notebook::paginate($perPage, ['*'], 'page', $page);
   }

   public function getById($id){
      return Notebook::findOrFail($id);
   }

   public function store(array $data){
      return Notebook::create($data);
   }

   public function update(array $data, $id){
      return Notebook::whereId($id)->update($data);
   }
   
   public function delete($id){
      return Notebook::destroy($id);
   }
}
