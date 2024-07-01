<?php

namespace App\Repository;

use App\DTO\RegisterDTO;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public EntityManagerInterface $entityManagerInterface;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManagerInterface,
    )
    {
        $this->entityManagerInterface = $entityManagerInterface;

        parent::__construct($registry, User::class);
    }

    public function findUserByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $email)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function create(RegisterDTO $registerDTO): User
    {
        $user = new User();

        $hashedPassword = password_hash($registerDTO->getPassword(), PASSWORD_BCRYPT);

        $user->setEmail($registerDTO->getEmail());
        $user->setPassword($hashedPassword);
        $user->setFullName($registerDTO->getFullName());
        $user->setDateOfBirth(new \DateTime($registerDTO->getDateOfBirth()));
        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        $user->unsetPassword();

        return $user;
    }
}
