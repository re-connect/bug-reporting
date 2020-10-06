<?php

namespace App\Controller;

use App\Entity\Bug;
use App\Form\BugType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BugController extends AbstractController
{
    /**
     * @Route("/bug", name="bug")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $bugs = $em->getRepository(Bug::class)->findAll();
        $form = $this->createForm(BugType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bug = $form->getData();
            $em->persist($bug);
            $em->flush();
        }

        return $this->render('bug/index.html.twig', [
            'bugs' => $bugs,
            'form' => $form->createView(),
        ]);
    }
}
