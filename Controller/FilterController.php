<?php

namespace ITDoors\AjaxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * FilterController class
 *
 * Generates, submits, handles ajax filter forms
 */
class FilterController extends BaseFilterController
{
    /**
     * indexAction
     *
     * @param Request $request
     *
     * @return string
     */
    public function indexAction(Request $request)
    {
        $formAlias = $request->request->get('formAlias');

        $requestData = $request->request->get($formAlias);

        $form = $this->createForm($formAlias);

        if ($request->request->get('reset')) {
            $this->clearFilters($requestData['filterNamespace']);
        } else {

            $form->handleRequest($request);

            $data = $form->getData();

            $this->setFilters($requestData['filterNamespace'], $data);
        }

        $this->clearPaginator($requestData['filterNamespace']);

        $successFunctions = isset($requestData['successFunctions']) ?
            stripslashes($requestData['successFunctions']) :
            array();

        $result = array(
            'html' => '',
            'error' => false,
            'success' => true,
            'successFunctions' => $successFunctions
        );

        return new Response(json_encode($result));
    }
}
