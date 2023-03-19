<?php

namespace App\Command;

use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\Keys\SymmetricKey;
use ParagonIE\Paseto\Protocol\Version2;
use ParagonIE\Paseto\Purpose;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:paseto',
    description: 'Add a short description for your command',
)]
class PasetoCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addOption('issuer', null, InputOption::VALUE_REQUIRED, 'The issuer')
            ->addOption('issued-at', null, InputOption::VALUE_REQUIRED, 'Issued at')
            ->addOption('signing-key', null, InputOption::VALUE_REQUIRED, 'Signing key')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // @see https://github.com/paragonie/paseto/tree/master/docs#paseto-php-documentation
        $signingKey = $input->getOption('signing-key') ?: random_bytes(32);
        $sharedKey = new SymmetricKey($signingKey);

        $issuedAt = new \DateTimeImmutable();
        if (null !== $input->getOption('issued-at')) {
            try {
                $issuedAt = new \DateTimeImmutable($input->getOption('issued-at'));
            } catch (\Exception) {
            }
        }
        $issuer = $input->getOption('issuer');
        while (null === $issuer) {
            $issuer = $io->ask('Issuer');
        }

        $token = (new Builder())
            ->setKey($sharedKey)
            ->setVersion(new Version2())
            ->setPurpose(Purpose::local())
            ->setIssuedAt($issuedAt)
            ->setClaims([
                'iss' => $issuer,
            ]);

        $io->section('Claims');
        $io->writeln(json_encode($token->getJsonToken()->getClaims(), JSON_PRETTY_PRINT));

        $io->section('.env.local');

        $replacements = [
            '%API_BEARER_TOKEN%' => (string) $token,
            '%PASETO_KEY%' => base64_encode($sharedKey->raw()),
        ];
        $io->writeln(str_replace(
            array_keys($replacements),
            array_values($replacements),
            <<<EOF
Add these lines to .env.local:

API_BEARER_TOKEN="%API_BEARER_TOKEN%"
PASETO_KEY="%PASETO_KEY%"

and restart the docker compose setup:

  docker compose restart

EOF
        ));

        return Command::SUCCESS;
    }
}
