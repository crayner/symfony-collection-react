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
 * Date: 9/10/2018
 * Time: 16:48
 */
namespace Hillrange\Collection\React\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Class CollectionType
 * @package Hillrange\Collection\React\Form\Type
 */
class CollectionType extends AbstractType
{
    /**
     * getBlockPrefix
     *
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return 'hillrange_collection_' . parent::getBlockPrefix();
    }

}