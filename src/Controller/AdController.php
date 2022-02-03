<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Form\SearchAdCommand;
use App\Form\SearchAdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UploadHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/')]
class AdController extends AbstractController
{
    #[Route('/', name: 'ad_index', methods: ['GET', 'POST'])]
    public function index(Request $request, AdRepository $adRepository): Response
    {
        $form = $this
            ->createForm(SearchAdType::class, $searchAdCommand = new SearchAdCommand)
            ->handleRequest($request);

        $ads = $adRepository->search($searchAdCommand);

        return $this->render('ad/index.html.twig', [
            'ads'  => $ads,
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws FilesystemException
     */
    #[Route('/annonces/ajouter', name: 'ad_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager, UploadHelper $helper): Response
    {
        $ad = new Ad();
        $form = $this
            ->createForm(AdType::class, $ad)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newFile = $form['imageFile']->getData();

            if($newFile) {
                $fileName = $helper->uploadAdImage($newFile);
                $ad->setImageFilename($fileName);
            }

            $ad->setCreatedAt(new \DateTime('now'));
            $entityManager->persist($ad);
            $entityManager->flush();

            $this->addFlash('success', 'L\'annonce a bien été créée');

            return $this->redirectToRoute('ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/annonces/{id}', name: 'ad_show', methods: ['GET'])]
    public function show(Ad $ad): Response
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * @throws FilesystemException
     */
    #[Route('/annonces/{id}/modifier', name: 'ad_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Ad $ad, EntityManagerInterface $entityManager, UploadHelper $helper): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $form['imageFile']->getData();

            if($newFile) {
                $fileName = $helper->uploadAdImage($newFile, $ad->getImageFilename());
                $ad->setImageFilename($fileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('ad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form,
        ]);
    }

    #[Route('/annonces/{id}', name: 'ad_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Ad $ad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ad_index', [], Response::HTTP_SEE_OTHER);
    }
}
