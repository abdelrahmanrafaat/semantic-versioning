<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Abdelrahmanrafaat\SemanticVersion\SemanticVersion;
use Abdelrahmanrafaat\SemanticVersion\InvalidVersionException;
use Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException;

/**
 * Class SemanticVersionTest
 *
 * @package Tests
 */
class SemanticVersionTest extends TestCase
{
    /**
     * @var SemanticVersion
     */
    protected $semanticVersion;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->semanticVersion = new SemanticVersion;
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function setVersion(): void
    {
        $this->semanticVersion->setVersion(' 1.1.1 ');
        $this->assertEquals($this->semanticVersion->getVersion(), '1.1.1');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenVersionIsEmpty(): void
    {
        $this->expectException(InvalidVersionException::class);
        $this->semanticVersion->setVersion('');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenVersionPiecesIsGreaterThanThree(): void
    {
        $this->expectException(InvalidVersionException::class);
        $this->semanticVersion->setVersion('1.2.3.4');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenVersionPiecesIsNotInteger(): void
    {
        $this->expectException(VersionShouldBePositiveNumberException::class);
        $this->semanticVersion->setVersion('x.y.z');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenVersionPiecesIsNotPositiveInteger(): void
    {
        $this->expectException(VersionShouldBePositiveNumberException::class);
        $this->semanticVersion->setVersion('-1.1.1');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testGetVersion(): void
    {
        $this->semanticVersion->setVersion('1.1.1');
        $this->assertEquals($this->semanticVersion->getVersion(), '1.1.1');
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testPumpMajor(): void
    {
        $this->semanticVersion->setVersion('1.1.1');
        $this->semanticVersion->pumpMajor();
        $this->assertEquals(
            $this->semanticVersion->getVersion(),
            '2.1.1'
        );
        $this->assertEquals(
            $this->semanticVersion->getMajor(),
            2
        );

        $this->semanticVersion->setVersion('1.1.1');
        $this->semanticVersion->pumpMajor(3);
        $this->assertEquals(
            $this->semanticVersion->getVersion(),
            '4.1.1'
        );
        $this->assertEquals(
            $this->semanticVersion->getMajor(),
            4
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testPumpMinor(): void
    {
        $this->semanticVersion->setVersion('1.1.1');
        $this->semanticVersion->pumpMinor();
        $this->assertEquals(
            $this->semanticVersion->getVersion(),
            '1.2.1'
        );
        $this->assertEquals(
            $this->semanticVersion->getMinor(),
            2
        );

        $this->semanticVersion->setVersion('1.1.1');
        $this->semanticVersion->pumpMinor(3);
        $this->assertEquals(
            $this->semanticVersion->getVersion(),
            '1.4.1'
        );
        $this->assertEquals(
            $this->semanticVersion->getMinor(),
            4
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testPumpPatch(): void
    {
        $this->semanticVersion->setVersion('1.1.1');
        $this->semanticVersion->pumpPatch();
        $this->assertEquals(
            $this->semanticVersion->getVersion(),
            '1.1.2'
        );
        $this->assertEquals(
            $this->semanticVersion->getPatch(),
            2
        );

        $this->semanticVersion->setVersion('1.1.1');
        $this->semanticVersion->pumpPatch(3);
        $this->assertEquals(
            $this->semanticVersion->getVersion(),
            '1.1.4'
        );
        $this->assertEquals(
            $this->semanticVersion->getPatch(),
            4
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testGetMajor(): void
    {
        $this->semanticVersion->setVersion('1.2.3');
        $this->assertEquals(
            $this->semanticVersion->getMajor(),
            1
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testGetMinor(): void
    {
        $this->semanticVersion->setVersion('1.2.3');
        $this->assertEquals(
            $this->semanticVersion->getMinor(),
            2
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function testGetPatch(): void
    {
        $this->semanticVersion->setVersion('1.2.3');
        $this->assertEquals(
            $this->semanticVersion->getPatch(),
            3
        );
    }
}