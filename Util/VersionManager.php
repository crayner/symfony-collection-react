<?php
namespace Hillrange\Collection\Util;

/**
 * Class VersionManager
 * @package Hillrange\Form\Util
 */
class VersionManager
{
    /**
     * String
     */
    const VERSION = '0.0.00';

    /**
     * getVersion
     *
     * @return string
     */
    public function getVersion(): string
    {
        return VersionManager::VERSION;
    }
}