<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdQuestion;
use App\Entity\Answer;
use App\Form\AdQuestionType;
use App\Form\AdType;
use App\Form\AnswerCollectionType;
use App\Form\AnswerType;
use App\Form\SearchAdCommand;
use App\Form\SearchAdType;
use App\Repository\AdQuestionRepository;
use App\Repository\AdRepository;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
                $ad->setUser($this->getUser());
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

    #[Route('/annonces/{id}', name: 'ad_show', methods: ['GET', 'POST'])]
    public function show(Request $request, EntityManagerInterface $entityManager, Ad $ad): Response
    {
        $adQuestion = new AdQuestion();
        $adQuestionForm = $this
            ->createForm(AdQuestionType::class, $adQuestion)
            ->handleRequest($request);

        if ($adQuestionForm->isSubmitted() && $adQuestionForm->isValid()) {

            $adQuestion->setAd($ad);
            $adQuestion->setUser($this->getUser());
            $entityManager->persist($adQuestion);
            $entityManager->flush();

            $this->addFlash('success', 'La question a bien été créée');

            return $this->redirectToRoute('ad_show', ['id' => $adQuestion->getAd()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
            'question_form' => $adQuestionForm->createView(),
        ]);
    }

    #[Route('/{id}/answer', name: 'ads_back_answer', methods: ['GET', 'POST'])]
    public function adAnswerPage(Request $request, EntityManagerInterface $entityManager, adQuestion $adQuestion): RedirectResponse|Response
    {
        $answer = new Answer();
        $answerForm = $this
            ->createForm(AnswerType::class, $answer)
            ->handleRequest($request);

        if ($answerForm->isSubmitted() && $answerForm->isValid()) {

            $answer->setUser($this->getUser());
            $answer->setAdQuestion($adQuestion);
            $entityManager->persist($answer);
            $entityManager->flush();

            $this->addFlash('answer_success', 'La réponse a bien été créée');

            return $this->redirectToRoute('ad_show', ['id' => $adQuestion->getAd()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ad/answer.html.twig', [
            'adQuestion' => $adQuestion,
            'answer_form' => $answerForm->createView()
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
