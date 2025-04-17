<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher
    )
    {
    }
    public function register(User $user)
    {
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));


        $this->em->persist($user);
        $this->em->flush();
    }
}