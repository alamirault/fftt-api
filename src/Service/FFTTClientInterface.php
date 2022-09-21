<?php

namespace Alamirault\FFTTApi\Service;

use Alamirault\FFTTApi\Exception\InvalidRequestException;
use Alamirault\FFTTApi\Exception\InvalidResponseException;

interface FFTTClientInterface
{
    /**
     * @param array<string, string> $params
     *
     * @return array<mixed>
     *
     * @throws InvalidRequestException
     * @throws InvalidResponseException
     * @param string $path
     * @param string|null $queryParameter
     */
    public function get($path, $params = [], $queryParameter = null): array;
}
