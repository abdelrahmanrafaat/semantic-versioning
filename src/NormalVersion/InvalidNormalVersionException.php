<?php

namespace Abdelrahmanrafaat\SemanticVersion\NormalVersion;

/**
 * Class InvalidVersionException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\NormalVersion
 */
class InvalidNormalVersionException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid normal version, version should be number or number.number or number.number.number', 500, null);
    }
}