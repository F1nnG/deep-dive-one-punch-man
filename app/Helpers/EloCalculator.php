<?php

namespace App\Helpers;

class EloCalculator
{
    public static function getRatings(int $winnerRating, int $loserRating, int $kFactor = 32): array
    {
        $expectedWinnerScore = static::expectedScore($winnerRating, $loserRating);
        $expectedLoserScore = static::expectedScore($loserRating, $winnerRating);

        $newWinnerRating = $winnerRating + $kFactor * (1 - $expectedWinnerScore);
        $newLoserRating = $loserRating + $kFactor * (0 - $expectedLoserScore);

        return [round($newWinnerRating), round($newLoserRating)];
    }

    private static function expectedScore(int $playerRating, int $opponentRating): float|int
    {
        return 1 / (1 + pow(10, ($opponentRating - $playerRating) / 400));
    }
}
