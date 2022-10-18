<?php

namespace App\Controller;

use App\Entity\Franchisee;
use App\Entity\Structure;
use App\Form\FranchiseeType;
use App\Repository\FranchiseeRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FranchiseeController extends AbstractController {

  #[Route("/create-franchisee", name: "create_franchisee")]
  public function create(Request $request, ManagerRegistry $doctrine): Response {
    $franchisee = new Franchisee();

    $franchiseeForm = $this->createForm(FranchiseeType::class, $franchisee);
    $franchiseeForm->handleRequest($request);

    if ($franchiseeForm->isSubmitted() && $franchiseeForm->isValid()) {
      $em = $doctrine->getManager();
      $em->persist($franchisee);
      $em->flush();
      return $this->redirectToRoute("franchisee_list");
    }

    return $this->renderForm("franchisee/create.html.twig", [
        "franchiseeForm" => $franchiseeForm
    ]);
  }

  #[Route("/franchisee-list", name: "franchisee_list")]
  public function getAll(ManagerRegistry $doctrine): Response {
    $repo = $doctrine->getRepository(Franchisee::class);
    $franchisees = $repo->findAll();
    
    return $this->renderForm("franchisee/list.html.twig", [
      "franchisees" => $franchisees,
    ]);
  }
  
  #[Route("/franchisee-details/{id}", name: "franchisee_details")]
  public function getDetails(ManagerRegistry $doctrine, int $id): Response {
    
    $repo = $doctrine->getRepository(Franchisee::class);
    $franchisee = $repo->find($id);
    $repo = $doctrine->getRepository(Structure::class);
    $structures = $repo->findAll();
      
      return $this->renderForm("franchisee/details.html.twig", [
        "franchisee" => $franchisee,
        "structures" => $structures
    ]);
  }

  #[Route("/update-franchisee/{id}", name: "update_franchisee")]
  public function update(StructureRepository $er, Request $request, ManagerRegistry $doctrine, Franchisee $franchisee): Response {

    $franchiseeForm = $this->createForm(FranchiseeType::class, $franchisee);
    $franchiseeForm->handleRequest($request);
   
    if ($franchiseeForm->isSubmitted() && $franchiseeForm->isValid()) {
      
      $er->changeStatus();
      $doctrine->getManager()->flush();
      $this->addFlash('error', 'Franchisé modifié');
      return $this->redirectToRoute("franchisee_list");
    }

    return $this->renderForm("franchisee/create.html.twig", [
        "franchiseeForm" => $franchiseeForm,
        "franchisee" => $franchisee
    ]);
  }

  #[Route("/delete-franchisee/{id}", name: "delete_franchisee")]
  public function delete(ManagerRegistry $doctrine, Franchisee $franchisee): Response {

    $em = $doctrine->getManager();
    $em->remove($franchisee);
    $em->flush();
    return $this->redirectToRoute("franchisee_list");
  }

}