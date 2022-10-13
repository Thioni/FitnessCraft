<?php

namespace App\Controller;

use App\Entity\FeaturesList;
use App\Form\FeaturesListType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FeaturesListController extends AbstractController {

  #[Route("/create-featuresList", name: "create_featuresList")]
  public function create(Request $request, ManagerRegistry $doctrine): Response {
    $featuresList = new featuresList();

    $featuresListForm = $this->createForm(featuresListType::class, $featuresList);
    $featuresListForm->handleRequest($request);

    if ($featuresListForm->isSubmitted() && $featuresListForm->isValid()) {

      if (!$featuresList->structureCheck()) {
        $this->addFlash('error', 'Création impossible: la structure choisie dispose déja d\'une liste de permissions');
        return $this->redirectToRoute('featuresList_list');
      }
      
        $em = $doctrine->getManager();
        $em->persist($featuresList);
        $em->flush();
        return $this->redirectToRoute("featuresList_list");
    }

    return $this->renderForm("featuresList/create.html.twig", [
        "featuresListForm" => $featuresListForm
    ]);
  }

  #[Route("/featuresList-list", name: "featuresList_list")]
  public function getAll(ManagerRegistry $doctrine): Response {
    $repo = $doctrine->getRepository(featuresList::class);
    $featuresLists = $repo->findAll();

    return $this->renderForm("featuresList/list.html.twig", [
        "featuresLists" => $featuresLists
    ]);
  }

  #[Route("/featuresList-details/{id}", name: "featuresList_details")]
  public function getDetails(ManagerRegistry $doctrine, int $id): Response {

    $repo = $doctrine->getRepository(featuresList::class);
    $featuresList = $repo->find($id);

    return $this->renderForm("featuresList/details.html.twig", [
        "featuresList" => $featuresList
    ]);
  }

  #[Route("/update-featuresList/{id}", name: "update_featuresList")]
  public function update(Request $request, ManagerRegistry $doctrine, featuresList $featuresList): Response {

    $featuresListForm = $this->createForm(featuresListType::class, $featuresList);
    $featuresListForm->handleRequest($request);


    if ($featuresListForm->isSubmitted() && $featuresListForm->isValid()) {

      $doctrine->getManager()->flush();
      $this->addFlash('error', 'Options modifiées');
      return $this->redirectToRoute("featuresList_list");
    }

    return $this->renderForm("featuresList/create.html.twig", [
        "featuresListForm" => $featuresListForm,
        "featuresList" => $featuresList
    ]);
  }

  #[Route("/delete-featuresList/{id}", name: "delete_featuresList")]
  public function delete(ManagerRegistry $doctrine, featuresList $featuresList): Response {

    $em = $doctrine->getManager();
    $em->remove($featuresList);
    $em->flush();
    return $this->redirectToRoute("featuresList_list");
  }

}