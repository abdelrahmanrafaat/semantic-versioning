<?php

namespace Abdelrahmanrafaat\SemanticVersion\NormalVersion;

/**
 * Class MajorCanNotBeZeroException
 *
 * @package Abdelrahmanrafaat\SemanticVersion\NormalVersion
 */
class MajorIdentifierCanNotBeZeroException extends \Exception
{
    /**
     * MajorCanNotBeZeroException constructor.
     */
    public function __construct()
    {
        parent::__construct('Major identifier in normal version can not be 0', 507, null);
    }
}