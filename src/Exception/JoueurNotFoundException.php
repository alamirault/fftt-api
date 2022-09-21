<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

use Exception;

final class JoueurNotFoundException extends Exception
{
    public function __construct(string $clubId)
    {
        parent::__construct(
            sprintf(
                "Joueur '%s' does not exist",
                $clubId
            )
        );
    }
}
