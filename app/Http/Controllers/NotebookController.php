<?php

namespace App\Http\Controllers;

use App\Models\Notebook;
use App\Http\Requests\StoreNotebookRequest;
use App\Http\Requests\UpdateNotebookRequest;
use App\Http\Requests\IndexNotebookRequest;
use App\Interfaces\NotebookRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\NotebookResource;
use App\Http\Resources\PaginationNotebookResource;
use Illuminate\Support\Facades\DB;

class NotebookController extends Controller
{
    
    private NotebookRepositoryInterface $notebookRepositoryInterface;
    
    public function __construct(NotebookRepositoryInterface $notebookRepositoryInterface)
    {
        $this->NotebookRepositoryInterface = $notebookRepositoryInterface;
    }
    
    /**
     * @OA\Get(
     *     path="/notebook",
     *     summary="Get list of notebooks",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/NotebookResource")),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(IndexNotebookRequest $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);
    
        $data = $this->NotebookRepositoryInterface->index($page, $perPage);
    
        return ApiResponseClass::sendResponse(new PaginationNotebookResource($data), '', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/notebook",
     *     summary="Create a new notebook",
     *     tags={"Notebooks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreNotebookRequest")
     *     ),
     *     @OA\Response(response=201, description="Notebook created successfully", @OA\JsonContent(ref="#/components/schemas/NotebookResource")),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreNotebookRequest $request)
    {
        $details =[
            'full_name' => $request->full_name,
            'company' => $request->company,
            'phone' => $request->phone,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'photo' => $request->photo
        ];
        DB::beginTransaction();
        try{
             $notebook = $this->NotebookRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new NotebookResource($notebook), 'Notebook Create Successful', 201);
        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Get(
     *     path="/notebook/{id}",
     *     summary="Get a notebook by ID",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/NotebookResource")),
     *     @OA\Response(response=404, description="Notebook not found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show($id)
    {
        $notebook = $this->NotebookRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(new NotebookResource($notebook), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notebook $notebook)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/notebook/{id}",
     *     summary="Update a notebook",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateNotebookRequest")
     *     ),
     *     @OA\Response(response=200, description="Notebook updated successfully", @OA\JsonContent(ref="#/components/schemas/NotebookResource")),
     *     @OA\Response(response=404, description="Notebook not found"),
     *     @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(UpdateNotebookRequest $request, $id)
    {
        $updateDetails = $request->only([
            'full_name',
            'company',
            'phone',
            'email',
            'birth_date',
            'photo'
        ]);
    
        DB::beginTransaction();
        try {
            $notebook = $this->NotebookRepositoryInterface->update($updateDetails, $id);
            DB::commit();
            return ApiResponseClass::sendResponse('', 'Notebook Update Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @OA\Delete(
     *     path="/notebook/{id}",
     *     summary="Delete a notebook",
     *     tags={"Notebooks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Notebook deleted successfully"),
     * )
     */
    public function destroy($id)
    {
         $this->NotebookRepositoryInterface->delete($id);
        return ApiResponseClass::sendResponse('', 'Notebook Delete Successful', 204);
    }
}
