<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    const DEFAULT_PAGINATION_NUMBER = 15;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function save(array $data): User
    {
        return $this->userRepository->store($data);
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
