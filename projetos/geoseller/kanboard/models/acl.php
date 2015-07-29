<?php

namespace Model;

require_once __DIR__.'/base.php';

/**
 * Acl model
 *
 * @package  model
 * @author   Frederic Guillot
 */
class Acl extends Base
{
    /**
     * Controllers and actions allowed from outside
     *
     * @access private
     * @var array
     */
    private $public_actions = array(
        'user' => array('login', 'check', 'google'),
        'task' => array('add'),
        'board' => array('readonly'),
    );

    /**
     * Controllers and actions allowed for regular users
     *
     * @access private
     * @var array
     */
    private $user_actions = array(
        'app' => array('index'),
        'board' => array('index', 'show', 'assign', 'assigntask', 'save'),
        'project' => array('tasks', 'index', 'forbidden'),
        'task' => array('show', 'create', 'save', 'edit', 'update', 'close', 'confirmclose', 'open', 'confirmopen', 'description', 'duplicate'),
        'comment' => array('save', 'confirm', 'remove', 'update', 'edit'),
        'user' => array('index', 'edit', 'update', 'forbidden', 'logout', 'index', 'unlinkgoogle'),
        'config' => array('index', 'removeremembermetoken'),
    );

    /**
     * Return true if the specified controller/action is allowed according to the given acl
     *
     * @access public
     * @param  array    $acl          Acl list
     * @param  string   $controller   Controller name
     * @param  string   $action       Action name
     * @return bool
     */
    public function isAllowedAction(array $acl, $controller, $action)
    {
        if (isset($acl[$controller])) {
            return in_array($action, $acl[$controller]);
        }

        return false;
    }

    /**
     * Return true if the given action is public
     *
     * @access public
     * @param  string   $controller   Controller name
     * @param  string   $action       Action name
     * @return bool
     */
    public function isPublicAction($controller, $action)
    {
        return $this->isAllowedAction($this->public_actions, $controller, $action);
    }

    /**
     * Return true if the given action is allowed for a regular user
     *
     * @access public
     * @param  string   $controller   Controller name
     * @param  string   $action       Action name
     * @return bool
     */
    public function isUserAction($controller, $action)
    {
        return $this->isAllowedAction($this->user_actions, $controller, $action);
    }

    /**
     * Return true if the logged user is admin
     *
     * @access public
     * @return bool
     */
    public function isAdminUser()
    {
        return isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin'] === true;
    }

    /**
     * Return true if the logged user is not admin
     *
     * @access public
     * @return bool
     */
    public function isRegularUser()
    {
        return isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin'] === false;
    }

    /**
     * Get the connected user id
     *
     * @access public
     * @return integer
     */
    public function getUserId()
    {
        return isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : 0;
    }

    /**
     * Check is the user is connected
     *
     * @access public
     * @return bool
     */
    public function isLogged()
    {
        return ! empty($_SESSION['user']);
    }

    /**
     * Check is the user was authenticated with the RememberMe or set the value
     *
     * @access public
     * @param  bool   $value   Set true if the user use the RememberMe
     * @return bool
     */
    public function isRememberMe($value = null)
    {
        if ($value !== null) {
            $_SESSION['is_remember_me'] = $value;
        }

        return empty($_SESSION['is_remember_me']) ? false : $_SESSION['is_remember_me'];
    }

    /**
     * Check if an action is allowed for the logged user
     *
     * @access public
     * @param  string   $controller   Controller name
     * @param  string   $action       Action name
     * @return bool
     */
    public function isPageAccessAllowed($controller, $action)
    {
        return $this->isPublicAction($controller, $action) ||
               $this->isAdminUser() ||
               ($this->isRegularUser() && $this->isUserAction($controller, $action));
    }
}
