<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    const DEFAULT_PAGINATION_NUMBER = 15;

    private UserRepository $userRepository;
    private WalletRepository $walletRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(array $data): User
    {

        $user = $this->userRepository->store($data);
        $this->walletRepository->store(['user_id' => $user->id]);
        return $user;
    }

    public function getById(int $id): ?User
    {
        return $this->userRepository->getById($id);
    }

    public function update(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    public function getAllPaginated(): LengthAwarePaginator
    {
        return $this->userRepository->paginate(self::DEFAULT_PAGINATION_NUMBER);
    }

    public function destroy(int $id): void
    {
        $this->userRepository->destroy($id);
    }

}
