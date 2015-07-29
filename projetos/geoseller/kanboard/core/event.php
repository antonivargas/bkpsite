<?php

namespace Core;

/**
 * Event listener interface
 *
 * @package core
 * @author  Frederic Guillot
 */
interface Listener {

    /**
     * @return boolean
     */
    public function execute(array $data);
}

/**
 * Event dispatcher class
 *
 * @package core
 * @author  Frederic Guillot
 */
class Event
{
    /**
     * Contains all listeners
     *
     * @access private
     * @var array
     */
    private $listeners = array();

    /**
     * The last listener executed
     *
     * @access private
     * @var string
     */
    private $lastListener = '';

    /**
     * The last triggered event
     *
     * @access private
     * @var string
     */
    private $lastEvent = '';

    /**
     * Triggered events list
     *
     * @access private
     * @var array
     */
    private $events = array();

    /**
     * Attach a listener object to an event
     *
     * @access public
     * @param  string   $eventName   Event name
     * @param  Listener $listener    Object that implements the Listener interface
     */
    public function attach($eventName, Listener $listener)
    {
        if (! isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = array();
        }

        $this->listeners[$eventName][] = $listener;
    }

    /**
     * Trigger an event
     *
     * @access public
     * @param  string   $eventName   Event name
     * @param  array    $data        Event data
     */
    public function trigger($eventName, array $data)
    {
        $this->lastEvent = $eventName;
        $this->events[] = $eventName;

        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                if ($listener->execute($data)) {
                    $this->lastListener = get_class($listener);
                }
            }
        }
    }

    /**
     * Get the last listener executed
     *
     * @access public
     * @return string Event name
     */
    public function getLastListenerExecuted()
    {
        return $this->lastListener;
    }

    /**
     * Get the last fired event
     *
     * @access public
     * @return string Event name
     */
    public function getLastTriggeredEvent()
    {
        return $this->lastEvent;
    }

    /**
     * Get a list of triggered events
     *
     * @access public
     * @return array
     */
    public function getTriggeredEvents()
    {
        return $this->events;
    }

    /**
     * Check if a listener bind to an event
     *
     * @access public
     * @param  string $eventName    Event name
     * @param  mixed  $instance     Instance name or object itself
     * @return bool                 Yes or no
     */
    public function hasListener($eventName, $instance)
    {
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                if ($listener instanceof $instance) {
                    return true;
                }
            }
        }

        return false;
    }
}
