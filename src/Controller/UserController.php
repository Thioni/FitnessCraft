<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeEmailType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController {

  #[Route("admin/create-franchisee-user", name: "create_franchisee_user")]
  #[Route("admin/create-structure-user", name: "create_structure_user")]
  public function create(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher, MailerInterface $mailer): Response {
    $user = new User();

    $userForm = $this->createForm(UserType::class, $user);
    $userForm->handleRequest($request);

    if ($userForm->isSubmitted() && $userForm->isValid()) {
      $em = $doctrine->getManager();

        // Le rôle est attribué en fonction de la route utilisée pour accéder au formulaire
      if ($request->get('_route') == "create_franchisee_user") {
            $user->setRoles(['ROLE_FRANCHISEE']);
      } else if (($request->get('_route') == "create_structure_user")) {
                    $user->setRoles(['ROLE_STRUCTURE']);
      }
      
       // Envoi de l'email au nouvel utilisateur
      $email = (new Email())
      ->from('fitnesscraftstaff@gmail.com')
      ->to($user->getEmail())
      ->subject('Mot de passe temporaire')
      ->text('Bienvenue chez FitnessCraft! Votre mot de passe temporaire est: ' .$user->getPassword().
      ' il vous sera demandé de le changer à votre première connexion.');
      
      $mailer->send($email);

        // Hashage du mot de passe
      $user->setPassword(
        $userPasswordHasher->hashPassword(
          $user,
          $userForm->get('password')->getData()
        )
      );
      
      $em->persist($user);
      $em->flush();
      if ($request->get('_route') == "create_franchisee_user") {
          return $this->redirectToRoute("franchisee_list");
      } else if (($request->get('_route') == "create_structure_user")) {
            return $this->redirectToRoute("structure_list");
      }

    }

    return $this->renderForm("user/account.html.twig", [
        "userForm" => $userForm
    ]);
  }

  #[Route("admin/user-list", name: "user_list")]
  public function getAll(ManagerRegistry $doctrine): Response {
    $repo = $doctrine->getRepository(User::class);
    $users = $repo->findAll();
    
    return $this->renderForm("user/list.html.twig", [
      "users" => $users
    ]);
  }

  #[Route("admin/update-user/{id}", name: "update_user")]
  public function update(Request $request, ManagerRegistry $doctrine, User $user): Response {

    $mailForm = $this->createForm(ChangeEmailType::class, $user);
    $mailForm->handleRequest($request);

    if ($mailForm->isSubmitted() && $mailForm->isValid()) {
      $doctrine->getManager()->flush();
      $this->addFlash('error', 'Email modifiée');
      return $this->redirectToRoute("user_list");
    }

    return $this->renderForm("user/mail.html.twig", [
        "mailForm" => $mailForm,
        "user" => $user
    ]);
  }

  #[Route("admin/delete-user/{id}", name: "delete_user")]
  public function delete(ManagerRegistry $doctrine, User $user): Response {

    $em = $doctrine->getManager();
    $em->remove($user);
    $em->flush();
    return $this->redirectToRoute("user_list");
  }

}