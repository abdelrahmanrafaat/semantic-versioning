<?php

namespace Abdelrahmanrafaat\SemanticVersion\PreRelease;

use Abdelrahmanrafaat\SemanticVersion\StringHelpers;

/**
 * Class PreRelease
 *
 * @package Abdelrahmanrafaat\SemanticVersion\PreRelease
 */
class PreRelease
{
    const IDENTIFIERS_SEPARATOR = '.';

    /**
     * @var array
     */
    protected $identifiers = [];

    /**
     * @param string $version
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
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
     * Identifiers must not be empty
     * Identifiers can be numeric or alphaNumericOrHyphen separated by .
     * Numeric identifier should not have leading zeros
     *
     * @param array $parsingResult
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     */
    protected function validate(array $parsingResult): void
    {
        foreach ($parsingResult as $identifier) {
            if (empty($identifier)) {
                throw new EmptyPreReleaseIdentifierException;
            }

            if (StringHelpers::isInteger($identifier)) {
                if (StringHelpers::hasLeadingZero($identifier)) {
                    throw new LeadingZeroPreReleaseIdentifierException;
                }

                continue;
            }

            if (!StringHelpers::isAlphaNumericOrHyphen($identifier)) {
                throw new InvalidPreReleaseIdentifierException;
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
     * @return string
     */
    public function getPreRelease(): string
    {
        return implode(self::IDENTIFIERS_SEPARATOR, $this->getIdentifiers());
    }

    /**
     * @return array
     */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

}