<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class SiteController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ArticleRepository $articleRepository)
    {

        $q = $request->query->get('q');

        $articles = [];

        if ($q) {
            $articles = $articleRepository->searchArticles($q);
        } else {
            $articles = $articleRepository->findAll();
        }

        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article-detail")
     */
    public function articleDetail(string $slug, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->findBySlug($slug);

        if (!$article) {
            throw $this->createNotFoundException('The article does not exist');
        }
        //var_dump($article);

        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
}
