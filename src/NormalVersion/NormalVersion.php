<?php

namespace Abdelrahmanrafaat\SemanticVersion\NormalVersion;

use Abdelrahmanrafaat\SemanticVersion\StringHelpers;

/**
 * Class NormalVersion
 *
 * @package Abdelrahmanrafaat\SemanticVersion\NormalVersion
 */
class NormalVersion
{
    const IDENTIFIERS_SEPARATOR = '.';

    const VERSION_MAJOR = 'major';
    const VERSION_MINOR = 'minor';
    const VERSION_PATCH = 'patch';

    /**
     * @var array
     */
    protected $identifiers = [];

    /**
     * @param string $version
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     */
    public function setVersion(string $version): void
    {
        $parsingResult = $this->parse($this->sanitize($version));
        $this->validate($parsingResult);

        $this->mapToIdentifiers($parsingResult);
    }

    /**
     * @param string $version
     *
     * @return string
     */
    protected function sanitize(string $version): string
    {
        return trim($version);
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
     * @return void
     */
    protected function mapToIdentifiers(array $parsingResult): void
    {
        $mappedVersion = array_map('intval', $parsingResult);

        $this->identifiers = [
            self::VERSION_MAJOR => $mappedVersion[0],
            self::VERSION_MINOR => $mappedVersion[1] ?? 0,
            self::VERSION_PATCH => $mappedVersion[2] ?? 0,
        ];
    }

    /**
     * @param array $parsingResult
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\MajorIdentifierCanNotBeZeroException
     */
    protected function validate(array $parsingResult): void
    {
        $length = count($parsingResult);
        if ($length > 3 || $length < 1) {
            throw new InvalidNormalVersionException;
        }

        foreach ($parsingResult as $index => $identifier) {
            if(!StringHelpers::isPositiveInteger($identifier)){
                throw new NormalVersionShouldBePositiveNumberException;
            }

            if ($index == 0 && (int)$identifier == 0){
                throw new MajorIdentifierCanNotBeZeroException;
            }

            if ((int)$identifier != 0 && StringHelpers::hasLeadingZero($identifier)) {
                throw new NormalVersionShouldBePositiveNumberException;
            }
        }
    }

    /**
     * @return string
     */
    public function getNormalVersion(): string
    {
        return implode(self::IDENTIFIERS_SEPARATOR, $this->identifiers);
    }

    /**
     * @param int $increment
     */
    public function pumpMajor(int $increment = 1): void
    {
        $this->identifiers[self::VERSION_MAJOR] += $increment;

        //When Major version gets updated, reset minor and patch
        $this->identifiers[self::VERSION_MINOR] = 0;
        $this->identifiers[self::VERSION_PATCH] = 0;
    }

    /**
     * @param int $increment
     */
    public function pumpMinor(int $increment = 1): void
    {
        $this->identifiers[self::VERSION_MINOR] += $increment;

        //When Minor version gets updated, reset patch
        $this->identifiers[self::VERSION_PATCH] = 0;
    }

    /**
     * @param int $increment
     */
    public function pumpPatch(int $increment = 1): void
    {
        $this->identifiers[self::VERSION_PATCH] += $increment;
    }

    /**
     * @return int|null
     */
    public function getMajor(): ?int
    {
        return $this->identifiers[self::VERSION_MAJOR] ?? null;
    }

    /**
     * @return int|null
     */
    public function getMinor(): ?int
    {
        return $this->identifiers[self::VERSION_MINOR] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPatch(): ?int
    {
        return $this->identifiers[self::VERSION_PATCH] ?? null;
    }

}