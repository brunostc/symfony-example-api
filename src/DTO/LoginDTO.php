<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class LoginDTO extends BaseDTO
{

    #[Type('string')]
    #[NotBlank()]
    public string $email;

    #[Type('string')]
    #[NotBlank()]
    public string $password;

    public function fromRequest(Request $request): void
    {
        $this->populate($request);
    }


    public function getData(): array
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
        ];
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
}