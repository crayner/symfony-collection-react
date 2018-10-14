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
 * Time: 17:06
 */
namespace Hillrange\Collection\React\Manager;

use App\Entity\TimetableColumnRow;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CollectionManager
 * @package Hillrange\Collection\React\Manager
 */
class CollectionManager
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var RequestStack
     */
    private $stack;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * CollectionManager constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig, RequestStack $stack, TranslatorInterface $translator)
    {
        $this->twig = $twig;
        $this->stack = $stack;
        $this->translator = $translator;
    }

    /**
     * @var string
     */
    private $content;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
    
    /**
     * setContent
     *
     * @param string $content
     * @return CollectionManager
     */
    public function setContent(string $content): CollectionManager
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig(): \Twig_Environment
    {
        return $this->twig;
    }

    /**
     * @var array
     */
    private $template;

    /**
     * collectionScript
     *
     * @param FormView $collection
     * @param array $template
     * @return \Twig_Markup
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function collectionScript(FormView $collection)
    {
        $this->template = $collection->vars['template'];

        $x = $this->getTwig()->render('@HillrangeCollectionReact/Scripts/collection_script.html.twig',
            [
                'collection'        => $collection,
            ]
        );
        return new \Twig_Markup($x, 'html');
    }

    /**
     * collectionContainer
     *
     * @param FormView $form
     * @param bool $setRendered
     * @return string
     */
    public function collectionContainer(FormView $collection): string
    {
        $this->setCollectionName($collection->vars['id']);
        return '<div id="'.$this->getCollectionName().'_container"></div>';
    }

    /**
     * collectionWidget
     *
     * @param FormView $collection
     * @return \Twig_Markup
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function collectionWidget(FormView $collection): string
    {
        $x = $this->getTwig()->render('@HillrangeCollectionReact/Collection/collection_widget.html.twig',
            [
                'collection'        => $collection,
            ]
        );

        $this->setContent(new \Twig_Markup($x, 'html'));
        $this->addStyle($collection->vars['id'], 'widget');
        return $this->collectionContainer($collection);
    }

    /**
     * collectionRow
     *
     * @param FormView $collection
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function collectionRow(FormView $collection): string
    {
        $x = $this->getTwig()->render('@HillrangeCollectionReact/Collection/collection_row.html.twig',
            [
                'collection'        => $collection,
            ]
        );

        $this->setContent(new \Twig_Markup($x, 'html'));
        $this->addStyle($collection->vars['id'], 'row');
        return $this->collectionContainer($collection);
    }

    /**
     * getProps
     *
     * @param FormView $collection
     * @return array
     */
    public function getProps(FormView $collection): array
    {
        $this->setCollectionName($collection->vars['id']);
        $props = [];
        $props['content'] = $this->getContent();
        $props['translations'] = $this->getCollectionTranslations($collection);
        $props['locale'] = $this->getRequest()->get('_locale') ?: 'en';
        $props['collection_element'] = $this->getCollectionName().'_container';
        $props['template'] = $this->getTemplate();
        $props['form'] = $this->extractForm($collection->vars['form']);
        $props['style'] = $this->getStyle()[$props['form']['id']];

        if (isset($collection->vars['prototype']) && $collection->vars['prototype'] instanceof FormView)
        {
            $props['prototype'] = $this->extractForm($collection->vars['prototype']);
            unset($props['form']['prototype']);
        }
        return $props;
    }

    /**
     * getStack
     *
     * @return RequestStack
     */
    public function getStack(): RequestStack
    {
        return $this->stack;
    }

    /**
     * getRequest
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->getStack()->getCurrentRequest();
    }

    /**
     * @var string|null
     */
    private $collectionName;

    /**
     * @return null|string
     */
    public function getCollectionName(): ?string
    {
        return $this->collectionName;
    }

    /**
     * @param null|string $collectionName
     * @return CollectionManager
     */
    public function setCollectionName(string $collectionName): CollectionManager
    {
        $this->collectionName = $collectionName;
        return $this;
    }

    /**
     * extractForm
     *
     * @param FormView $formView
     * @return array
     */
    public function extractForm(FormView $formView): array
    {
        $vars = $formView->vars;
        $vars['children'] = [];
        foreach($formView->children as $child)
        {
            $vars['children'][] = $this->extractForm($child);
        }

        if (is_object($vars['value'])){
            $vars['data_id'] = null;
            $vars['data_toString'] = null;
            if (method_exists($vars['value'], 'getId'))
                $vars['data_id'] = $vars['value']->getId();
            if (method_exists($vars['value'], 'getName'))
                $vars['data_toString'] = $vars['value']->getName();
            if (method_exists($vars['value'], '__toString'))
                $vars['data_toString'] = $vars['value']->__toString();
        }

        unset($vars['form']);
        return $vars;
    }

    /**
     * @return array
     */
    public function getTemplate(): array
    {
        return $this->template;
    }

    /**
     * @var array
     */
    private $style = [];

    /**
     * @return array
     */
    public function getStyle(): array
    {
        return $this->style = is_array($this->style) ? $this->style : [];
    }

    /**
     * addStyle
     *
     * @param string $id
     * @param string $type
     * @return CollectionManager
     */
    public function addStyle(string $id, string $type): CollectionManager
    {
        $this->style = $this->getStyle();
        $this->style[$id] = $type;
        return $this;
    }

    /**
     * getTranslator
     *
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * getCollectionTranslations
     *
     * @param FormView $collection
     */
    public function getCollectionTranslations(FormView $collection): array
    {
        $translations = [];

        foreach($collection->children as $form)
        {
            $translations = array_merge($translations, $this->getCollectionTranslations($form));
        }

        if ($collection->vars['translation_domain'] === false)
            return [];

        if (isset($collection->vars['choices']))
        {
            if ($collection->vars['choice_translation_domain'] !== false)
            {
                $translationDomain = $collection->vars['choice_translation_domain'];
                if (empty($translationDomain))
                    $translationDomain = $collection->vars['translation_domain'];
                foreach($collection->vars['choices'] as $choice)
                {
                    $translations[$choice->label] = $this->translator->trans($choice->label, [], $translationDomain);
                }
            }
        }

        if (! empty($collection->vars['label']))
        {
            $translations[$collection->vars['label']] = $this->translator->trans($collection->vars['label'], [], $collection->vars['translation_domain']);
        }
        if (! empty($collection->vars['placeholder']))
        {
            $translations[$collection->vars['placeholder']] = $this->translator->trans($collection->vars['placeholder'], [], $collection->vars['translation_domain']);
        }
        if (! empty($collection->vars['help']))
        {
            $translations[$collection->vars['help']] = $this->translator->trans($collection->vars['help'], [], $collection->vars['translation_domain']);
        }
        return $translations;
    }
}