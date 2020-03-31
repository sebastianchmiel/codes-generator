<?php

namespace App\Service\Generator\GenerateStrategies;

/**
 * generator strategy interface
 * 
 * @author Sebastian Chmiel
 */
interface GeneratorStrategyInterface
{
    /**
     * generate code
     *
     * @param integer $length
     * 
     * @return string
     */
    public function generate(int $length): string;

    /**
     * get count of max codes combination for length 
     *
     * @param integer $length
     * 
     * @return float
     */
    public function getMaxCombinations(int $length): float;
}
