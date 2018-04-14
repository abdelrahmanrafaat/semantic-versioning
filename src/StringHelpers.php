<?php

namespace Abdelrahmanrafaat\SemanticVersion;

/**
 * Class StringHelpers
 *
 * @package Abdelrahmanrafaat\SemanticVersion
 */
class StringHelpers
{
    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isAlphaNumeric(string $text): bool
    {
        return ctype_alnum($text);
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function isPositiveInteger(string $text): bool
    {
        return ctype_digit($text);
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public static function hasLeadingZero(string $text): bool
    {
        $leadingChar = $text[0] ?? '';
        return $leadingChar == '0';
    }

    /**
     * @param string $identifier
     *
     * @return bool
     */
    public static function isAlphaNumericOrHyphen(string $identifier):bool
    {
        foreach (str_split($identifier ) as $char){
            if(!self::isAlphaNumeric($char) && $char != '-'){
                return false;
            }
        }

        return true;
    }
}