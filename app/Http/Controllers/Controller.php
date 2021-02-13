<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $statusCode = 200;

    /**
     * Getter for statusCode
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     * @return self
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Generates a Response with a 200 HTTP header and a given message.
     *
     * @param array $data
     * @return JsonResponse
     */
    protected function respondWithArray(array $data): JsonResponse
    {
        return new JsonResponse($data, $this->statusCode, [ 'Content-Type' => 'application/json' ]);
    }

    /**
     * Generates a Error Response by given message.
     *
     * @param array $message
     * @return JsonResponse
     */
    protected function respondWithError(array $message): JsonResponse
    {
        return $this->respondWithArray($message);
    }

    /**
     * Generates a Response with a 201 HTTP header and a given item.
     *
     * @param array $item
     * @return JsonResponse
     */
    protected function respondWithItem(array $item): JsonResponse
    {
        return $this->setStatusCode(201)->respondWithArray($item);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function errorNotFound(string $message = "Respond Not Found"): JsonResponse
    {
        return $this->setStatusCode(404)->respondWithError([ "error" => $message ]);
    }
}
