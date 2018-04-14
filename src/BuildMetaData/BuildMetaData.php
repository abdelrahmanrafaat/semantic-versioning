<?php

namespace Abdelrahmanrafaat\SemanticVersion\BuildMetaData;

use Abdelrahmanrafaat\SemanticVersion\StringHelpers;

/**
 * Class MetaData
 *
 * @package Abdelrahmanrafaat\SemanticVersion\BuildMetaData
 */
class BuildMetaData
{
    const IDENTIFIERS_SEPARATOR = '.';

    /**
     * @var array
     */
    protected $identifiers = [];

    /**
     * @param string $version
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     */
    public function setVersion(string $version): void
    {
        $parsingResult = $this->parse($version);
        $this->validate($parsingResult);

        $this->mapToIdentifiers($parsingResult);
    }

    /**
     * @param string $version
     *
     * @return array
     */
    protected function parse(string $version): array
    {
        if (empty($version)) {
            return [];
        }

        return explode(self::IDENTIFIERS_SEPARATOR, $version);
    }

    /**
     * @param array $parsingResult
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     */
    protected function validate(array $parsingResult): void
    {
        foreach ($parsingResult as $identifier) {
            if (empty($identifier)) {
                throw new EmptyBuildMetaDataIdentifierException;
            }

            if (!StringHelpers::isAlphaNumericOrHyphen($identifier)) {
                throw new InvalidBuildMetaDataIdentifierException;
            }
        }
    }

    /**
     * @param array $parsingResult
     */
    protected function mapToIdentifiers(array $parsingResult): void
    {
        $this->identifiers = $parsingResult;
    }

    /**
     * @return array
     */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    /**
     * @return string
     */
    public function getBuildMetaData(): string
    {
        return implode(self::IDENTIFIERS_SEPARATOR, $this->getIdentifiers());
    }
}