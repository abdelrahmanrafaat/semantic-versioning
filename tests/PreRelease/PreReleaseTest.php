<?php

namespace Tests\PreRelease;

use Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException;
use Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException;
use Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException;
use Abdelrahmanrafaat\SemanticVersion\PreRelease\PreRelease;
use PHPUnit\Framework\TestCase;

/**
 * Class PreReleaseTest
 *
 * @package Tests\PreRelease
 */
class PreReleaseTest extends TestCase
{
    /**
     * @var \Abdelrahmanrafaat\SemanticVersion\PreRelease\PreRelease
     */
    protected $preRelease;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->preRelease = new PreRelease;
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     *
     * @return void
     */
    public function testGetVersion(): void
    {
        $this->preRelease->setVersion('alpha-1.2');
        $this->assertEquals(
            $this->preRelease->getPreRelease(),
            'alpha-1.2'
        );

        $this->preRelease->setVersion('1.2');
        $this->assertEquals(
            $this->preRelease->getPreRelease(),
            '1.2'
        );

        $this->preRelease->setVersion('alpha.beta');
        $this->assertEquals(
            $this->preRelease->getPreRelease(),
            'alpha.beta'
        );

        $this->preRelease->setVersion('rc-1');
        $this->assertEquals(
            $this->preRelease->getPreRelease(),
            'rc-1'
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function testEmptyIdentifierThrowsException(): void
    {
        $this->expectException(EmptyPreReleaseIdentifierException::class);
        $this->preRelease->setVersion('alpha-1.');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function testNumericIdentifierWithLeadingZeroThrowsException(): void
    {
        $this->expectException(LeadingZeroPreReleaseIdentifierException::class);
        $this->preRelease->setVersion('01.1');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function testNonAlphaNumericOrHyphenIdentifierWillThrowException(): void
    {
        $this->expectException(InvalidPreReleaseIdentifierException::class);
        $this->preRelease->setVersion('!');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     *
     * @return void
     */
    public function testGetIdentifiers(): void
    {
        $this->preRelease->setVersion('alpha-1.2');
        $this->assertEquals(
            $this->preRelease->getIdentifiers(),
            ['alpha-1', '2']
        );

        $this->preRelease->setVersion('1.2');
        $this->assertEquals(
            $this->preRelease->getIdentifiers(),
            ['1', '2']
        );

        $this->preRelease->setVersion('alpha.beta');
        $this->assertEquals(
            $this->preRelease->getIdentifiers(),
            ['alpha', 'beta']
        );

        $this->preRelease->setVersion('rc-1');
        $this->assertEquals(
            $this->preRelease->getIdentifiers(),
            ['rc-1']
        );
    }
}