<?php

namespace Abdelrahmanrafaat\SemanticVersion\NormalVersion;

use Exception;

/**
 * Class VersionShouldBePositiveNumberException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\NormalVersion
 */
class NormalVersionShouldBePositiveNumberException extends Exception
{
    /**
     * NormalVersionShouldBePositiveNumberException constructor.
     */
    public function __construct()
    {
        parent::__construct('Normal version identifiers should be positive integers', 501, null);
    }
}