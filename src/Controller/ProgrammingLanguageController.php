<?php

namespace App\Controller;

use App\Entity\ProgrammingLanguage;
use App\Form\ProgrammingLanguageType;
use App\Repository\ProgrammingLanguageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/programming/language")
 */
class ProgrammingLanguageController extends AbstractController
{
    /**
     * @Route("/", name="programming_language_index", methods="GET")
     */
    public function index(ProgrammingLanguageRepository $programmingLanguageRepository): Response
    {
        return $this->render('programming_language/index.html.twig', ['programming_languages' => $programmingLanguageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="programming_language_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $programmingLanguage = new ProgrammingLanguage();
        $form = $this->createForm(ProgrammingLanguageType::class, $programmingLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($programmingLanguage);
            $em->flush();

            return $this->redirectToRoute('programming_language_index');
        }

        return $this->render('programming_language/new.html.twig', [
            'programming_language' => $programmingLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programming_language_show", methods="GET")
     */
    public function show(ProgrammingLanguage $programmingLanguage): Response
    {
        return $this->render('programming_language/show.html.twig', ['programming_language' => $programmingLanguage]);
    }

    /**
     * @Route("/{id}/edit", name="programming_language_edit", methods="GET|POST")
     */
    public function edit(Request $request, ProgrammingLanguage $programmingLanguage): Response
    {
        $form = $this->createForm(ProgrammingLanguageType::class, $programmingLanguage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('programming_language_edit', ['id' => $programmingLanguage->getId()]);
        }

        return $this->render('programming_language/edit.html.twig', [
            'programming_language' => $programmingLanguage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="programming_language_delete", methods="DELETE")
     */
    public function delete(Request $request, ProgrammingLanguage $programmingLanguage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programmingLanguage->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($programmingLanguage);
            $em->flush();
        }

        return $this->redirectToRoute('programming_language_index');
    }
}
