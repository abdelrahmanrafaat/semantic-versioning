<?php

namespace Tests\BuildMetaData;

use Abdelrahmanrafaat\SemanticVersion\BuildMetaData\BuildMetaData;
use Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException;
use PHPUnit\Framework\TestCase;

/**
 * Class BuildMetaDataTest
 *
 * @package Tests\BuildMetaData
 */
class BuildMetaDataTest extends TestCase
{
    /**
     * @var BuildMetaData
     */
    protected $buildMetaData;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->buildMetaData = new BuildMetaData;
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     */
    public function testSetVersion(): void
    {
        $this->buildMetaData->setVersion('001');
        $this->assertEquals(
            $this->buildMetaData->getBuildMetaData(),
            '001'
        );

        $this->buildMetaData->setVersion('20130313144700');
        $this->assertEquals(
            $this->buildMetaData->getBuildMetaData(),
            '20130313144700'
        );

        $this->buildMetaData->setVersion('exp.sha.5114f85');
        $this->assertEquals(
            $this->buildMetaData->getBuildMetaData(),
            'exp.sha.5114f85'
        );

        $this->buildMetaData->setVersion('sha-2484324743824');
        $this->assertEquals(
            $this->buildMetaData->getBuildMetaData(),
            'sha-2484324743824'
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     */
    public function testGetIdentifiers(): void
    {
        $this->buildMetaData->setVersion('001');
        $this->assertEquals(
            $this->buildMetaData->getIdentifiers(),
            ['001']
        );

        $this->buildMetaData->setVersion('20130313144700');
        $this->assertEquals(
            $this->buildMetaData->getIdentifiers(),
            ['20130313144700']
        );

        $this->buildMetaData->setVersion('exp.sha.5114f85');
        $this->assertEquals(
            $this->buildMetaData->getIdentifiers(),
            ['exp', 'sha', '5114f85']
        );

        $this->buildMetaData->setVersion('sha-2484324743824');
        $this->assertEquals(
            $this->buildMetaData->getIdentifiers(),
            ['sha-2484324743824']
        );
    }

    /**
     * @return void
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     */
    public function testEmptyIdentifierThrowsException(): void
    {
        $this->expectException(EmptyBuildMetaDataIdentifierException::class);
        $this->buildMetaData->setVersion('alpha-1.');
    }

}