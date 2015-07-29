<?php

namespace Model;

require_once __DIR__.'/base.php';

use \SimpleValidator\Validator;
use \SimpleValidator\Validators;

/**
 * User model
 *
 * @package  model
 * @author   Frederic Guillot
 */
class User extends Base
{
    /**
     * SQL table name
     *
     * @var string
     */
    const TABLE = 'users';

    /**
     * Id used for everbody (filtering)
     *
     * @var integer
     */
    const EVERYBODY_ID = -1;

    /**
     * Get a specific user by id
     *
     * @access public
     * @param  integer  $user_id  User id
     * @return array
     */
    public function getById($user_id)
    {
        return $this->db->table(self::TABLE)->eq('id', $user_id)->findOne();
    }

    /**
     * Get a specific user by the Google id
     *
     * @access public
     * @param  string  $google_id  Google unique id
     * @return array
     */
    public function getByGoogleId($google_id)
    {
        return $this->db->table(self::TABLE)->eq('google_id', $google_id)->findOne();
    }

    /**
     * Get a specific user by the username
     *
     * @access public
     * @param  string  $username  Username
     * @return array
     */
    public function getByUsername($username)
    {
        return $this->db->table(self::TABLE)->eq('username', $username)->findOne();
    }

    /**
     * Get all users
     *
     * @access public
     * @return array
     */
    public function getAll()
    {
        return $this->db
                    ->table(self::TABLE)
                    ->asc('username')
                    ->columns('id', 'username', 'name', 'email', 'is_admin', 'default_project_id', 'is_ldap_user')
                    ->findAll();
    }

    /**
     * List all users (key-value pairs with id/username)
     *
     * @access public
     * @return array
     */
    public function getList()
    {
        return $this->db->table(self::TABLE)->asc('username')->listing('id', 'username');
    }

    /**
     * Add a new user in the database
     *
     * @access public
     * @param  array  $values  Form values
     * @return boolean
     */
    public function create(array $values)
    {
        if (isset($values['confirmation'])) {
            unset($values['confirmation']);
        }

        if (isset($values['password'])) {
            $values['password'] = \password_hash($values['password'], PASSWORD_BCRYPT);
        }

        return $this->db->table(self::TABLE)->save($values);
    }

    /**
     * Modify a new user
     *
     * @access public
     * @param  array  $values  Form values
     * @return array
     */
    public function update(array $values)
    {
        if (! empty($values['password'])) {
            $values['password'] = \password_hash($values['password'], PASSWORD_BCRYPT);
        }
        else {
            unset($values['password']);
        }

        if (isset($values['confirmation'])) {
            unset($values['confirmation']);
        }

        if (isset($values['current_password'])) {
            unset($values['current_password']);
        }

        $result = $this->db->table(self::TABLE)->eq('id', $values['id'])->update($values);

        if ($_SESSION['user']['id'] == $values['id']) {
            $this->updateSession();
        }

        return $result;
    }

    /**
     * Remove a specific user
     *
     * @access public
     * @param  integer  $user_id  User id
     * @return boolean
     */
    public function remove($user_id)
    {
        $this->db->startTransaction();

        // All tasks assigned to this user will be unassigned
        $this->db->table(Task::TABLE)->eq('owner_id', $user_id)->update(array('owner_id' => ''));
        $this->db->table(self::TABLE)->eq('id', $user_id)->remove();

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Update user session information
     *
     * @access public
     * @param  array  $user  User data
     */
    public function updateSession(array $user = array())
    {
        if (empty($user)) {
            $user = $this->getById($_SESSION['user']['id']);
        }

        if (isset($user['password'])) {
            unset($user['password']);
        }

        $user['id'] = (int) $user['id'];
        $user['default_project_id'] = (int) $user['default_project_id'];
        $user['is_admin'] = (bool) $user['is_admin'];
        $user['is_ldap_user'] = (bool) $user['is_ldap_user'];

        $_SESSION['user'] = $user;
    }

    /**
     * Validate user creation
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validateCreation(array $values)
    {
        $v = new Validator($values, array(
            new Validators\Required('username', t('The username is required')),
            new Validators\MaxLength('username', t('The maximum length is %d characters', 50), 50),
            new Validators\AlphaNumeric('username', t('The username must be alphanumeric')),
            new Validators\Unique('username', t('The username must be unique'), $this->db->getConnection(), self::TABLE, 'id'),
            new Validators\Required('password', t('The password is required')),
            new Validators\MinLength('password', t('The minimum length is %d characters', 6), 6),
            new Validators\Required('confirmation', t('The confirmation is required')),
            new Validators\Equals('password', 'confirmation', t('Passwords doesn\'t matches')),
            new Validators\Integer('default_project_id', t('This value must be an integer')),
            new Validators\Integer('is_admin', t('This value must be an integer')),
            new Validators\Email('email', t('Email address invalid')),
        ));

        return array(
            $v->execute(),
            $v->getErrors()
        );
    }

    /**
     * Validate user modification
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validateModification(array $values)
    {
        if (! empty($values['password'])) {
            return $this->validatePasswordModification($values);
        }

        $v = new Validator($values, array(
            new Validators\Required('id', t('The user id is required')),
            new Validators\Required('username', t('The username is required')),
            new Validators\MaxLength('username', t('The maximum length is %d characters', 50), 50),
            new Validators\AlphaNumeric('username', t('The username must be alphanumeric')),
            new Validators\Unique('username', t('The username must be unique'), $this->db->getConnection(), self::TABLE, 'id'),
            new Validators\Integer('default_project_id', t('This value must be an integer')),
            new Validators\Integer('is_admin', t('This value must be an integer')),
            new Validators\Email('email', t('Email address invalid')),
        ));

        return array(
            $v->execute(),
            $v->getErrors()
        );
    }

    /**
     * Validate password modification
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validatePasswordModification(array $values)
    {
        $v = new Validator($values, array(
            new Validators\Required('id', t('The user id is required')),
            new Validators\Required('username', t('The username is required')),
            new Validators\MaxLength('username', t('The maximum length is %d characters', 50), 50),
            new Validators\AlphaNumeric('username', t('The username must be alphanumeric')),
            new Validators\Unique('username', t('The username must be unique'), $this->db->getConnection(), self::TABLE, 'id'),
            new Validators\Required('current_password', t('The current password is required')),
            new Validators\Required('password', t('The password is required')),
            new Validators\MinLength('password', t('The minimum length is %d characters', 6), 6),
            new Validators\Required('confirmation', t('The confirmation is required')),
            new Validators\Equals('password', 'confirmation', t('Passwords doesn\'t matches')),
            new Validators\Integer('default_project_id', t('This value must be an integer')),
            new Validators\Integer('is_admin', t('This value must be an integer')),
            new Validators\Email('email', t('Email address invalid')),
        ));

        if ($v->execute()) {

            // Check password
            list($authenticated,) = $this->authenticate($_SESSION['user']['username'], $values['current_password']);

            if ($authenticated) {
                return array(true, array());
            }
            else {
                return array(false, array('current_password' => array(t('Wrong password'))));
            }
        }

        return array(false, $v->getErrors());
    }

    /**
     * Validate user login
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validateLogin(array $values)
    {
        $v = new Validator($values, array(
            new Validators\Required('username', t('The username is required')),
            new Validators\MaxLength('username', t('The maximum length is %d characters', 50), 50),
            new Validators\Required('password', t('The password is required')),
        ));

        $result = $v->execute();
        $errors = $v->getErrors();

        if ($result) {

            list($authenticated, $method) = $this->authenticate($values['username'], $values['password']);

            if ($authenticated === true) {

                // Create the user session
                $user = $this->getByUsername($values['username']);
                $this->updateSession($user);

                // Update login history
                $lastLogin = new LastLogin($this->db, $this->event);
                $lastLogin->create(
                    $method,
                    $user['id'],
                    $this->getIpAddress(),
                    $this->getUserAgent()
                );

                // Setup the remember me feature
                if (! empty($values['remember_me'])) {
                    $rememberMe = new RememberMe($this->db, $this->event);
                    $credentials = $rememberMe->create($user['id'], $this->getIpAddress(), $this->getUserAgent());
                    $rememberMe->writeCookie($credentials['token'], $credentials['sequence'], $credentials['expiration']);
                }
            }
            else {
                $result = false;
                $errors['login'] = t('Bad username or password');
            }
        }

        return array(
            $result,
            $errors
        );
    }

    /**
     * Authenticate a user
     *
     * @access public
     * @param  string  $username  Username
     * @param  string  $password  Password
     * @return array
     */
    public function authenticate($username, $password)
    {
        // Database authentication
        $user = $this->db->table(self::TABLE)->eq('username', $username)->eq('is_ldap_user', 0)->findOne();
        $authenticated = $user && \password_verify($password, $user['password']);
        $method = LastLogin::AUTH_DATABASE;

        // LDAP authentication
        if (! $authenticated && LDAP_AUTH) {
            require __DIR__.'/ldap.php';
            $ldap = new Ldap($this->db, $this->event);
            $authenticated = $ldap->authenticate($username, $password);
            $method = LastLogin::AUTH_LDAP;
        }

        return array($authenticated, $method);
    }

    /**
     * Get the user agent of the connected user
     *
     * @access public
     * @return string
     */
    public function getUserAgent()
    {
        return empty($_SERVER['HTTP_USER_AGENT']) ? t('Unknown') : $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Get the real IP address of the connected user
     *
     * @access public
     * @param  bool    $only_public   Return only public IP address
     * @return string
     */
    public function getIpAddress($only_public = false)
    {
        $keys = array(
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        );

        foreach ($keys as $key) {

            if (isset($_SERVER[$key])) {

                foreach (explode(',', $_SERVER[$key]) as $ip_address) {

                    $ip_address = trim($ip_address);

                    if ($only_public) {

                        // Return only public IP address
                        if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                            return $ip_address;
                        }
                    }
                    else {

                        return $ip_address;
                    }
                }
            }
        }

        return t('Unknown');
    }
}
