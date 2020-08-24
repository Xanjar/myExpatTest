<?php

namespace App\Controller;

use App\Entity\Favory;
use App\Entity\User;
use App\Service\NewsApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController{

    /**
     * @var Environment;
     */
    private $twig;
    private $entityManager;
    private $csrfTokenManager;

    public function __construct(Environment $twig,EntityManagerInterface $entityManager,CsrfTokenManagerInterface $csrfTokenManager){
        $this->twig = $twig;
        $this->entityManager = $entityManager;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @Route("/articles/{id}", name="articles")
     */
    public function articles(Request $request,NewsApiService $newsApiService): Response{
        $id = $request->get('id');
        $data = $newsApiService->getArticles($id);
        $data = array();
        $data['tab']=$newsApiService->getArticles($id);
        $data['id']=$request->get('id');
        return new Response($this->twig->render('pages/article.html.twig',['data' => $data,]));
    }

    /**
     * @Route("/ajoutFav/{id}", name="ajoutFav",methods={"POST"})
     */
    public function ajoutFav(Request $request,UserInterface $user): Response{
        $token = new CsrfToken('ajoutFav', $request->get('_csrf_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        //dd($user);
        //$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $this->session->get('user').username]);
        //dd($user);

        if($this->entityManager->getRepository(Favory::class)->findOneByTitleAndUser($user,$request->get('title'))){
            return $this->redirectToRoute('articles', ['id' => $request->get('id')]);
        }

        $fav = new Favory();
        $fav->setSource($request->get('source'));
        $fav->setContent($request->get('content'));
        $fav->setTitle($request->get('title'));
        $fav->setAuthor($request->get('author'));
        $fav->setUrl($request->get('url'));
        $fav->setUrlToImage($request->get('url_to_image'));
        $fav->setDescription($request->get('description'));
        $fav->setPublishedAt(new \DateTime($request->get('published_at')));
        $fav->setUser($user);
        $this->entityManager->persist($fav);
        $this->entityManager->flush();
        //dd($fav);
        return $this->redirectToRoute('articles', ['id' => $request->get('id')]);
    }


}