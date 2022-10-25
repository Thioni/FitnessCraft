<?php

namespace App\Controller;

use App\Entity\FeaturesList;
use App\Entity\Structure;
use App\Form\FeaturesListType;
use App\Repository\FeaturesListRepository;
use App\Repository\FranchiseeRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
  public function update(StructureRepository $structure, FranchiseeRepository $franchisee, Request $request, ManagerRegistry $doctrine, featuresList $featuresList, MailerInterface $mailer): Response {

    $featuresListForm = $this->createForm(featuresListType::class, $featuresList);
    $featuresListForm->handleRequest($request);

    $structure = $featuresList->getStructure();
    $franchisee = $structure->getManagedBy();

    if ($featuresListForm->isSubmitted() && $featuresListForm->isValid()) {

      $doctrine->getManager()->flush();
      $this->addFlash('error', 'Options sauvegardées');

      $email = (new Email())
      ->from('fitnesscraftstaff@gmail.com')
      ->to($structure->getManagerEmail())
      ->addTo($franchisee->getEmail())
      ->subject('Options modifiées')
      ->text('Bonjour, nous vous informons que les options concernant la structure: '.$structure->getName().' ont été modifiées');

      $mailer->send($email);

      return $this->redirectToRoute("featuresList_list");
    }

    return $this->renderForm("featuresList/create.html.twig", [
        "featuresListForm" => $featuresListForm,
        "featuresList" => $featuresList
    ]);
  }

}