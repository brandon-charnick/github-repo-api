<?php

declare(strict_types=1);

namespace App\Command;

use App\Helper\GitHubHelper;
use App\Entity\GitHub;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:load-github',
    description: 'Loads top 10 starred PHP repos from GitHub search.',
    hidden: false,
    aliases: ['app:github']
)]
class LoadGitHubCommand extends Command
{
    public function __construct(
        private readonly GitHubHelper $gitHubHelper,
        private readonly EntityManagerInterface $em,
        private readonly SerializerInterface $serializer
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repositories = $this->gitHubHelper->searchRepositories(10);
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

        return Command::SUCCESS;
    }
}
