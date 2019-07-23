<?php declare(strict_types=1);

namespace Classic\Secret\CliClient\Command;


use Classic\Secret\CliClient\Client\Client;
use Classic\Secret\CliClient\Service\Storage;
use ParagonIE\EasyRSA\KeyPair;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class RegisterCommand extends Command
{
    protected static $defaultName = 'app:register';

    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var Client
     */
    private $client;

    public function __construct(
        Storage $storage,
        Client $client
    )
    {
        parent::__construct(null);
        $this->storage = $storage;
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output = new SymfonyStyle($input, $output);

        $helper = $this->getHelper('question');
        $username = $helper->ask($input, $output, new Question('Enter your username: '));

        $this->client->register($username);

        $output->success('Registration completed!');
    }
}
