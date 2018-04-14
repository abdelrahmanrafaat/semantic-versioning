<?php

namespace Abdelrahmanrafaat\SemanticVersion;

use Abdelrahmanrafaat\SemanticVersion\BuildMetaData\BuildMetaData;
use Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersion;
use Abdelrahmanrafaat\SemanticVersion\PreRelease\PreRelease;

/**
 * Class SemanticVersionDependenciesFactory
 *
 * @package Abdelrahmanrafaat\SemanticVersion
 */
class SemanticVersionDependenciesFactory
{
    /**
     * @return \Abdelrahmanrafaat\SemanticVersion\NormalVersion\NormalVersion
     */
    public function makeNormalVersion(): NormalVersion
    {
        return new NormalVersion;
    }

    /**
     * @return \Abdelrahmanrafaat\SemanticVersion\PreRelease\PreRelease
     */
    public function makePreRelease(): PreRelease
    {
        return new PreRelease;
    }

    /**
     * @return \Abdelrahmanrafaat\SemanticVersion\BuildMetaData\BuildMetaData
     */
    public function makeBuildMetaData(): BuildMetaData
    {
        return new BuildMetaData;
    }
}