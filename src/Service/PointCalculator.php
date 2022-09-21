<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service;

final class PointCalculator
{
    private const VICTORY_POINTS = [
        -500 => 40,
        -400 => 28,
        -300 => 22,
        -200 => 17,
        -150 => 13,
        -100 => 10,
        -50 => 8,
        -25 => 7,
        0 => 6,
        25 => 6,
        50 => 5.5,
        100 => 5,
        150 => 4,
        200 => 3,
        300 => 2,
        400 => 1,
        500 => 0.5,
    ];

    private const DEFEAT_POINTS = [
        -500 => 0,
        -400 => 0,
        -300 => -0.5,
        -200 => -1,
        -150 => -2,
        -100 => -3,
        -50 => -4,
        -25 => -4.5,
        0 => -5,
        25 => -5,
        50 => -6,
        100 => -7,
        150 => -8,
        200 => -10,
        300 => -12.5,
        400 => -16,
        500 => -20,
    ];

    public function getPointDefeat(float $joueurPoints, float $adversairePoints): float
    {
        $calculatedDiff = $joueurPoints - $adversairePoints;
        foreach (self::DEFEAT_POINTS as $diff => $value) {
            if ($calculatedDiff <= $diff) {
                return $value;
            }
        }

        return -29;
    }

    public function getPointVictory(float $joueurPoints, float $adversairePoints): float
    {
        $calculatedDiff = $joueurPoints - $adversairePoints;
        foreach (self::VICTORY_POINTS as $diff => $value) {
            if ($calculatedDiff <= $diff) {
                return $value;
            }
        }

        return 0;
    }
}
