<?php

namespace Abdelrahmanrafaat\SemanticVersion;

use Exception;

/**
 * Class InvalidVersionException
 *
 * @package Abdelrahmanrafaat\SemanticVersion
 */
class InvalidVersionException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid version, version should be number or number.number or number.number.number', 500, null);
    }
}