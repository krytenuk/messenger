<?php

namespace FwsMessanger\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Messanger
 *
 * @author Garry Childs (Freedom Web Services)
 */
class Messanger extends AbstractPlugin
{

    /**
     *
     * @var array
     */
    private $successMessages = array();

    /**
     *
     * @var array
     */
    private $errorMessages = array();

    public function setSuccessMessages(Array $successMessages)
    {
        $this->successMessages = $successMessages;
        return $this;
    }

    public function setErrorMessages(Array $errorMessages)
    {
        $this->errorMessages = $errorMessages;
        return $this;
    }

    public function addSuccessMessage($message)
    {
        if (!is_string($message)) {
            throw new Exception(sprintf('%s expected string, got %s'), __METHOD__, is_object($message) ? get_class($message) : gettype($message));
        }

        $this->successMessages[] = $message;
        return $this;
    }

    public function addErrorMessage($message)
    {
        if (!is_string($message)) {
            throw new Exception(sprintf('%s expected string, got %s'), __METHOD__, is_object($message) ? get_class($message) : gettype($message));
        }

        $this->errorMessages[] = $message;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getSuccessMessages()
    {
        return $this->successMessages;
    }

    /**
     *
     * @return array
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

}
