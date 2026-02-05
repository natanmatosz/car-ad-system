<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {

    }

    public function store(UserRequest $request): JsonResponse
    {
        $this->service->create($request->toDto());

        return response()->json([
            'message' => 'user was created successfully'
        ], Response::HTTP_CREATED);
    }
}
