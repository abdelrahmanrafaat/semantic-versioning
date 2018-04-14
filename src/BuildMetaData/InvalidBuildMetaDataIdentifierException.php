<?php

namespace Abdelrahmanrafaat\SemanticVersion\BuildMetaData;

/**
 * Class InvalidBuildMetaDataIdentifierException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\BuildMetaData
 */
class InvalidBuildMetaDataIdentifierException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Build meta data identifiers can be either numeric numbers [0-9] or alphanumeric with/without Hyphen [0-9A-Za-z-]', 506, null);
    }
}