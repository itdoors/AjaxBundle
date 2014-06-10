<?php

namespace ITDoors\AjaxBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

/**
 * Twig extension for rendering paginator
 *
 * @author Denys Lishchenko <silence4r4@mail.ru>
 *
 */
class AjaxTabExtension extends \Twig_Extension
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
            'ajax_tab_render' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    /**
     * @param mixed[] $tabs
     * @param string  $tab
     * @param string  $tabNamespace
     * @param string  $template
     *
     * @return string
     */
    public function render(
        $tabs,
        $tab,
        $tabNamespace = '',
        $template = "ITDoorsCommonBundle:AjaxTab:tab.html.twig"
    // @codingStandardsIgnoreStart
    )
    {
    // @codingStandardsIgnoreEnd
        $data =array() ;
        $data['tabs'] = $tabs;
        $data['tab'] = $tab;
        $data['tabNamespace'] = $tabNamespace;

        return $this->environment->render($template, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ajax_tab';
    }
}
