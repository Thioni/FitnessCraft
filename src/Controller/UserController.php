<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController {

  #[Route("admin/create-franchisee-user", name: "create_franchisee_user")]
  #[Route("admin/create-structure-user", name: "create_structure_user")]
  public function create(Request $request, ManagerRegistry $doctrine): Response {
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

      $em->persist($user);
      $em->flush();
      return $this->redirectToRoute("franchisee_list");
    }

    return $this->renderForm("user/account.html.twig", [
        "userForm" => $userForm
    ]);
  }

}