<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Model\Factory;

use Alamirault\FFTTApi\Model\Club;
use DateTime;

final class ClubFactory
{
    /**
     * @param array<array{numero: string, nom: string, validation: array<mixed>|string}> $data
     *
     * @return array<Club>
     */
    public function createFromArray(array $data): array
    {
        $result = [];
        foreach ($data as $clubData) {
            /** @var DateTime|null $dateValidation */
            $dateValidation = is_array($clubData['validation']) ? null : DateTime::createFromFormat('d/m/Y', $clubData['validation']);
            $result[] = new Club(
                $clubData['numero'],
                $clubData['nom'],
                $dateValidation
            );
        }

        return $result;
    }
}
