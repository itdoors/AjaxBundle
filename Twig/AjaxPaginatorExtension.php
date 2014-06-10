<?php

namespace ITDoors\AjaxBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

/**
 * Twig extension for rendering paginator
 *
 * @author Denys Lishchenko <silence4r4@mail.ru>
 *
 */
class AjaxPaginatorExtension extends \Twig_Extension
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
            'ajax_paginator_render' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders the pagination template
     *
     * @param mixed[] $pagination
     * @param string  $paginationNamespace
     * @param string  $successFunctions
     * @param string  $template
     *
     * @return string
     */
    public function render(
        $pagination,
        $paginationNamespace = '',
        $successFunctions = '',
        $template = "ITDoorsCommonBundle:AjaxPagination:sliding.html.twig"
    // @codingStandardsIgnoreStart
    )
    {
    // @codingStandardsIgnoreEnd
        $data = $pagination->getPaginationData();

        $data['route'] = $pagination->getRoute();
        $data['query'] = $pagination->getParams();
        $data['successFunctions'] = $successFunctions;
        $data['paginationNamespace'] = $paginationNamespace;

        return $this->environment->render($template, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ajax_paginator';
    }
}
