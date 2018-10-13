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

use Hillrange\Form\Util\ButtonManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    /**
     * getParent
     *
     * @return null|string
     */
    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\CollectionType::class;
    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {

        $view->vars['allow_up']             = $options['sort_manage'];
        $view->vars['allow_down']           = $options['sort_manage'];
        $view->vars['allow_duplicate']      = $options['allow_duplicate'];
        $view->vars['unique_key']           = $options['unique_key'];
        $view->vars['route']                = $options['route'];
        $view->vars['redirect_route']       = $options['redirect_route'];
        $view->vars['route_params']         = $options['route_params'];
        $view->vars['display_script']       = $options['display_script'];
        $view->vars['removal_warning']      = $options['removal_warning'];
        $view->vars['allow_add']            = $options['allow_add'];
        $view->vars['allow_delete']         = $options['allow_delete'];
        $view->vars['remove_element_route'] = $options['remove_element_route'];
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'unique_key'            => 'id',
                'sort_manage'           => false,
                'allow_up'              => false,
                'allow_down'            => false,
                'allow_duplicate'       => false,
                'route'                 => '',
                'redirect_route'        => '',
                'route_params'          => [],
                'display_script'        => false,
                'add_button'            => '',
                'remove_button'         => '',
                'up_button'             => '',
                'down_button'           => '',
                'duplicate_button'      => '',
                'button_merge_class'    => '',
                'removal_warning'       => null,
                'remove_element_route'  => null,
            ]
        );
    }

    /**
     * @var ButtonManager
     */
    private $buttonManager;

    /**
     * CollectionType constructor.
     * @param ButtonManager $buttonManager
     */
    public function __construct(ButtonManager $buttonManager)
    {
        $this->buttonManager = $buttonManager;
    }

}