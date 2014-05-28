<?php

namespace ITDoors\AjaxBundle\Twig;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Twig extension for rendering filter form
 *
 * @author Pavel Pecheny <ppecheny@gmail.com>
 *
 */
class AjaxFilterExtension extends \Twig_Extension
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
            'ajax_filter_render' =>
                new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
            'ajax_filter_render_short' =>
                new \Twig_Function_Method($this, 'renderShort', array('is_safe' => array('html')))
        );
    }

    /**
     * Renders filter form for ajax submit
     *
     * @param string   $formAlias        form service alias
     * @param string   $filterNamespace  filter session holder name
     * @param string[] $successFunctions function that triggers when filter form is valid \
     *                                   array('targetId' => array('functionName1', 'functionName2'))
     * @param boolean  $isShort          if true then render without submit btns
     *
     * @return string
     */
    public function render($formAlias, $filterNamespace, $successFunctions = array(), $isShort = false)
    {
        $sessionFilters = $this->getSessionFilters($filterNamespace);

        /** @var Form $form */
        $form = $this->container->get('form.factory')->create($formAlias, $sessionFilters);

        $form
            ->add('formAlias', 'hidden', array(
                'data' => $formAlias,
                'attr' => array(
                    'name' => 'formAlias'
                )
            ))
            ->add('filterNamespace', 'hidden', array(
                'data' => $filterNamespace
            ));

        if (sizeof($successFunctions)) {
            $form
                ->add('successFunctions', 'hidden', array(
                    'data' => json_encode($successFunctions)
                ));
        }

        if (!$isShort) {
            // Maybe need add in controller... will see
            $form
                ->add('submit', 'submit')
                ->add('reset', 'submit');
        }

        $template = $isShort ? 'formShort.html.twig' : 'form.html.twig';

        return $this->environment->render("ITDoorsAjaxBundle:Filter:{$template}", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Renders filter form for ajax submit without submit btns
     *
     * @param string   $formAlias        form service alias
     * @param string   $filterNamespace  filter session holder name
     * @param string[] $successFunctions function that triggers when filter form is valid \
     *                                   array('targetId' => array('functionName1', 'functionName2'))
     *
     * @return string
     */
    public function renderShort($formAlias, $filterNamespace, $successFunctions = array())
    {
        return $this->render($formAlias, $filterNamespace, $successFunctions, true);
    }

    /**
     * Return session filter data depending on filter namespace
     *
     * @param string $namespace
     *
     * @return mixed[]
     */
    public function getSessionFilters($namespace)
    {
        /** @var Session $session */
        $session = $this->container->get('session');

        return $session->get($namespace);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ajax_filter';
    }
}
