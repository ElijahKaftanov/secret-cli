<?php declare(strict_types=1);

namespace Classic\Secret\CliClient\Service;

use Classic\Package\Support\Exception\NotImplementedException;
use Classic\Secret\Core\Foundation\Architecture\ServiceTrait;
use Classic\Secret\Core\Foundation\Crypt\SignCheckerInterface;
use Classic\Secret\Package\Crypt\SignerInterface;
use Illuminate\Http\Request;
use Psr\Http\Message\RequestInterface;

class RequestSignatureService
{
    public function sign($request, SignerInterface $signer)
    {
        if (!$request instanceof RequestInterface) {
            throw new NotImplementedException();
        }

        $message = $request->getUri() . $request->getBody()->getContents();

        $sign = $signer->sign($message);

        $request = $request->withHeader('x-sign', base64_encode($sign));

        return $request;
    }
}