<?php

namespace App\Controller;

use App\Service\Generator\CodesGenerator;
use App\Service\Generator\GenerateStrategies\AlphaNumericCodesGenerator;

/**
 * codes generator controller
 * 
 * @author Sebastian Chmiel
 */
class CodesGeneratorController {
    /**
     * enpoint to generate codes
     *
     * @return void
     */
    public function generate(): void {
        // read params
        $numberOfCodes = intval(($_POST['numberOfCodes'] ?? null));
        $lengthOfCode  = intval(($_POST['lengthOfCode'] ?? null));
        $file  = '../tmp/codes.txt';

        $alerts = [];

        if (isset($_POST['submit'])) {
            // validation
            if ($numberOfCodes <= 0 && $numberOfCodes <= CodesGenerator::MAX_COUNT) {
                $alerts[] = [
                    'type' => 'danger',
                    'content' => 'Number of codes (numberOfCodes) should be greather then 0 and lower then '.CodesGenerator::MAX_COUNT.'.',
                ];
            }
            if ($lengthOfCode <= 0 && $lengthOfCode <= CodesGenerator::MAX_LENGTH) {
                $alerts[] = [
                    'type' => 'danger',
                    'content' => 'Number of codes (lengthOfCode) should be greather then 0 and lower then '.CodesGenerator::MAX_LENGTH.'.',
                ];
            }

            // generate if no errors
            if (empty($alerts)) {
                $generatorHandler = new CodesGenerator($numberOfCodes, $lengthOfCode, $file, new AlphaNumericCodesGenerator());
                try {
                    $generatorHandler->generate();
                    $generatorHandler->saveToFile();

                    $alerts[] = [
                        'type' => 'success',
                        'content' => 'File with codes has been generated. <b><a href="'.$file.'" target="blank">Download!</a></b>',
                    ];
                } catch (\InvalidArgumentException $ex) {
                    $alerts[] = [
                        'type' => 'danger',
                        'content' => $ex->getMessage(),
                    ];
                }
                
            }
        }

        require_once '../templates/index.php';
    }
}