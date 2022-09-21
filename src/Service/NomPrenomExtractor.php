<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service;

final class NomPrenomExtractor implements NomPrenomExtractorInterface
{
    /**
     * @param string $raw
     */
    public function extractNomPrenom($raw): array
    {
        $nom = [];
        $prenom = [];
        $words = explode(' ', $raw);

        foreach ($words as $word) {
            $lastChar = substr($word, -1);
            mb_strtolower($lastChar, 'UTF-8') === $lastChar ? $prenom[] = $word : $nom[] = $word;
        }

        return [
            implode(' ', $nom),
            implode(' ', $prenom),
        ];
    }
}
