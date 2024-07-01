<?php

namespace App\Service;

use App\DTO\LoginDTO;
use App\DTO\RegisterDTO;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    public function __construct(
        public UserRepository $userRepository,
        public JWTService $jwtService
    )
    {}

    public function register(RegisterDTO $registerDTO): User
    {
        if ($registerDTO->getPassword() !== $registerDTO->getPasswordConfirmation()) {
            throw new HttpException(statusCode: 409, message: 'Password confirmation must be equal to password.');
        }

        $userAlreadyExists = $this->userRepository->findUserByEmail($registerDTO->getEmail());

        if ($userAlreadyExists) {
            throw new HttpException(statusCode: 409, message: 'Cannot register user with this email.');
        }

        return $this->userRepository->create($registerDTO);
    }

    public function login(LoginDTO $loginDTO): string
    {
        $user = $this->userRepository->findUserByEmail($loginDTO->getEmail());

        if (!$user) {
            throw new HttpException(statusCode: 409, message: 'Invalid credentials');
        }

        if (password_verify($loginDTO->getPassword(), $user->getPassword())) {
            throw new HttpException(statusCode: 409, message: 'Invalid credentials');
        }

        return $this->jwtService->encode([
            'id' => $user['id'],
            'email' => $user['email'],
            'fullName' => $user['fullName'],
        ]);
    }
}