<?php
namespace Hillrange\Collection\React\Util;

/**
 * Class VersionManager
 * @package Hillrange\Collection\React\Util
 */
class VersionManager
{
    /**
     * String
     */
    const VERSION = '0.0.02';

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