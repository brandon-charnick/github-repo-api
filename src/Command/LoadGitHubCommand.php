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
        private readonly EntityManagerInterface $em
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repos = $this->gitHubHelper->searchRepos(10);
        $gitHubRepo = $this->em->getRepository(GitHub::class);

        /** @var App\Entity\GitHub $repo */
        foreach ($repos as $repo) {
            $gitHub = $gitHubRepo->findOneBy(
                [
                    'repoId' => $repo->getRepoId()
                ]
            );
            if (!$gitHub instanceof GitHub) {
                $this->em->persist($repo);
            }
        }
        $this->em->flush();

        return Command::SUCCESS;
    }
}
