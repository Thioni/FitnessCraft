<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/password-change', name: 'password_change')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();

        $passwordForm = $this->createForm(ChangePasswordType::class, $user); 
        $passwordForm ->handleRequest($request);

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $new_pwd =$passwordForm->get('new_password')->getData();
            $password = $passwordHasher->hashPassword($user, $new_pwd);

            $user->setPassword($password);
            $this->entityManager->flush();

            $user->getRoles();
            if (in_array("ROLE_FRANCHISEE", $user->getRoles())) {
              return $this->redirectToRoute("franchisee_account");
              } else if (in_array("ROLE_STRUCTURE", $user->getRoles())) {
                  return $this->redirectToRoute("structure_account");
              }
        }
        return $this->render('security/password.html.twig', [
            'passwordForm' =>$passwordForm->createView(),     
        ]);
    }
}