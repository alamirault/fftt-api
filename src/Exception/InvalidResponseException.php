<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

final class InvalidResponseException extends \Exception
{
    /**
     * @param array<mixed> $content
     */
    public function __construct(string $uri, array $content)
    {
        parent::__construct(
            sprintf(
                'Invalid response on URL "%s", response "%s" given',
                $uri,
                json_encode($content)
            )
        );
    }
}
