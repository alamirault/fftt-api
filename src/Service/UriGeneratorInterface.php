<?php

namespace Alamirault\FFTTApi\Service;

interface UriGeneratorInterface
{
    /**
     * @param array<string, string> $parameters
     * @param string $path
     * @param string|null $queryParameter
     */
    public function generate($path, $parameters = [], $queryParameter = null): string;
}
