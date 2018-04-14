<?php

namespace Abdelrahmanrafaat\SemanticVersion;

/**
 * Class SemanticVersion
 *
 * @package Abdelrahmanrafaat\SemanticVersion
 */
class SemanticVersion
{
    const NORMAL_VERSION  = 'normalVersion';
    const PRE_RELEASE     = 'preRelease';
    const BUILD_META_DATA = 'buildMetaData';

    const PRE_RELEASE_SYMBOL     = '-';
    const BUILD_META_DATA_SYMBOL = '+';

    /**
     * @var \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersion
     */
    protected $normalVersion;

    /**
     * @var \Abdelrahmanrafaat\SemanticVersion\PreRelease\PreRelease
     */
    protected $preRelease;

    /**
     * @var \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\BuildMetaData
     */
    protected $buildMetaData;

    /**
     * SemanticVersion constructor.
     *
     * @param \Abdelrahmanrafaat\SemanticVersion\SemanticVersionDependenciesFactory $dependenciesFactory
     */
    public function __construct(SemanticVersionDependenciesFactory $dependenciesFactory)
    {
        $this->normalVersion = $dependenciesFactory->makeNormalVersion();
        $this->preRelease    = $dependenciesFactory->makePreRelease();
        $this->buildMetaData = $dependenciesFactory->makeBuildMetaData();
    }

    /**
     * @param string $version
     *
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\EmptyBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\InvalidBuildMetaDataIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\InvalidNormalVersionException
     * @throws \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersionShouldBePositiveNumberException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\EmptyPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\InvalidPreReleaseIdentifierException
     * @throws \Abdelrahmanrafaat\SemanticVersion\PreRelease\LeadingZeroPreReleaseIdentifierException
     */
    public function setVersion(string $version): void
    {
        $parsingResult = $this->parse($version);

        $this->normalVersion->setVersion(
            $parsingResult[self::NORMAL_VERSION]
        );

        $this->preRelease->setVersion(
            $parsingResult[self::PRE_RELEASE]
        );

        $this->buildMetaData->setVersion(
            $parsingResult[self::BUILD_META_DATA]
        );
    }

    /**
     * Pieces of semantic version are :
     * normalVersion x.y.z
     * preRelease after the normalVersion it starts with - followed by numeric or alphanumeric identifiers separated by
     * . BuildMetaData after the normalVersion or preRelease it starts with + followed by numeric or alphanumeric
     * identifiers separated by .
     *
     * @param string $version
     *
     * @return array
     */
    protected function parse(string $version): array
    {
        $pieces = [
            self::NORMAL_VERSION  => '',
            self::PRE_RELEASE     => '',
            self::BUILD_META_DATA => '',
        ];

        $isPreRelease    = false;
        $isBuildMetaData = false;
        foreach (str_split($version) as $char) {

            // Start extracting preRelease after the first -
            if (!$isPreRelease && $char == self::PRE_RELEASE_SYMBOL) {
                $isPreRelease = true;
                continue;
            }

            // Start extracting buildMetaData after +
            if (!$isBuildMetaData && $char == self::BUILD_META_DATA_SYMBOL) {
                $isPreRelease    = false;
                $isBuildMetaData = true;
                continue;
            }

            if ($isPreRelease) {
                $pieces[self::PRE_RELEASE] .= $char;
                continue;
            }

            if ($isBuildMetaData) {
                $pieces[self::BUILD_META_DATA] .= $char;
                continue;
            }

            $pieces[self::NORMAL_VERSION] .= $char;
        }

        return $pieces;
    }

    /**
     * @return string
     */
    public function getFullVersion(): string
    {
        $fullVersion   = $this->getNormalVersion();
        $preRelease    = $this->getPreRelease();
        $buildMetaData = $this->getBuildMetaData();

        if (!empty($preRelease)) {
            $fullVersion .= self::PRE_RELEASE_SYMBOL . $preRelease;
        }

        if (!empty($buildMetaData)) {
            $fullVersion .= self::BUILD_META_DATA_SYMBOL . $buildMetaData;
        }

        return $fullVersion;
    }

    /**
     * @return string
     */
    public function getNormalVersion(): string
    {
        return $this->normalVersion->getNormalVersion();
    }

    /**
     * @return string
     */
    public function getMajorVersion(): string
    {
        return $this->normalVersion->getMajor();
    }

    /**
     * @return string
     */
    public function getMinorVersion(): string
    {
        return $this->normalVersion->getMinor();
    }

    /**
     * @return string
     */
    public function getPatchVersion(): string
    {
        return $this->normalVersion->getPatch();
    }

    /**
     * @param int $increment
     */
    public function pumpMajor(int $increment = 1): void
    {
        $this->normalVersion->pumpMajor($increment);
    }

    /**
     * @param int $increment
     */
    public function pumpMinor(int $increment = 1): void
    {
        $this->normalVersion->pumpMinor($increment);
    }

    /**
     * @param int $increment
     */
    public function pumpPatch(int $increment = 1): void
    {
        $this->normalVersion->pumpPatch($increment);
    }

    /**
     * @return string
     */
    public function getPreRelease(): string
    {
        return $this->preRelease->getPreRelease();
    }

    /**
     * @return string
     */
    public function getBuildMetaData(): string
    {
        return $this->buildMetaData->getBuildMetaData();
    }

    /**
     * @param \Abdelrahmanrafaat\SemanticVersion\SemanticVersion $version
     *
     * @return bool
     */
    public function equals(SemanticVersion $version): bool
    {
        return $this->getNormalVersion() == $version->getNormalVersion() && $this->getPreRelease() == $version->getPreRelease();
    }

    /**
     * @param \Abdelrahmanrafaat\SemanticVersion\SemanticVersion $version
     *
     * @return bool
     */
    public function lessThan(SemanticVersion $version): bool
    {
        // The two versions are equals
        if ($this->equals($version)) {
            return false;
        }

        // if the two normal versions are not equal, we compare them
        if ($this->getNormalVersion() != $version->getNormalVersion()) {
            return version_compare($this->getNormalVersion(), $version->getNormalVersion(), '<');
        }

        // if One version has pre Release and the other don`t
        // the one without preRelease has a higher precedence
        if (empty($this->getPreRelease())) {
            return false;
        }

        if (empty($version->getPreRelease())) {
            return true;
        }

        /**
         * If the two versions has equal normal versions, and both of them have preRelease
         * We Compare the preRelease Identifiers
         *
         * identifiers consisting of only digits are compared numerically
         * and identifiers with letters or hyphens are compared lexically in ASCII sort order.
         * Numeric identifiers always have lower precedence than non-numeric identifiers.
         * A larger set of pre-release fields has a higher precedence than a smaller set
         */
        $firstVersionIdentifiers  = $this->preRelease->getIdentifiers();
        $secondVersionIdentifiers = $version->preRelease->getIdentifiers();

        for ($i = 0; $i < min(count($firstVersionIdentifiers), count($secondVersionIdentifiers)); $i++) {
            if ($firstVersionIdentifiers[$i] == $secondVersionIdentifiers[$i]) {
                continue;
            }

            // Both identifiers are numeric, compare them
            if (StringHelpers::isPositiveInteger($firstVersionIdentifiers[$i]) && StringHelpers::isPositiveInteger($secondVersionIdentifiers[$i])) {
                return $firstVersionIdentifiers[$i] < $secondVersionIdentifiers[$i];
            }

            // One of the identifiers is numeric and the other not
            // Numeric identifiers always have lower precedence than non-numeric identifiers
            if (StringHelpers::isPositiveInteger($firstVersionIdentifiers[$i]) && !StringHelpers::isPositiveInteger($secondVersionIdentifiers[$i])) {
                return true;
            }

            if (!StringHelpers::isPositiveInteger($firstVersionIdentifiers[$i]) && StringHelpers::isPositiveInteger($secondVersionIdentifiers[$i])) {
                return false;
            }

            // Both of the identifiers are alphanumerics
            return $firstVersionIdentifiers[$i] < $secondVersionIdentifiers[$i];
        }

        // The two versions has similar preRelease identifiers but one of them has more preRelease identifiers
        // A larger set of pre-release fields has a higher precedence than a smaller set
        return count($firstVersionIdentifiers) < count($secondVersionIdentifiers);
    }

    /**
     * @param \Abdelrahmanrafaat\SemanticVersion\SemanticVersion $version
     *
     * @return bool
     */
    public function greaterThan(SemanticVersion $version): bool
    {
        return !$this->equals($version) && !$this->lessThan($version);
    }
}