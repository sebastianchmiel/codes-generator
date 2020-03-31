<?php

namespace App\Service\Generator\GenerateStrategies;

use App\Service\Generator\GenerateStrategies\GeneratorStrategyInterface;

/**
 * generate aplhanumeric codes with small and big letters and numbers
 * 
 * @author Sebastian Chmiel
 */
class AlphaNumericCodesGenerator implements GeneratorStrategyInterface
{
    /**
     * available chars to use in code
     *
     * @var array
     */
    private $availableChars;

    public function __construct()
    {
        $this->availableChars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    }

    /**
     * generate code
     *
     * @param integer $length
     * 
     * @return string
     */
    public function generate(int $length): string
    {
        $key = '';

        for ($i = 0; $i < $length; $i++) {
            $key .= $this->availableChars[array_rand($this->availableChars)];
        }

        return $key;
    }

    /**
     * get count of max codes combination for length 
     *
     * @param integer $length
     * 
     * @return float
     */
    public function getMaxCombinations(int $length): float
    {
        return (float) pow(count($this->availableChars), $length);
    }
}
