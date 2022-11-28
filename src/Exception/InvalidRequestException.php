<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

final class InvalidRequestException extends \Exception
{
    public function __construct(string $uri, int $statusCode, string $content)
    {
        $xml = @simplexml_load_string($content);
        $response = false === $xml ? $content : (string) $xml->erreur;

        parent::__construct(
            sprintf(
                'Status code %s on URL "%s", response "%s" given',
                $statusCode,
                $uri,
                $response
            )
        );
    }
}
