<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterDTO extends BaseDTO
{
    #[Type('string')]
    #[NotBlank()]
    protected string $fullName;

    #[Type('string')]
    #[NotBlank()]
    protected string $email;

    #[Type('string')]
    #[NotBlank()]
    protected string $password;

    #[Type('string')]
    #[NotBlank()]
    protected string $passwordConfirmation;

    #[Type('string')]
    #[NotBlank()]
    protected string $dateOfBirth;

    public function fromRequest(Request $request): void
    {
        $this->populate($request);
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

    public function setPasswordConfirmation(string $passwordConfirmation): void
    {
        $this->passwordConfirmation = $passwordConfirmation;
    }

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }
}