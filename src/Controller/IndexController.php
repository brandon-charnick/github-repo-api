<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\GitHubHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name:"index")]
    public function index(GitHubHelper $gitHubHelper): Response
    {
        $repos = $gitHubHelper->searchRepos();

        return $this->render('index.html.twig', [
            'repos' => $repos
        ]);
    }
}