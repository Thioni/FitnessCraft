<?php

namespace App\Controller;

use App\Entity\FeaturesList;
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

  #[Route("admin/create-franchisee", name: "create_franchisee")]
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

  #[Route("admin/franchisee-list", name: "franchisee_list")]
  public function getAll(Request $request, FranchiseeRepository $repo): Response {
    $search = $request->request->get("search");
    $franchisees = $repo->findAll();
    if ($search) {
      $franchisees = $repo->findBySearch($search);
    }
    
    return $this->renderForm("franchisee/list.html.twig", [
      "franchisees" => $franchisees,
    ]);
  }
  
  #[Route("admin/franchisee-details/{id}", name: "franchisee_details")]
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

  #[Route("/franchisee-account", name: "franchisee_account")]
  public function getAccount(ManagerRegistry $doctrine): Response {
    
    $repo = $doctrine->getRepository(Franchisee::class);
    $franchisee = $repo->findAll();
    $repo = $doctrine->getRepository(Structure::class);
    $structures = $repo->findAll();
    $repo = $doctrine->getRepository(FeaturesList::class);
    $featuresList = $repo->findAll();
      
      return $this->renderForm("franchisee/account.html.twig", [
        "franchisee" => $franchisee,
        "structures" => $structures,
        "featuresList" => $featuresList
    ]);
  }

  #[Route("admin/update-franchisee/{id}", name: "update_franchisee")]
  public function update(StructureRepository $er, Request $request, ManagerRegistry $doctrine, Franchisee $franchisee): Response {

    $franchiseeForm = $this->createForm(FranchiseeType::class, $franchisee);
    $franchiseeForm->handleRequest($request);
   
    if ($franchiseeForm->isSubmitted() && $franchiseeForm->isValid()) {
      
      $doctrine->getManager()->flush();
      $er->changeStatus();
      $this->addFlash('error', 'Franchis?? modifi??');
      return $this->redirectToRoute("franchisee_list");
    }

    return $this->renderForm("franchisee/create.html.twig", [
        "franchiseeForm" => $franchiseeForm,
        "franchisee" => $franchisee
    ]);
  }

  #[Route("admin/delete-franchisee/{id}", name: "delete_franchisee")]
  public function delete(ManagerRegistry $doctrine, Franchisee $franchisee): Response {

    $em = $doctrine->getManager();
    $em->remove($franchisee);
    $em->flush();
    return $this->redirectToRoute("franchisee_list");
  }
  
}