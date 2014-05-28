<?php

namespace ITDoors\AjaxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PaginatorController class
 *
 * Generates ajax paginator
 */
class PaginatorController extends BaseFilterController
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
        $page = $request->request->get('page');

        $paginationNamespace = $request->request->get('paginationNamespace');

        $this->setPaginator($paginationNamespace, $page);

        $result = array(
            'html' => '',
            'error' => false,
            'success' => true,
        );

        return new Response(json_encode($result));
    }
}
