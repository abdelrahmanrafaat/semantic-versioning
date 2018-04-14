<?php

namespace Abdelrahmanrafaat\SemanticVersion\PreRelease;

/**
 * Class InvalidPreReleaseIdentifierException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\PreRelease
 */
class InvalidPreReleaseIdentifierException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Pre Release identifiers can be either numeric numbers [0-9] without leading zeros or alphanumeric with/without Hyphen [0-9A-Za-z-]', 504, null);
    }
}