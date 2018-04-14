<?php

namespace Abdelrahmanrafaat\SemanticVersion\BuildMetaData;

/**
 * Class EmptyBuildMetaDataIdentifierException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\BuildMetaData
 */
class EmptyBuildMetaDataIdentifierException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Build meta data identifiers should not be empty', 505, null);
    }
}