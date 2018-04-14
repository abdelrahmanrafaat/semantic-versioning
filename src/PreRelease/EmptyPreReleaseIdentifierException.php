<?php

namespace Abdelrahmanrafaat\SemanticVersion\PreRelease;

/**
 * Class EmptyPreReleaseIdentifierException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\PreRelease
 */
class EmptyPreReleaseIdentifierException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Pre Release identifiers should not be empty', 502, null);
    }
}