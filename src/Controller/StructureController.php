<?php

namespace App\Controller;

use App\Entity\FeaturesList;
use App\Entity\Franchisee;
use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class StructureController extends AbstractController {

  #[Route("admin/create-structure", name: "create_structure")]
  public function create(Request $request, ManagerRegistry $doctrine): Response {
    $structure = new structure();

    $structureForm = $this->createForm(structureType::class, $structure);
    $structureForm->handleRequest($request);

    if ($structureForm->isSubmitted() && $structureForm->isValid()) {
      $em = $doctrine->getManager();
      $em->persist($structure);
      $em->flush();
      return $this->redirectToRoute("structure_list");
    }

    return $this->renderForm("structure/create.html.twig", [
        "structureForm" => $structureForm
    ]);
  }

  #[Route("admin/structure-list", name: "structure_list")]
  public function getAll(Request $request, StructureRepository $repo): Response {
    $search = $request->request->get("search");
    $structures = $repo->findAll();
    if ($search) {
      $structures = $repo->findBySearch($search);
    }

    return $this->renderForm("structure/list.html.twig", [
        "structures" => $structures
    ]);
  }

  #[Route("admin/structure-details/{id}", name: "structure_details")]
  public function getDetails(ManagerRegistry $doctrine, int $id): Response {

    $repo = $doctrine->getRepository(structure::class);
    $structure = $repo->find($id);
    $repo = $doctrine->getRepository(FeaturesList::class);
    $featuresList = $repo->findAll();

    return $this->renderForm("structure/details.html.twig", [
        "structure" => $structure,
        "featuresList" => $featuresList
    ]);
  }

  #[Route("structure-account", name: "structure_account")]
  public function getAccount(ManagerRegistry $doctrine): Response {

    $repo = $doctrine->getRepository(Franchisee::class);
    $franchisee = $repo->findAll();
    $repo = $doctrine->getRepository(structure::class);
    $structure = $repo->findAll();
    $repo = $doctrine->getRepository(FeaturesList::class);
    $featuresList = $repo->findAll();

    return $this->renderForm("structure/account.html.twig", [
        "franchisee" => $franchisee,
        "structure" => $structure,
        "featuresList" => $featuresList
    ]);
  }

  #[Route("admin/update-structure/{id}", name: "update_structure")]
  public function update(Request $request, ManagerRegistry $doctrine, structure $structure): Response {

    $structureForm = $this->createForm(structureType::class, $structure);
    $structureForm->handleRequest($request);

    if ($structureForm->isSubmitted() && $structureForm->isValid()) {
      $doctrine->getManager()->flush();
      $this->addFlash('error', 'Structure modifiée');
      return $this->redirectToRoute("structure_list");
    }

    return $this->renderForm("structure/create.html.twig", [
        "structureForm" => $structureForm,
        "structure" => $structure
    ]);
  }

  #[Route("admin/delete-structure/{id}", name: "delete_structure")]
  public function delete(ManagerRegistry $doctrine, structure $structure): Response {

    $em = $doctrine->getManager();
    $em->remove($structure);
    $em->flush();
    return $this->redirectToRoute("structure_list");
  }

}