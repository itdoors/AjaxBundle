<?php

namespace ITDoors\AjaxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PaginatorController class
 *
 * Generates ajax paginator
 */
class OrderingController extends BaseFilterController
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
        $field = $request->request->get('field');
        $orderType = $request->request->get('type');
        $oneField = $request->request->get('oneField');
        $orderingNamespace = $request->request->get('orderingNamespace');

        if ($oneField) {
            $this->clearOrdering($orderingNamespace);
        }
        $this->addToOrdering($field, $orderType, $orderingNamespace);

        $result = array(
            'html' => '',
            'error' => false,
            'success' => true,
        );

        return new Response(json_encode($result));
    }
}
