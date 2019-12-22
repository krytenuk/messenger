<?php

namespace FwsMessanger\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Countable;
use IteratorAggregate;
use Traversable;
use ArrayIterator;

/**
 * Messenger
 *
 * @author Garry Childs <info@freedomwebservices.net>
 */
class Messenger extends AbstractPlugin implements IteratorAggregate, Countable
{

    /**
     * Default messages namespace
     */
    const NAMESPACE_DEFAULT = 'default';

    /**
     * Success messages namespace
     */
    const NAMESPACE_SUCCESS = 'success';

    /**
     * Warning messages namespace
     */
    const NAMESPACE_WARNING = 'warning';

    /**
     * Error messages namespace
     */
    const NAMESPACE_ERROR = 'error';

    /**
     * Info messages namespace
     */
    const NAMESPACE_INFO = 'info';

    /**
     * Messages
     * @var array
     */
    protected $messages = [];

    /**
     * Instance namespace, default is 'default'
     *
     * @var string
     */
    protected $namespace = self::NAMESPACE_DEFAULT;

    /**
     * 
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * 
     * @param string $namespace
     * @return Messenger
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Add a message
     *
     * @param  string         $message
     * @param  null|string    $namespace
     * @return Messenger Provides a fluent interface
     */
    public function addMessage($message, $namespace = null)
    {
        if (null === $namespace) {
            $namespace = $this->getNamespace();
        }

        $this->messages[$namespace][] = $message;

        return $this;
    }

    /**
     * Add a message with "info" type
     *
     * @param  string         $message
     * @return Messenger
     */
    public function addInfoMessage($message)
    {
        $this->addMessage($message, self::NAMESPACE_INFO);
        return $this;
    }

    /**
     * Add a message with "success" type
     *
     * @param  string         $message
     * @return Messenger
     */
    public function addSuccessMessage($message)
    {
        $this->addMessage($message, self::NAMESPACE_SUCCESS);
        return $this;
    }

    /**
     * Add a message with "warning" type
     *
     * @param string        $message
     * @return Messenger
     */
    public function addWarningMessage($message)
    {
        $this->addMessage($message, self::NAMESPACE_WARNING);
        return $this;
    }

    /**
     * Add a message with "error" type
     *
     * @param  string         $message
     * @return Messenger
     */
    public function addErrorMessage($message)
    {
        $this->addMessage($message, self::NAMESPACE_ERROR);
        return $this;
    }

    /**
     * 
     * @param string $namespace
     * @return bool
     */
    public function hasMessages($namespace = null): bool
    {
        if (null === $namespace) {
            $namespace = $this->getNamespace();
        }

        return isset($this->messages[$namespace]);
    }

    /**
     * 
     * @return array
     */
    public function getMessages($namespace = null): array
    {
        if (null === $namespace) {
            $namespace = $this->getNamespace();
        }

        if ($this->hasMessages($namespace)) {
            return $this->messages[$namespace];
        }

        return [];
    }

    /**
     * Get messages from "info" namespace
     *
     * @return array
     */
    public function getInfoMessages()
    {
        return $this->getMessages(self::NAMESPACE_INFO);
    }

    /**
     * Get messages from "success" namespace
     *
     * @return array
     */
    public function getSuccessMessages()
    {
        return $this->getMessages(self::NAMESPACE_SUCCESS);
    }

    /**
     * Get messages from "warning" namespace
     *
     * @return array
     */
    public function getWarningMessages()
    {
        return $this->getMessages(self::NAMESPACE_WARNING);
    }

    /**
     * Get messages from "error" namespace
     *
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->getMessages(self::NAMESPACE_ERROR);
    }

    /**
     * 
     * @return int
     */
    public function count(): int
    {
        if ($this->hasMessages()) {
            return count($this->getMessages());
        }

        return 0;
    }

    /**
     * 
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        if ($this->hasMessages()) {
            return new ArrayIterator($this->getMessages());
        }

        return new ArrayIterator();
    }

}
