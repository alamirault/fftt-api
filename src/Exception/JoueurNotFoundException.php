<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Exception;

final class JoueurNotFoundException extends \Exception
{
    public function __construct(string $licenceId, ?string $clubId = null)
    {
        $message = sprintf(
            "Joueur '%s' does not exist", $licenceId
        );

        if ($clubId) {
            $message .= sprintf(" in club '%s'", $clubId);
        }

        parent::__construct($message);
    }
}
