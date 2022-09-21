<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

use Exception;

final class ClubNotFoundException extends Exception
{
    public function __construct(string $clubId)
    {
        parent::__construct(
            sprintf(
                "Club '%s' does not exist",
                $clubId
            )
        );
    }
}
