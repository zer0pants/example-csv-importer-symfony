<?php

namespace App\Module\Verify;

class CheckCharacterVerification implements KeyVerification
{
    protected const VALID_CHARS = ['2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K','L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    
    protected $verifiable;

    public function __construct(KeyVerifiable $verifiable = null)
    {
        $this->verifiable = $verifiable;
    }

    public function check(KeyVerifiable $verifiable): bool
    {
        return $this->verifyKey($verifiable->getVerifiableKey());
    }

    protected function verifyKey(string $key): bool
    {
        if (strlen($key) != 10) {
            return false;
        }
        
        $checkDigit = $this->generateCheckCharacter(substr(mb_strtoupper($key), 0, 9));
        return $key[9] == $checkDigit;
    }

    protected function generateCheckCharacter(string $input): string
    {
        $factor = 2;
        $sum = 0;
        $n = count(self::VALID_CHARS);

        // Starting from the right and working leftwards is easier since // the initial "factor" will always be "2"
        for ($i = strlen($input) - 1; $i >= 0; $i--) {
            $codePoint = array_search($input[$i], self::VALID_CHARS);
            $addend = $factor * $codePoint;
            // Alternate the "factor" that each "codePoint" is multiplied by factor = (factor == 2) ? 1 : 2;
            $factor = ($factor == 2) ? 1 : 2;
            // Sum the digits of the "addend" as expressed in base "n" addend = (addend / n) + (addend % n);
            $addend = ($addend / $n) + ($addend % $n);
            $sum += $addend;
        }
        
        // Calculate the number that must be added to the "sum" // to make it divisible by "n"
        $remainder = $sum % $n;
        $checkCodePoint = ($n - $remainder) % $n;
        
        return self::VALID_CHARS[$checkCodePoint];
    }
}
