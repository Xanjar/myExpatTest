<?php

namespace App\Controller;

use App\Entity\Favory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class PartageController extends AbstractController
{


    /**
     * @var Environment;
     */
    private $twig;
    private $entityManager;

    public function __construct(Environment $twig, EntityManagerInterface $entityManager)
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/partages", name="partages")
     */
    public function partages(Request $request, UserInterface $user): Response
    {
        $data = array();
        $data['tab'] = $this->entityManager->getRepository(Favory::class)->findByPartage();
        return new Response($this->twig->render('pages/partage.html.twig', ['data' => $data,]));
    }

}