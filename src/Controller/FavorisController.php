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

class FavorisController extends AbstractController
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
     * @Route("/favoris", name="favoris")
     */
    public function favoris(Request $request, UserInterface $user): Response
    {
        $data = array();
        $data['tab'] = $this->entityManager->getRepository(Favory::class)->findByUser($user);
        return new Response($this->twig->render('pages/favoris.html.twig', ['data' => $data,]));
    }

    /**
     * @Route("/favoris/delete/{id}", name="delteFavoris")
     */
    public function delete(Request $request, UserInterface $user): Response
    {
        $favory = $this->entityManager->getRepository(Favory::class)->findOneByIdAndUser($user, $request->get('id'));
        if ($favory) {
            $this->entityManager->remove($favory);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('favoris');
    }

    /**
     * @Route("/favoris/partager/{id}", name="partagerFavoris")
     */
    public function partager(Request $request, UserInterface $user): Response
    {
        $favory = $this->entityManager->getRepository(Favory::class)->findOneByIdAndUser($user, $request->get('id'));
        if ($favory) {
            if($favory->getPartage()===null){
                $favory->setPartage(true);
            }
            else{
                $favory->setPartage(!$favory->getPartage());
            }
            $favory->setDatePartage(new \DateTime());
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('favoris');
    }
}
