<?php
/**
 * Created by PhpStorm.
 *
 * This file is part of the Busybee Project.
 *
 * (c) Craig Rayner <craig@craigrayner.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * User: craig
 * Date: 11/10/2018
 * Time: 11:50
 */
namespace Hillrange\Collection\React\Util;

/**
 * Interface CollectionInterface
 * @package Hillrange\Collection\React\Util
 */
interface CollectionInterface
{
    /**
     * getTemplate
     *
     * @param string $name
     * @return array
     */
    public function getTemplate(string $name = 'default'): array ;
}