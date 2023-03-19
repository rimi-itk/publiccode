<?php

namespace App\Command;

use App\ApiClient;
use App\Entity\Crawler\Publisher;
use App\Entity\Crawler\PublisherCodeHosting;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(
    name: 'app:crawler:publisher-import',
    description: 'Import list of publishers',
)]
class CrawlerPublisherImportCommand extends Command
{
    public function __construct(private readonly ApiClient $apiClient, private readonly ValidatorInterface $validator)
    {
        parent::__construct(null);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filename', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'YAML file name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filenames = $input->getArgument('filename');

        foreach ($filenames as $filename) {
            try {
                $data = Yaml::parseFile($filename);
            } catch (ParseException $parseException) {
                $io->error(sprintf('Cannot parse YAML file %s', $filename));
                continue;
            }

            if (empty($data)) {
                continue;
            }

            foreach ($data as $datum) {
                $publisher = (new Publisher())
                    ->setDescription($datum['name'] ?? $datum['description'] ?? '')
                    ->setActive((bool)($datum['active'] ?? true))
                    ->setAlternativeId($datum['id'] ?? null);
                if (isset($datum['repos'])) {
                    foreach ($datum['repos'] as $url) {
                        $publisher->addCodeHosting((new PublisherCodeHosting())
                            ->setUrl($url)
                            ->setIsGroup(false));
                    }
                }
                if (isset($datum['orgs'])) {
                    foreach ($datum['orgs'] as $url) {
                        $publisher->addCodeHosting((new PublisherCodeHosting())
                            ->setUrl($url)
                            ->setIsGroup(true));
                    }
                }

                $errors = $this->validator->validate($publisher);
                if ($errors->count() > 0) {
                    $io->writeln([
                        'Publisher',
                        json_encode($publisher, JSON_PRETTY_PRINT),
                        'is not valid:',
                    ]);
                    foreach ($errors as $error) {
                        $io->error(sprintf('%s: %s', $error->getPropertyPath(), $error->getMessage()));
                    }
                    continue;
                }

                try {
                    $response = $this->apiClient->createPublisher($publisher);
                    $io->success([
                        'Publisher created:',
                        json_encode($response->toArray(), JSON_PRETTY_PRINT),
                    ]);
                } catch (\Exception $exception) {
                    $io->error($exception->getMessage());
                }
            }
        }

        return self::SUCCESS;
    }
}
