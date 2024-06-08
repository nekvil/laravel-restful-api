<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationNotebookResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) : array
    {

        return [
            'data'       => NotebookResource::collection($this->collection),
            'pagination' => [
                'total'       => $this->total(),
                'count'       => $this->count(),
                'perPage'     => $this->perPage(),
                'currentPage' => $this->currentPage(),
                'totalPages'  => $this->lastPage()
            ],
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'], $jsonResponse['meta']);
        $response->setContent($jsonResponse['data']);
    }
}
