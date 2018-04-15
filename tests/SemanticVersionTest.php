<?php

namespace Tests;

use Abdelrahmanrafaat\SemanticVersion\SemanticVersion;
use PHPUnit\Framework\TestCase;

/**
 * Class SemanticVersionTest
 *
 * @package Tests
 */
class SemanticVersionTest extends TestCase
{
    /**
     * @var \Abdelrahmanrafaat\SemanticVersion\SemanticVersion
     */
    protected $semanticVersion;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->semanticVersion = new SemanticVersion;

        parent::setUp();
    }

    /**
     * @dataProvider setVersionDataProvider
     *
     * @param string $version
     * @param array  $expected
     *
     * @return void
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function testSetVersion(string $version, array $expected): void
    {
        $this->semanticVersion->setVersion($version);
        $this->assertEquals(
            $this->semanticVersion->getFullVersion(),
            $expected['fullVersion']
        );
        $this->assertEquals(
            $this->semanticVersion->getNormalVersion(),
            $expected['normalVersion']
        );
        $this->assertEquals(
            $this->semanticVersion->getPreRelease(),
            $expected['preRelease']
        );
        $this->assertEquals(
            $this->semanticVersion->getBuildMetaData(),
            $expected['buildMetaData']
        );
    }

    /**
     * @return array
     */
    public function setVersionDataProvider(): array
    {
        return [
            'Test with Normal Version and preRelease and buildMetaData' => [
                '1.0.0-alpha+001',
                [
                    'fullVersion'   => '1.0.0-alpha+001',
                    'normalVersion' => '1.0.0',
                    'preRelease'    => 'alpha',
                    'buildMetaData' => '001',
                ],
            ],
            'Test with Normal Version and preRelease'                   => [
                '1.0.0-alpha',
                [
                    'fullVersion'   => '1.0.0-alpha',
                    'normalVersion' => '1.0.0',
                    'preRelease'    => 'alpha',
                    'buildMetaData' => '',
                ],
            ],
            'Test with Normal Version and buildMetaData'                => [
                '1.0.0+001',
                [
                    'fullVersion'   => '1.0.0+001',
                    'normalVersion' => '1.0.0',
                    'preRelease'    => '',
                    'buildMetaData' => '001',
                ],
            ],
            'Test with Normal Version'                                  => [
                '1.0.0',
                [
                    'fullVersion'   => '1.0.0',
                    'normalVersion' => '1.0.0',
                    'preRelease'    => '',
                    'buildMetaData' => '',
                ],
            ],
        ];
    }

    /**
     * @param string $version
     * @param string $otherVersion
     * @param bool   $areEqual
     *
     * @dataProvider equalsDataProvider
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function testEquals(string $version, string $otherVersion, bool $areEqual): void
    {
        $this->semanticVersion->setVersion($version);
        $otherVersionInstance = new SemanticVersion;
        $otherVersionInstance->setVersion($otherVersion);

        $this->assertEquals(
            $this->semanticVersion->equals($otherVersionInstance),
            $areEqual
        );
    }

    /**
     * @return array
     */
    public function equalsDataProvider(): array
    {
        return [
            'Test with same normal version'                                            => [
                '1.0.0',
                '1.0.0',
                true,
            ],
            'Test with same normal version and pre release'                            => [
                '1.0.0-alpha',
                '1.0.0-alpha',
                true,
            ],
            'Test with same normal version, pre release and build meta data'           => [
                '1.0.0-alpha+001',
                '1.0.0-alpha+001',
                true,
            ],
            'Test with same normal version, pre release and different build meta data' => [
                '1.0.0-alpha+111',
                '1.0.0-alpha+001',
                true,
            ],
            'Test with different normal version'                                       => [
                '1.1.0',
                '1.0.0',
                false,
            ],
            'Test with same normal version and different pre release'                  => [
                '1.0.0-alpha',
                '1.0.0-beta',
                false,
            ],
        ];
    }

    /**
     * @param string $version
     * @param string $otherVersion
     * @param bool   $isLessThan
     *
     * @dataProvider lessThanDataProvider
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function testLessThan(string $version, string $otherVersion, bool $isLessThan): void
    {
        $this->semanticVersion->setVersion($version);
        $otherVersionInstance = new SemanticVersion;
        $otherVersionInstance->setVersion($otherVersion);

        $this->assertEquals(
            $this->semanticVersion->lessThan($otherVersionInstance),
            $isLessThan
        );
    }

    /**
     * @return array
     */
    public function lessThanDataProvider(): array
    {
        return [
            'Test with equal normal version'                                                                                 => [
                '1.0.0',
                '1.0.0',
                false,
            ],
            'Test with smaller normal version'                                                                               => [
                '1.0.0',
                '1.1.0',
                true,
            ],
            'Test with greater normal version'                                                                               => [
                '1.1.0',
                '1.0.0',
                false,
            ],
            'Test with first version has a pre release and other don`t'                                                      => [
                '1.1.0-alpha',
                '1.1.0',
                true,
            ],
            'Test with second version has a pre release and other don`t'                                                     => [
                '1.1.0',
                '1.1.0-alpha',
                false,
            ],
            'Test with equal normal version and first has smaller numeric pre release identifier'                            => [
                '1.0.0-alpha.1',
                '1.0.0-alpha.2',
                true,
            ],
            'Test with equal normal version and first has greater numeric pre release identifier'                            => [
                '1.0.0-alpha.2',
                '1.0.0-alpha.1',
                false,
            ],
            'Test with equal normal version and first has numeric pre release identifier other has alphanumeric identifier'  => [
                '1.0.0-alpha',
                '1.0.0-1',
                false,
            ],
            'Test with equal normal version and second has numeric pre release identifier other has alphanumeric identifier' => [
                '1.0.0-1',
                '1.0.0-alpha',
                true,
            ],
            'Test with equal normal version and first has smaller alphanumeric pre release identifier'                       => [
                '1.0.0-alpha',
                '1.0.0-rc',
                true,
            ],
            'Test with equal normal version and first has greater alphanumeric pre release identifier'                       => [
                '1.0.0-rc',
                '1.0.0-alpha',
                false,
            ],
            'Test with equal normal version and first has more pre release identifiers'                                      => [
                '1.0.0-alpha.1',
                '1.0.0-alpha',
                false,
            ],
            'Test with equal normal version and second has more pre release identifiers'                                      => [
                '1.0.0-alpha',
                '1.0.0-alpha.1',
                true,
            ],
        ];
    }
}