<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

use Exception;

final class InvalidLienRencontreException extends Exception
{
    public function __construct(string $lienRencontre)
    {
        parent::__construct(
            sprintf('Invalid lien rencontre "%s"', $lienRencontre)
        );
    }
}
