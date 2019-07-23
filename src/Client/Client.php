<?php declare(strict_types=1);

namespace Classic\Secret\CliClient\Client;


use Classic\Package\Support\Tool\Dot\Dot;
use Classic\Secret\CliClient\Exception\NotRegisteredException;
use Classic\Secret\CliClient\Service\RequestSignatureService;
use Classic\Secret\CliClient\Service\Storage;
use Classic\Secret\Package\Crypt\Operator\CryptoFactory;
use GuzzleHttp\HandlerStack;
use ParagonIE\EasyRSA\EasyRSA;
use ParagonIE\EasyRSA\KeyPair;
use ParagonIE\EasyRSA\PublicKey;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\RequestInterface;
use Symfony\Contracts\Cache\CacheInterface;

class Client
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $http;
    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var RequestSignatureService
     */
    private $requestSignatureService;
    /**
     * @var CryptoFactory
     */
    private $cryptoFactory;

    public function __construct(
        string $coreUrl,
        CacheInterface $cache,
        Storage $storage,
        RequestSignatureService $requestSignatureService,
        CryptoFactory $cryptoFactory
    )
    {
        $this->http = new \GuzzleHttp\Client([
            'base_uri' => $coreUrl
        ]);
        $this->cache = $cache;
        $this->storage = $storage;
        $this->requestSignatureService = $requestSignatureService;
        $this->cryptoFactory = $cryptoFactory;
    }

    public function getHttp()
    {
        return $this->http;
    }

    public function getServerPublicKey(): string
    {
        return $this->cache->get('client.server_public_key', function () {
            return $this->http->get('api/key')->getBody()->getContents();
        });
    }

    public function register(string $username)
    {
        $kp = KeyPair::generateKeyPair(4096);

        $uri = 'api/register';
        $this->http->post($uri, [
            'json' => [
                'data' => [
                    'username' => $username,
                    'publicKey' => $kp->getPublicKey()->getKey()
                ]
            ]
        ]);

        $this->storage->set('user', [
            'username' => $username,
            'publicKey' => $kp->getPublicKey()->getKey(),
            'privateKey' => $kp->getPrivateKey()->getKey()
        ]);

    }

    public function storeSecret(string $name, string $message)
    {
        $user = $this->getUserData();

        $path = 'api/secret';
        $this->http->post($path, [
            'json' => ['data' => [
                'username' => $user['username'],
                'secretName' => $name,
                'encryptedSecret' => $this->encryptWithServerKey($message)
            ]],
            'handler' => $this->getEncryptStack()
        ]);
    }

    public function getSecret(string $name)
    {
        $user = $this->getUserData();

        $path = 'api/secret';
        $response = $this->http->get($path, [
            'json' => ['data' => [
                'username' => $user['username'],
                'secretName' => $name,
            ]],
            'handler' => $this->getEncryptStack()
        ]);

        $json = $response->getBody()->getContents();

        $payload = json_decode($json, true);

        $message = Dot::get($payload, 'data.encryptedSecret');

        $message = $this->decryptWithUserKey($message);

        return $message;
    }

    private function getEncryptStack()
    {
        $stack = HandlerStack::create();
        $stack->push($this->getEncryptRequestMiddleware());
        return $stack;
    }

    private function getEncryptRequestMiddleware()
    {
        return function (callable $handler) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler) {
                $privateKey = $this->getUserData('privateKey');

                $signer = $this->cryptoFactory->makeSigner($privateKey);

                $request = $this->requestSignatureService->sign($request, $signer);

                return $handler($request, $options);
            };
        };
    }

    private function encryptWithServerKey($message)
    {
        $key = $this->getServerPublicKey();

        $message = EasyRSA::encrypt($message, new PublicKey($key));

        return $message;
    }

    private function decryptWithUserKey(string $message): string
    {
        $key = $this->getUserPrivateKey();

        $decryptor = $this->cryptoFactory->makeDecryptor($key);

        return $decryptor->decrypt($message);
    }

    private function getUserPrivateKey(): string
    {
        return $this->getUserData('privateKey');
    }

    private function getUserData(string $path = null)
    {
        $data = $this->storage->find('user');

        if (is_null($data)) {
            throw new NotRegisteredException();
        }

        if (!is_null($path)) {
            $data = Dot::get($data, $path);
        }

        return $data;
    }

}