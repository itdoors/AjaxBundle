<?php

namespace ITDoors\AjaxBundle\Twig;

use Knp\Bundle\PaginatorBundle\Twig\Extension\PaginationExtension;
use Knp\Bundle\PaginatorBundle\Helper\Processor;
use Symfony\Component\DependencyInjection\Container;

/**
 * Twig extension for rendering ordering
 *
 * @author Denys Lishchenko <silence4r4@mail.ru>
 *
 */
class AjaxOrderingExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var Container
     */
    protected $container;

    /**
     * __construct()
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return array(
            'ajax_ordering' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    /**
     * @param string $field
     * @param string $orderingNamespace
     * @param string $successFunctions
     * @param string $template
     *
     * @return string
     */
    public function render(
        $field,
        $orderingNamespace = '',
        $successFunctions = '',
        $template = "ITDoorsCommonBundle:AjaxOrdering:ordering.html.twig"
        // @codingStandardsIgnoreStart
    )
    {
        // @codingStandardsIgnoreStart

        $ordering = $this->getOrdering($orderingNamespace);

        if (isset($ordering[$field]) && $ordering[$field]) {
            $ordered = $ordering[$field];
        }
        $data['field'] = $field;
        $data['successFunctions'] = $successFunctions;
        $data['orderingNamespace'] = $orderingNamespace;
        $data['ordered'] = $ordered;

        return $this->environment->render($template, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ajax_ordering';
    }
}
