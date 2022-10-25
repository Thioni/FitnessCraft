<?php

namespace App\Controller;

use App\Entity\FeaturesList;
use App\Form\FeaturesListType;
use App\Repository\FeaturesListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class FeaturesListController extends AbstractController {

  #[Route("admin/create-featuresList", name: "create_featuresList")]
  public function create(Request $request, ManagerRegistry $doctrine): Response {
    $featuresList = new featuresList();

    $featuresListForm = $this->createForm(featuresListType::class, $featuresList);
    $featuresListForm->handleRequest($request);

    if ($featuresListForm->isSubmitted() && $featuresListForm->isValid()) {

        $em = $doctrine->getManager();
        $em->persist($featuresList);
        $em->flush();
        return $this->redirectToRoute("featuresList_list");
    }

    return $this->renderForm("featuresList/create.html.twig", [
        "featuresListForm" => $featuresListForm
    ]);
  }

  #[Route("admin/featuresList-list", name: "featuresList_list")]
  public function getAll(Request $request, FeaturesListRepository $repo): Response {
    $search = $request->request->get("search");
    $featuresLists = $repo->findAll();
    if ($search) {
      $featuresLists = $repo->findBySearch($search);
    }

    return $this->renderForm("featuresList/list.html.twig", [
        "featuresLists" => $featuresLists
    ]);
  }

  #[Route("admin/update-featuresList/{id}", name: "update_featuresList")]
  public function update(Request $request, ManagerRegistry $doctrine, featuresList $featuresList): Response {

    $featuresListForm = $this->createForm(featuresListType::class, $featuresList);
    $featuresListForm->handleRequest($request);


    if ($featuresListForm->isSubmitted() && $featuresListForm->isValid()) {

      $doctrine->getManager()->flush();
      $this->addFlash('error', 'Options sauvegardées');
      return $this->redirectToRoute("featuresList_list");
    }

    return $this->renderForm("featuresList/create.html.twig", [
        "featuresListForm" => $featuresListForm,
        "featuresList" => $featuresList
    ]);
  }

}