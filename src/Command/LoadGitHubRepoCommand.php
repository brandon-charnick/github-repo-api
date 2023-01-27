<?php

declare(strict_types=1);

namespace App\Command;

use App\Helper\GitHubHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:load-repos',
    description: 'Loads top 10 repos from GitHub search.',
    hidden: false,
    aliases: ['app:github']
)]
class CreateUserCommand extends Command
{
    protected static $defaultDescription = 'Loads top 10 repos from GitHub search.';

    public function __construct(
        private readonly GitHubHelper $gitHubHelper,
        private readonly EntityManagerInterface $em
    ) {
    }

    protected function configure(): void
    {
        $this->setHelp('Loads top 10 repos from GitHub search.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repos = $this->gitHubHelper->searchRepos();

        /** @var $repo App\Entity\GitHub */
        foreach ($repos as $repo) {
            $this->em->persist($repo);
        }
        $this->em->flush();

        return Command::SUCCESS;
    }
}
