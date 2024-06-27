<?php

namespace App\Service;

use App\DTO\RegisterDTO;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RegisterService
{
    public function __construct(
        public UserRepository $userRepository
    )
    {
    }

    public function register(RegisterDTO $registerDTO): User
    {
        if ($registerDTO->getPassword() !== $registerDTO->getPasswordConfirmation()) {
            throw new HttpException(statusCode: 409, message: 'Password mismatch');
        }

        $userAlreadyExists = $this->userRepository->findUserByEmail($registerDTO->getEmail());

        if ($userAlreadyExists) {
            throw new HttpException(statusCode: 409, message: 'Cannot register user with this email');
        }

        return $this->userRepository->create($registerDTO);
    }
}