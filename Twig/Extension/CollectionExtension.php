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
 * Time: 17:01
 */
namespace Hillrange\Collection\React\Twig\Extension;

use Hillrange\Collection\React\Manager\CollectionManager;
use Twig\Extension\AbstractExtension;

/**
 * Class CollectionExtension
 * @package Hillrange\Collection\React\Twig\Extension
 */
class CollectionExtension extends AbstractExtension
{
    /**
     * getFunctions
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('collectionScript', [$this->collectionManager, 'collectionScript']),
            new \Twig_SimpleFunction('collectionContainer', [$this->collectionManager, 'collectionContainer']),
            new \Twig_SimpleFunction('collectionWidget', [$this->collectionManager, 'collectionWidget']),
            new \Twig_SimpleFunction('collectionRow', [$this->collectionManager, 'collectionRow']),
            new \Twig_SimpleFunction('getCollectionManager', [$this, 'getCollectionManager']),
        ];
    }

    /**
     * @var CollectionManager
     */
    private $collectionManager;

    /**
     * CollectionExtension constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(CollectionManager $collectionManager)
    {
        $this->collectionManager = $collectionManager;
    }

    /**
     * @return CollectionManager
     */
    public function getCollectionManager(): CollectionManager
    {
        return $this->collectionManager;
    }
}