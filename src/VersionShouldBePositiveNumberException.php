<?php

namespace Abdelrahmanrafaat\SemanticVersion;

use Exception;

/**
 * Class VersionShouldBePositiveNumberException
 *
 * @package Abdelrahmanrafaat\SemanticVersion
 */
class VersionShouldBePositiveNumberException extends Exception
{
    public function __construct()
    {
        parent::__construct('Version pieces should be positive integers', 501, null);
    }

}