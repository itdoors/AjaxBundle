<?php
namespace ITDoors\AjaxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * BaseFilterController
 *
 * @author Denys Lishchenko <silence4r4@mail.ru>
 *
 */
class BaseFilterController extends Controller
{
    const FILTER_KEY = 'filter';
    const ORDER_KEY = 'order';
    const PAGINATOR_KEY = 'paginator';
    const TAB_KEY = 'tab';
    protected $filterNamespace = 'ajax.default.namespace';
    protected $filterFormName = 'baseSalesFilterForm';
    protected $baseRoute = 'lists_sales_base_index';

    /**
     * setFilters into the session with namespace as a key
     *
     * @param string  $filterNamespace
     * @param mixed[] $data
     * @param string  $type
     */

    public function setSessionValues($filterNamespace = '', $data = array(), $type = self::FILTER_KEY)
    {
        $session = $this->get('session');
        $filterNamespace = $filterNamespace ? $filterNamespace : $this->filterNamespace;

        $dataAll = $session->get($filterNamespace);

        if (is_array($dataAll)) {
            $dataAll[$type] = $data;
            $session->set($filterNamespace, $dataAll);
        } else {
            $session->set($filterNamespace, array($type => $data));
        }

    }

    /**
     * Get filter from session
     *
     * @param string $filterNamespace
     * @param string $type
     *
     * @return mixed[]
     */
    public function getSessionValues($filterNamespace = '', $type = self::FILTER_KEY)
    {
        /** @var Session $session */
        $session = $this->get('session');

        $filterNamespace = $filterNamespace ? $filterNamespace : $this->filterNamespace;

        $data = $session->get($filterNamespace);

        if (is_array($data) && array_key_exists($type, $data)) {
            return $data[$type];
        }

        return array();
    }

    /**
     * Clear filters of type
     *
     * @param string $filterNamespace
     * @param string $type
     */
    public function clearSessionValues($filterNamespace = '', $type = self::FILTER_KEY)
    {
        $filterNamespace = $filterNamespace ? $filterNamespace : $this->filterNamespace;
        $this->setSessionValues($filterNamespace, array(), $type);
    }

    /**
     * Adds record to session
     *
     * @param string $key
     * @param string $value
     * @param string $type
     */
    public function addToSessionValues($key, $value, $type = self::FILTER_KEY)
    {
        $data = $this->getSessionValues($this->getNamespace(), $type);

        $data[$key] = $value;

        $this->setSessionValues($this->getNamespace(), $data, $type);
    }

    /**
     * Removes record from session by key
     *
     * @param string $key
     * @param string $filterNamespace
     * @param string $type
     */
    public function removeFromSessionValues($key, $filterNamespace = '', $type = self::FILTER_KEY)
    {
        $filterNamespace = $filterNamespace ? $filterNamespace : $this->filterNamespace;
        $data = $this->getSessionValues($filterNamespace, $type);

        if (isset($data[$key])) {
            unset($data[$key]);
        }

        $this->setSessionValues($this->getNamespace(), $data, $type);
    }

    /**
     * Returns filter namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->filterNamespace;
    }

    /**
     * Retruns filter value by key
     *
     * @param string $key
     * @param string $default
     * @param string $filterNamespace
     * @param string $type
     *
     * @return mixed
     */
    public function getSessionValueByKey($key, $default = null, $filterNamespace = '', $type = self::FILTER_KEY)
    {
        $filterNamespace = $filterNamespace ? $filterNamespace : $this->filterNamespace;
        $data = $this->getSessionValues($filterNamespace, $type);

        if (isset($data[$key])) {
            return $data[$key];
        }

        return $default;
    }

    /////////////////////////filters functions////////////////////////////////

    /**
     * setFilters into the session with namespace as a key
     *
     * @param string  $filterNamespace
     * @param mixed[] $data
     */

    public function setFilters($filterNamespace = '', $data = array())
    {
        $this -> setSessionValues($filterNamespace, $data, self::FILTER_KEY);
    }

    /**
     * Get filter from session
     *
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getFilters($filterNamespace = '')
    {
        return $this->getSessionValues($filterNamespace, self::FILTER_KEY);
    }

    /**
     * Clear filters of type
     *
     * @param string $filterNamespace
     */
    public function clearFilters($filterNamespace = '')
    {
        $this->clearSessionValues($filterNamespace, self::FILTER_KEY);
    }

    /**
     * Adds record to session
     *
     * @param string $key
     * @param string $value
     */
    public function addToFilters($key, $value)
    {
        $this->addToSessionValues($key, $value, self::FILTER_KEY);
    }

    /**
     * Removes record from session by key
     *
     * @param string $key
     * @param string $filterNamespace
     */
    public function removeFromFilters($key, $filterNamespace = '')
    {
        $this->removeFromSessionValues($key, $filterNamespace, self::FILTER_KEY);
    }

    /**
     * Returns filter value by key
     *
     * @param string $key
     * @param string $default
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getFilterValueByKey($key, $default = null, $filterNamespace = '')
    {
        $this->getSessionValueByKey($key, $default, $filterNamespace, self::FILTER_KEY);
    }

    /////////////////////////pagination functions////////////////////////////////

    /**
     * setPaginator into the session with namespace as a key
     *
     * @param string  $filterNamespace
     * @param mixed[] $data
     */

    public function setPaginator($filterNamespace = '', $data = array())
    {
        $this -> setSessionValues($filterNamespace, $data, self::PAGINATOR_KEY);
    }

    /**
     * Get filter from session
     *
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getPaginator($filterNamespace = '')
    {
        return $this->getSessionValues($filterNamespace, self::PAGINATOR_KEY);
    }

    /**
     * Clear filters of type
     *
     * @param string $filterNamespace
     */
    public function clearPaginator($filterNamespace = '')
    {
        $this->clearSessionValues($filterNamespace, self::PAGINATOR_KEY);
    }

    /**
     * Adds record to session
     *
     * @param string $key
     * @param string $value
     */
    public function addToPaginator($key, $value)
    {
        $this->addToSessionValues($key, $value, self::PAGINATOR_KEY);
    }

    /**
     * Removes record from session by key
     *
     * @param string $key
     * @param string $filterNamespace
     */
    public function removeFromPaginator($key, $filterNamespace = '')
    {
        $this->removeFromSessionValues($key, $filterNamespace, self::PAGINATOR_KEY);
    }

    /**
     * Returns filter value by key
     *
     * @param string $key
     * @param string $default
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getPaginatorValueByKey($key, $default = null, $filterNamespace = '')
    {
        $this->getSessionValueByKey($key, $default, $filterNamespace, self::PAGINATOR_KEY);
    }

    /////////////////////////tab functions////////////////////////////////

    /**
     * setTab into the session with namespace as a key
     *
     * @param string  $filterNamespace
     * @param mixed[] $data
     */

    public function setTab($filterNamespace = '', $data = array())
    {
        $this -> setSessionValues($filterNamespace, $data, self::TAB_KEY);
    }

    /**
     * Get filter from session
     *
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getTab($filterNamespace = '')
    {
        return $this->getSessionValues($filterNamespace, self::TAB_KEY);
    }

    /**
     * Clear filters of type
     *
     * @param string $filterNamespace
     */
    public function clearTab($filterNamespace = '')
    {
        $this->clearSessionValues($filterNamespace, self::TAB_KEY);
    }

    /**
     * Adds record to session
     *
     * @param string $key
     * @param string $value
     */
    public function addToTab($key, $value)
    {
        $this->addToSessionValues($key, $value, self::TAB_KEY);
    }

    /**
     * Removes record from session by key
     *
     * @param string $key
     * @param string $filterNamespace
     */
    public function removeFromTab($key, $filterNamespace = '')
    {
        $this->removeFromSessionValues($key, $filterNamespace, self::TAB_KEY);
    }

    /**
     * Returns filter value by key
     *
     * @param string $key
     * @param string $default
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getTabValueByKey($key, $default = null, $filterNamespace = '')
    {
        $this->getSessionValueByKey($key, $default, $filterNamespace, self::TAB_KEY);
    }

    /////////////////////////order functions////////////////////////////////

    /**
     * setPaginator into the session with namespace as a key
     *
     * @param string  $filterNamespace
     * @param mixed[] $data
     */

    public function setOrdering($filterNamespace = '', $data = array())
    {
        $this -> setSessionValues($filterNamespace, $data, self::ORDER_KEY);
    }

    /**
     * Get filter from session
     *
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getOrdering($filterNamespace = '')
    {
        return $this->getSessionValues($filterNamespace, self::ORDER_KEY);
    }

    /**
     * Clear filters of type
     *
     * @param string $filterNamespace
     */
    public function clearOrdering($filterNamespace = '')
    {
        $this->clearSessionValues($filterNamespace, self::ORDER_KEY);
    }

    /**
     * Adds record to session
     *
     * @param string $key
     * @param string $value
     */
    public function addToOrdering($key, $value)
    {
        $this->addToSessionValues($key, $value, self::ORDER_KEY);
    }

    /**
     * Removes record from session by key
     *
     * @param string $key
     * @param string $filterNamespace
     */
    public function removeFromOrdering($key, $filterNamespace = '')
    {
        $this->removeFromSessionValues($key, $filterNamespace, self::ORDER_KEY);
    }

    /**
     * Returns filter value by key
     *
     * @param string $key
     * @param string $default
     * @param string $filterNamespace
     *
     * @return mixed
     */
    public function getOrderingValueByKey($key, $default = null, $filterNamespace = '')
    {
        $this->getSessionValueByKey($key, $default, $filterNamespace, self::ORDER_KEY);
    }
}
