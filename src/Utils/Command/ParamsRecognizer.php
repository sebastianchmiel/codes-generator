<?php

namespace App\Utils\Command;

/**
 * recognize command parameters like --paramName=paramValue
 * 
 * @author Sebastian Chmiel
 */
class ParamsRecognizer
{
    /**
     * recognize from argv
     *
     * @param array $argv
     * 
     * @return array
     */
    public static function recognize(array $argv): array
    {
        $params = [];
        foreach ($argv as $arg) {
            if (mb_ereg('--([^=]+)=(.*)', $arg, $reg)) {
                $params[$reg[1]] = $reg[2];
            } elseif (mb_ereg('-([a-zA-Z0-9])', $arg, $reg)) {
                $params[$reg[1]] = true;
            }
        }
        return $params;
    }
}
