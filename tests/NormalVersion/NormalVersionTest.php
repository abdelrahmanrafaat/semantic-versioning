<?php

namespace Tests\NormalVersion;

use Abdelrahmanrafaat\SemanticVersion\NormalVersion\MajorIdentifierCanNotBeZeroException;
use PHPUnit\Framework\TestCase;
use Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersion;
use Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException;
use Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException;

class NormalVersionTest extends TestCase
{
    /**
     * @var NormalVersion
     */
    protected $normalVersion;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->normalVersion = new NormalVersion;
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function setVersion(): void
    {
        $this->normalVersion->setVersion(' 1.1.1 ');
        $this->assertEquals($this->normalVersion->getNormalVersion(), '1.1.1');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenVersionIsEmpty(): void
    {
        $this->expectException(InvalidNormalVersionException::class);
        $this->normalVersion->setVersion('');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenIdentifiersIsGreaterThanThree(): void
    {
        $this->expectException(InvalidNormalVersionException::class);
        $this->normalVersion->setVersion('1.2.3.4');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenIdentifiersIsNotInteger(): void
    {
        $this->expectException(NormalVersionShouldBePositiveNumberException::class);
        $this->normalVersion->setVersion('x.y.z');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenIdentifiersIsNotPositiveInteger(): void
    {
        $this->expectException(NormalVersionShouldBePositiveNumberException::class);
        $this->normalVersion->setVersion('-1.1.1');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenIdentifiersHasLeadingZero(): void
    {
        $this->expectException(NormalVersionShouldBePositiveNumberException::class);
        $this->normalVersion->setVersion('01.1.1');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testSetVersionThrowsExceptionWhenMajorIdentifier(): void
    {
        $this->expectException(MajorIdentifierCanNotBeZeroException::class);
        $this->normalVersion->setVersion('0.1.1');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testGetVersion(): void
    {
        $this->normalVersion->setVersion('1.1.1');
        $this->assertEquals($this->normalVersion->getNormalVersion(), '1.1.1');
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testPumpMajor(): void
    {
        $this->normalVersion->setVersion('1.1.1');
        $this->normalVersion->pumpMajor();
        $this->assertEquals(
            $this->normalVersion->getNormalVersion(),
            '2.0.0'
        );
        $this->assertEquals(
            $this->normalVersion->getMajor(),
            2
        );

        $this->normalVersion->setVersion('1.1.1');
        $this->normalVersion->pumpMajor(3);
        $this->assertEquals(
            $this->normalVersion->getNormalVersion(),
            '4.0.0'
        );
        $this->assertEquals(
            $this->normalVersion->getMajor(),
            4
        );
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testPumpMinor(): void
    {
        $this->normalVersion->setVersion('1.1.1');
        $this->normalVersion->pumpMinor();
        $this->assertEquals(
            $this->normalVersion->getNormalVersion(),
            '1.2.0'
        );
        $this->assertEquals(
            $this->normalVersion->getMinor(),
            2
        );

        $this->normalVersion->setVersion('1.1.1');
        $this->normalVersion->pumpMinor(3);
        $this->assertEquals(
            $this->normalVersion->getNormalVersion(),
            '1.4.0'
        );
        $this->assertEquals(
            $this->normalVersion->getMinor(),
            4
        );
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testPumpPatch(): void
    {
        $this->normalVersion->setVersion('1.1.1');
        $this->normalVersion->pumpPatch();
        $this->assertEquals(
            $this->normalVersion->getNormalVersion(),
            '1.1.2'
        );
        $this->assertEquals(
            $this->normalVersion->getPatch(),
            2
        );

        $this->normalVersion->setVersion('1.1.1');
        $this->normalVersion->pumpPatch(3);
        $this->assertEquals(
            $this->normalVersion->getNormalVersion(),
            '1.1.4'
        );
        $this->assertEquals(
            $this->normalVersion->getPatch(),
            4
        );
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testGetMajor(): void
    {
        $this->normalVersion->setVersion('1.2.3');
        $this->assertEquals(
            $this->normalVersion->getMajor(),
            1
        );
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testGetMinor(): void
    {
        $this->normalVersion->setVersion('1.2.3');
        $this->assertEquals(
            $this->normalVersion->getMinor(),
            2
        );
    }

    /**
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function testGetPatch(): void
    {
        $this->normalVersion->setVersion('1.2.3');
        $this->assertEquals(
            $this->normalVersion->getPatch(),
            3
        );
    }
}