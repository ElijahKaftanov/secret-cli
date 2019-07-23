<?php declare(strict_types=1);

namespace Classic\Secret\CliClient\Command;

use Classic\Secret\CliClient\Client\Client;
use Classic\Secret\CliClient\Service\Storage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class SecretStoreCommand extends Command
{
    protected static $defaultName = 'app:secret:store';
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
        $message = $helper->ask($input, $output, new Question('Enter the secret message: '));

        $this->client->storeSecret($name, $message);

        $output->success('Sent!');
    }
}