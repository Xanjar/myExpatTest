<?php

namespace App\Controller;

use App\Entity\Favory;
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

class ArticleController{

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
        return new Response($this->twig->render('pages/article.html.twig',['data' => $data,]));
    }

    /**
     * @Route("/ajoutFav", name="AjoutFav")
     */
    public function ajoutFav(Request $request, UserInterface $user): Response{
        $token = new CsrfToken('authenticate', $request->get('csrf_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getUsername()]);
        dd($user);
        $fav = new Favory();
        $fav->setSource($request->get('source'));
        $fav->setContent($request->get('content'));
        $fav->setTitle($request->get('title'));
        $fav->setAuthor($request->get('author'));
        $fav->setUrl($request->get('url'));
        $fav->setUrlToImage($request->get('url_to_image'));
        $fav->setDescription($request->get('description'));
        $fav->setPublishedAt($request->get('published_at'));

        return new Response($this->twig->render('pages/article.html.twig'));
    }


}