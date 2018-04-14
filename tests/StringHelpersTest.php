<?php

namespace Tests;

use Abdelrahmanrafaat\SemanticVersion\StringHelpers;
use PHPUnit\Framework\TestCase;

/**
 * Class StringHelpersTest
 *
 * @package Tests
 */
class StringHelpersTest extends TestCase
{
    /**
     * @return void
     */
    public function testIsAlphaNumeric(): void
    {
        $this->assertTrue(StringHelpers::isAlphaNumeric('alphaNumeric'));
        $this->assertTrue(StringHelpers::isAlphaNumeric('12345'));

        $this->assertFalse(StringHelpers::isAlphaNumeric('+'));
        $this->assertFalse(StringHelpers::isAlphaNumeric('-'));
    }

    /**
     * @return void
     */
    public function testIsPositiveInteger(): void
    {
        $this->assertTrue(StringHelpers::isPositiveInteger('0'));
        $this->assertTrue(StringHelpers::isPositiveInteger('1'));
        $this->assertTrue(StringHelpers::isPositiveInteger('10'));
        $this->assertTrue(StringHelpers::isPositiveInteger('150000'));

        $this->assertFalse(StringHelpers::isPositiveInteger('text'));
        $this->assertFalse(StringHelpers::isPositiveInteger('-10'));
    }

    /**
     * @return void
     */
    public function testHasLeadingZero(): void
    {
        $this->assertTrue(StringHelpers::hasLeadingZero('010'));

        $this->assertFalse(StringHelpers::hasLeadingZero('10'));
        $this->assertFalse(StringHelpers::hasLeadingZero('-10'));
    }

    /**
     * @return void
     */
    public function testIsAlphaNumericOrHyphen(): void
    {
        $this->assertTrue(StringHelpers::isAlphaNumericOrHyphen('-'));
        $this->assertTrue(StringHelpers::isAlphaNumericOrHyphen('text'));
        $this->assertTrue(StringHelpers::isAlphaNumericOrHyphen('123424'));

        $this->assertFalse(StringHelpers::isAlphaNumericOrHyphen('+'));
        $this->assertFalse(StringHelpers::isAlphaNumericOrHyphen('!'));
    }
}