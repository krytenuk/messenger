<?php

namespace FwsMessanger\View\Helper;

use Zend\View\Helper\FlashMessenger as ZendFlashMessenger;

/**
 * FlasMessenger
 *
 * @author Garry Childs (Freedom Web Services)
 */
class FlashMessenger extends ZendFlashMessenger
{

    protected $successMessageCloseString = '</li></ul>';
    protected $successMessageOpenFormat = '<ul%s><li>';
    protected $successMessageSeparatorString = '</li><li>';

    protected $errorMessageCloseString = '</li></ul>';
    protected $errorMessageOpenFormat = '<ul%s><li>';
    protected $errorMessageSeparatorString = '</li><li>';


    public function __construct(Array $config)
    {
        if (array_key_exists('flashMessanger', $config)) {
            $flashMessangerConfig = $config['flashMessanger'];
            if (array_key_exists('successMessage', $flashMessangerConfig)) {
                $this->successMessageCloseString = $flashMessangerConfig['successMessage']['closeString'];
                $this->successMessageOpenFormat = $flashMessangerConfig['successMessage']['openFormat'];
                $this->successMessageSeparatorString = $flashMessangerConfig['successMessage']['separatorString'];
            }

            if (array_key_exists('errorMessage', $flashMessangerConfig)) {
                $this->errorMessageCloseString = $flashMessangerConfig['errorMessage']['closeString'];
                $this->errorMessageOpenFormat = $flashMessangerConfig['errorMessage']['openFormat'];
                $this->errorMessageSeparatorString = $flashMessangerConfig['errorMessage']['separatorString'];
            }
        }
    }

    /**
     *
     * @return string
     */
    public function getSuccessMessageCloseString()
    {
        return $this->successMessageCloseString;
    }

    /**
     *
     * @return string
     */
    public function getSuccessMessageOpenFormat()
    {
        return $this->successMessageOpenFormat;
    }

    /**
     *
     * @return string
     */
    public function getSuccessMessageSeparatorString()
    {
        return $this->successMessageSeparatorString;
    }

    /**
     *
     * @param boolean $autoEscape
     * @return string
     */
    public function renderSuccessMessages($autoEscape = null)
    {
        $this->setMessageCloseString($this->successMessageCloseString);
        $this->setMessageOpenFormat($this->successMessageOpenFormat);
        $this->setMessageSeparatorString($this->successMessageSeparatorString);

        return $this->render('success', array(), $autoEscape);
    }

    /**
     *
     * @return string
     */
    public function getErrorMessageCloseString()
    {
        return $this->errorMessageCloseString;
    }

    /**
     *
     * @return string
     */
    public function getErrorMessageOpenFormat()
    {
        return $this->errorMessageOpenFormat;
    }

    /**
     *
     * @return string
     */
    public function getErrorMessageSeparatorString()
    {
        return $this->errorMessageSeparatorString;
    }

    /**
     *
     * @param boolean $autoEscape
     * @return string
     */
    public function renderErrorMessages($autoEscape = null)
    {
        $this->setMessageCloseString($this->errorMessageCloseString);
        $this->setMessageOpenFormat($this->errorMessageOpenFormat);
        $this->setMessageSeparatorString($this->errorMessageSeparatorString);

        return $this->render('error', array(), $autoEscape);
    }

}
