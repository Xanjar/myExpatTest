<?php

namespace App\Controller;

use App\Service\NewsApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController{

    /**
     * @var Environment;
     */
    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    /**
     * @Route("/articles/{id}", name="articles")
     */
    public function articles(Request $request,NewsApiService $newsApiService): Response{
        $id = $request->get('id');
        $data = $newsApiService->getArticles($id);
        return new Response($this->twig->render('pages/article.html.twig',['data' => $data,]));
    }


}