<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

final class InternalServerErrorException extends \Exception
{
    public function __construct(string $uri, ?int $statusCode, ?string $content)
    {
        parent::__construct(
            sprintf(
                'An error occurred with status code %s on URL "%s", response "%s" given',
                $statusCode,
                $uri,
                $content
            )
        );
    }
}
