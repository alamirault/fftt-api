<?php

namespace Alamirault\FFTTApi\Service;

interface NomPrenomExtractorInterface
{
    /**
     * @return array{0: string, 1: string}
     * @param string $raw
     */
    public function extractNomPrenom($raw): array;
}
