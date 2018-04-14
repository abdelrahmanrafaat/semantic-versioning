<?php

namespace Abdelrahmanrafaat\SemanticVersion\PreRelease;

/**
 * Class LeadingZeroPreReleaseIdentifierException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\PreRelease
 */
class LeadingZeroPreReleaseIdentifierException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Pre Release numeric identifiers should not have any leading zeros', 503, null);
    }
}