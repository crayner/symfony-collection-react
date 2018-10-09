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

use Symfony\Component\Form\Form;
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
            new \Twig_SimpleFunction('reactCollection', [$this, 'reactCollection']),
        ];
    }

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * CollectionExtension constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * reactCollection
     *
     * @param Form $form
     */
    public function reactCollection(Form $form)
    {
        dump($form);
    }
}