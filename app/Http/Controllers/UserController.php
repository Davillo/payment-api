<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllPaginated();
        return response()->json($users, Response::HTTP_OK);
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->save($data);
        return response()->json(['data' => $user], Response::HTTP_CREATED);
    }

    public function update(int $id, UserStoreRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->update($id, $data);
        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    public function show(int $id)
    {
        $user = $this->userService->getById($id);
        return response()->json(['data' => $user], Response::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $this->userService->destroy($id);
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

}
