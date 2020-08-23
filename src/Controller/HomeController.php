<?php

namespace App\Controller;

use App\Service\NewsApiService;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class HomeController{

    /**
     * @var Environment;
     */
    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    public function index(NewsApiService $newsApiService): Response{
        $data = $newsApiService->getSource();
        return new Response($this->twig->render('pages/home.html.twig',['data' => $data,]));
    }


}