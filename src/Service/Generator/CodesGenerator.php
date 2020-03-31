<?php

namespace App\Service\Generator;

use App\Service\Generator\GenerateStrategies\GeneratorStrategyInterface;

/**
 * class for generate codes in many ways (depends on strategy)
 * and save to file
 * 
 * @author Sebastian Chmiel
 */
class CodesGenerator
{
    /**
     * max count to generate
     */
    const MAX_COUNT = 10000000000;

    /**
     * max length of single code
     */
    const MAX_LENGTH = 1000;

    /**
     * count of codes to generate
     *
     * @var int
     */
    private $count;

    /**
     * length of single code
     *
     * @var int
     */
    private $length;

    /**
     * definy file path
     *
     * @var string
     */
    private $file;

    /**
     * generator strategy 
     *
     * @var GeneratorStrategyInterface
     */
    private $strategy;
    
    /**
     * generated codes
     *
     * @var array
     */
    private $codes;

    /**
     * @param integer $count
     * @param integer $length
     * @param string $file
     * @param GeneratorStrategyInterface $strategy
     */
    public function __construct(int $count, int $length, string $file, GeneratorStrategyInterface $strategy)
    {
        $this->count = $count;
        $this->length = $length;
        $this->file = $file;
        $this->strategy = $strategy;
    }

    /**
     * generate codes
     *
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    public function generate(): void
    {
        $this->verifyMaxCombinations();

        $this->codes = [];

        for ($i = 0; $i < $this->count; ++$i) {
            do {
                $code = $this->strategy->generate($this->length);
            } while (!$this->isUnique($code));

            $this->codes[] = $code;
        }
    }

    /**
     * check if code is unique
     *
     * @param string $code
     * 
     * @return boolean
     */
    public function isUnique(string $code): bool
    {
        return array_search($code, $this->codes) === false ? true : false;
    }

    /**
     * save generated codes to file
     *
     * @return void
     */
    public function saveToFile(): void
    {
        file_put_contents($this->file, implode("\r\n", $this->codes));
    }

    /**
     * verify if algorithm can generate this count of codes
     *
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    public function verifyMaxCombinations(): void
    {
        if ($this->count > $this->strategy->getMaxCombinations($this->length)) {
            throw new \InvalidArgumentException('Could not generate as many codes.');
        }
    }
}
