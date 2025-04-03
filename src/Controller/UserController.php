<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Role\Role;

#[Route('/users', name: '_users')]
final class UserController extends AbstractController
{

    #[Route('/add_admin', name: '_add_admin')]
    public function add_admin(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            $user
                ->setPassword($userPasswordHasher->hashPassword($user, $plainPassword))
                ->setRoles(['ROLE_ADMIN']); // Role de tous les nouveaux admin

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render("ajout nouveau utilisateur admin réussie");

        }

        return $this->render('users/add_admin.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/showall', name: '_showall')]
    public function userList(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        $args = array(
            'users' => $users,
        );
        return $this->render('users/list.html.twig', $args);

    }
}
