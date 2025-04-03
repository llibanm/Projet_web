<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/users', name: '_users')]
final class UserController extends AbstractController
{

    #[Route('/add_admin', name: '_add_admin')]
    public function add_admin()
    {

    }
}
