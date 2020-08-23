<?php

namespace App\Service;

use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NewsApiService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getSource(): Array
    {
        $response = $this->httpClient->request('GET', 
            'http://newsapi.org/v2/sources', [
                'query' => [
                    'language'=> 'fr',
                    'apiKey' => '9fb63369f21d44f5a0eca74ea49b49eb',
                ],
            ]);

        $data = $response->getContent();
        $decoded = json_decode($data);
        
        //dd($decoded);

        return $decoded->sources;
    }

    public function getArticles($id): Array
    {
        $response = $this->httpClient->request('GET', 
            'http://newsapi.org/v2/top-headlines', [
                'query' => [
                    'sources'=> $id,
                    'apiKey' => '9fb63369f21d44f5a0eca74ea49b49eb',
                ],
            ]);

        $data = $response->getContent();
        $decoded = json_decode($data);
        
        //dd($decoded);

        return $decoded->articles;
    }
}