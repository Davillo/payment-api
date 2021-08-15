<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AuthenticationStoreRequest;
use App\Services\AuthenticationService;
use Illuminate\Http\Response;

class AuthenticationController extends Controller
{
    private AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->middleware('auth:api', ['except' => 'store']);
        $this->authenticationService = $authenticationService;
    }

    public function store(AuthenticationStoreRequest $request)
    {
        $data = $this->authenticationService->authenticate($request->validated());
        return response()->json($data, Response::HTTP_CREATED);
    }

    public function show()
    {
        return response()->json(auth()->user());
    }

    public function update()
    {
       $data = $this->authenticationService->refresh(auth()->refresh());
       return $data;
    }

    public function destroy()
    {
        $this->authenticationService->logout();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
