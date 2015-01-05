<?php
namespace ITDoors\AjaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * FormController
 */
class FormController extends Controller
{
    /**
     * Index action
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $params = json_decode(stripslashes($request->request->get('params')), true);

        $form = $this->createForm($params['formType']);

        // Set defaults, defaults are always isset
        $this->setDefaults($form, $params);

        $form->handleRequest($request);

        $return = array(
            'error' => false,
            'success' => false
        );

        $return['params'] = json_encode($params);

        if ($form->isValid()) {
            $return['success'] = true;

            $this->saveForm($form, $request, $params);
        } else {
            $html = 'ITDoorsAjaxBundle:Form:ajaxForm.html.twig';
            if (isset($params['html'])) {
                $html = $params['html'];
            }

            $return['error'] = true;
            $return['content'] = $this->renderView($html, array(
                'form' => $form->createView(),
                'params' => json_encode($params)
            ));
        }

        return new Response(json_encode($return));
    }

    /**
     * Set form default values
     *
     * @param Form    $form
     * @param mixed[] $params
     */
    public function setDefaults(Form $form, $params)
    {
        // Add defaults as hidden fields
        foreach ($params['defaults'] as $key => $default) {
            $form
                ->add($key, 'hidden', array(
                    'data' => $default
                ));
        }

        // If isset serviceDefault then add form dynamic defaults depending on static defaults
        if (isset($params['serviceDefault']) && sizeof($params['serviceDefault'])) {
            $serviceDefault = $this->container->get($params['serviceDefault']['alias']);
            $serviceDefaultMethod = $params['serviceDefault']['method'];

            if (method_exists($serviceDefault, $serviceDefaultMethod)) {
                $serviceDefault->$serviceDefaultMethod($form, $params['defaults']);
            }
        }

        // Add Submit buttons
        $form
            ->add('submit', 'submit')
            ->add('cancel', 'submit');
    }

    /**
     * Saves form
     *
     * @param Form    $form
     * @param Request $request
     * @param mixed[] $params
     */
    public function saveForm(Form $form, Request $request, $params)
    {
        // Fires service method to save form
        if (isset($params['serviceSave']) && sizeof($params['serviceSave'])) {
            $serviceSave = $this->container->get($params['serviceSave']['alias']);
            $serviceSaveMethod = $params['serviceSave']['method'];

            if (method_exists($serviceSave, $serviceSaveMethod)) {
                $serviceSave->$serviceSaveMethod($form, $request, $params);
            }
        }
    }
}
