<?php

namespace App\Constants;

class TransactionsStatusConstants
{
    CONST APPROVED = 'Approved';
    CONST REJECTED = 'Rejected';
    CONST ON_REVIEW = 'On review';

    public static function getRandomStatus()
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();
        return $constants[array_rand($constants)];
    }
}
