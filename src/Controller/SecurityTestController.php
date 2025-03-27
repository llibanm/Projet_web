<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

//Ajoute les utilisateurs dans la BD

#[Route('/securitytest', name: '_securitytest')]
class SecurityTestController extends AbstractController
{
    #[Route('/addusers', name: '_addusers')]
    public function addUsersAction(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user
            ->setUsername('sadmin')
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $hashedPassword = $passwordHasher->hashPassword($user, 'nimdas');
        $user->setPassword($hashedPassword);
        $em->persist($user);

        $user = new User();
        $user
            ->setUsername('gilles')
            ->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $passwordHasher->hashPassword($user, 'sellig');
        $user->setPassword($hashedPassword);
        $em->persist($user);

        $user = new User();
        $user
            ->setUsername('rita')
            ->setRoles(['ROLE_CLIENT']);
        $hashedPassword = $passwordHasher->hashPassword($user, 'atir');
        $user->setPassword($hashedPassword);
        $em->persist($user);

        $user = new User();
        $user
            ->setUsername('boumedienne')
            ->setRoles(['ROLE_CLIENT']);
        $hashedPassword = $passwordHasher->hashPassword($user, 'enneidemuob');
        $user->setPassword($hashedPassword);
        $em->persist($user);

        $em->flush();

        return new Response('<body>Ajout 4 utilisateurs</body>');
    }
}
