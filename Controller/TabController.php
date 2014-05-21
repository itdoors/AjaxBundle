<?php

namespace ITDoors\AjaxBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * TabController class
 *
 * Generates ajax tab
 */
class TabController extends BaseFilterController
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

        $tabNamespace = $request->request->get('tabNamespace');


        $tab = $request->request->get('tab');

        $this->setTab($tabNamespace, $tab);

        $result = array(
            'html' => '',
            'error' => false,
            'success' => true,
        );

        return new Response(json_encode($result));
    }
}
