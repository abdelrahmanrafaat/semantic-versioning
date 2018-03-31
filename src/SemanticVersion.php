<?php

namespace Abdelrahmanrafaat\SemanticVersion;

/**
 * Class SemanticVersion
 *
 * @package Abdelrahmanrafaat\SemanticVersion
 */
class SemanticVersion
{
    const VERSION_DELIMITER = '.';
    const VERSION_MAJOR     = 'major';
    const VERSION_MINOR     = 'minor';
    const VERSION_PATCH     = 'patch';

    /**
     * @var array
     */
    protected $versionAsArray = [];

    /**
     * @param string $version
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    public function setVersion(string $version): void
    {
        $sanitizedVersion = $this->sanitize($version);
        $parsedVersion    = $this->parse($sanitizedVersion);
        $this->validateVersion($parsedVersion);

        $this->versionAsArray = $this->map($parsedVersion);
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
     * @param string $sanitizedVersion
     *
     * @return array
     */
    protected function parse(string $sanitizedVersion): array
    {
        return explode(self::VERSION_DELIMITER, $sanitizedVersion);
    }

    /**
     * @param array $parsedVersion
     *
     * @return array
     */
    protected function map(array $parsedVersion): array
    {
        $mappedVersion = array_map(function ($versionPiece) {
            return (int)$versionPiece;
        }, $parsedVersion);

        return [
            self::VERSION_MAJOR => $mappedVersion[0],
            self::VERSION_MINOR => $mappedVersion[1] ?? 0,
            self::VERSION_PATCH => $mappedVersion[2] ?? 0,
        ];
    }

    /**
     * @param array $parsedVersion
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\InvalidVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\VersionShouldBePositiveNumberException
     */
    protected function validateVersion(array $parsedVersion): void
    {
        $length = count($parsedVersion);
        if ($length > 3) {
            throw new InvalidVersionException;
        }

        foreach ($parsedVersion as $piece) {
            if (empty($piece)) {
                throw new InvalidVersionException;
            }
            if (!is_numeric($piece)) {
                throw new VersionShouldBePositiveNumberException;
            }

            if ((int)$piece < 0) {
                throw new VersionShouldBePositiveNumberException;
            }
        }
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return implode(self::VERSION_DELIMITER, $this->versionAsArray);
    }

    /**
     * @param int $increment
     */
    public function pumpMajor(int $increment = 1): void
    {
        $this->versionAsArray[self::VERSION_MAJOR] += $increment;
    }

    /**
     * @param int $increment
     */
    public function pumpMinor(int $increment = 1): void
    {
        $this->versionAsArray[self::VERSION_MINOR] += $increment;
    }

    /**
     * @param int $increment
     */
    public function pumpPatch(int $increment = 1): void
    {
        $this->versionAsArray[self::VERSION_PATCH] += $increment;
    }

    /**
     * @return int|null
     */
    public function getMajor(): ?int
    {
        return $this->versionAsArray[self::VERSION_MAJOR] ?? null;
    }

    /**
     * @return int|null
     */
    public function getMinor(): ?int
    {
        return $this->versionAsArray[self::VERSION_MINOR] ?? null;
    }

    /**
     * @return int|null
     */
    public function getPatch(): ?int
    {
        return $this->versionAsArray[self::VERSION_PATCH] ?? null;
    }

}

