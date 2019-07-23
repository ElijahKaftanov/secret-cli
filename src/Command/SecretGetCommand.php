<?php declare(strict_types=1);

namespace Classic\Secret\CliClient\Command;

use Classic\Secret\CliClient\Client\Client;
use Classic\Secret\CliClient\Service\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class SecretGetCommand extends Command
{
    protected static $defaultName = 'app:secret:get';
    /**
     * @var Client
     */
    private $client;

    public function __construct(
        Client $client
    )
    {
        parent::__construct(null);
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');
        $name = $helper->ask($input, $output, new Question('Enter the secret name: '));

        $message = $this->client->getSecret($name);

        $output->success($message);
    }
}