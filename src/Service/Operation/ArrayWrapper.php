<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service\Operation;

final class ArrayWrapper
{
    /**
     * @param array<mixed> $array
     *
     * @return array<array<mixed>>
     */
    public function wrapArrayIfUnique(array $array): array
    {
        if (count($array) === count($array, COUNT_RECURSIVE)) {
            return [$array];
        }

        /** @var array<array<mixed>> $array */
        return $array;
    }
}
