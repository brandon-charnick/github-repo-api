<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\GitHub;
use App\Form\Type\CreateGitHubType;
use App\Helper\GitHubHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly GitHubHelper $gitHubHelper,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('/', name: "index")]
    public function index(): Response
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
    public function create(Request $request): Response
    {
        $form = $this->createForm(CreateGitHubType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $repositories = $this->gitHubHelper->searchRepositories($formData['count']);

            /**
             * Check if each repository exists already
             * If it exists, it needs to be updated with the incoming data
             */
            $gitHubRepo = $this->em->getRepository(GitHub::class);
            /** @var App\Entity\GitHub $repo */
            foreach ($repositories as $repo) {
                $gitHub = $gitHubRepo->findOneBy(
                    [
                        'repoId' => $repo->getRepoId()
                    ]
                );
                if (!$gitHub instanceof GitHub) {
                    $this->em->persist($repo);
                } else {
                    $this->serializer->deserialize($this->serializer->serialize($repo, 'json'), GitHub::class, 'json', [
                        AbstractObjectNormalizer::OBJECT_TO_POPULATE => $gitHub,
                    ]);
                    $this->em->persist($gitHub);
                }
            }
            $this->em->flush();

            $this->addFlash('success', "Top {$formData['count']} PHP GitHub Repositories successfully added and updated.");

            return $this->redirectToRoute('index');
        }

        return $this->render('create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/details/{id<\d+>}', name: "details")]
    public function details(GitHub $gitHub)
    {
        return $this->render('details.html.twig', ['gitHub' => $gitHub]);
    }

    #[Route('/update/{id<\d+>}', name: "update")]
    public function update(GitHub $gitHub)
    {
        $repository = $this->gitHubHelper->getRepository($gitHub);

        $this->serializer->deserialize($repository, GitHub::class, 'json', [
            AbstractObjectNormalizer::OBJECT_TO_POPULATE => $gitHub,
        ]);

        $this->em->persist($gitHub);
        $this->em->flush();

        $this->addFlash('success', 'Repository details successfully updated.');

        return $this->redirectToRoute('details', ['id' => $gitHub->getId()]);
    }

    #[Route('/delete/{id<\d+>}', name: "delete")]
    public function delete(GitHub $gitHub)
    {
        $this->em->remove($gitHub);
        $this->em->flush();

        $this->addFlash('success', "Repository{$gitHub->getName()} successfully removed.");

        return $this->redirectToRoute('index');
    }
}
