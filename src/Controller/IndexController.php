<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\GitHub;
use App\Helper\GitHubHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    #[Route('/', name: "index")]
    public function index(GitHubHelper $gitHubHelper): Response
    {
        $gitHubRepo = $this->em->getRepository(GitHub::class);
        $repos = $gitHubRepo->findBy(
            [],
            [
                'starGazersCount' => 'desc',
            ]
        );

        return $this->render('index.html.twig', [
            'repos' => $repos
        ]);
    }

    #[Route('/create', name: "create")]
    public function create()
    {
    }

    #[Route('/details', name: "details")]
    public function details()
    {
    }

    #[Route('/update', name: "update")]
    public function update()
    {
    }

    #[Route('/delete', name: "delete")]
    public function delete()
    {
    }
}
