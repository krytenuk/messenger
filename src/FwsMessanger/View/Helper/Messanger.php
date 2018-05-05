<?php

namespace FwsMessanger\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\I18n\Translator\TranslatorAwareTrait;
use Zend\View\Helper\EscapeHtml;
use FwsMessanger\Controller\Plugin\Messanger as MessangerPlugin;

/**
 * Messanger
 *
 * @author User
 */
class Messanger extends AbstractHelper
{

    use TranslatorAwareTrait;

    /**
     *
     * @var array
     */
    private $config;

    /**
     * Flag whether to escape messages
     *
     * @var bool
     */
    protected $autoEscape = TRUE;

    /**
     * Html escape helper
     *
     * @var EscapeHtml
     */
    private $escapeHtmlHelper;

    /**
     *
     * @var MessangerPlugin
     */
    private $pluginMessangerHelper;

    /**
     * Templates for the open/close/separators for message tags
     *
     * @var string
     */
    protected $messageCloseString = '</li></ul>';
    protected $messageOpenFormat = '<ul><li>';
    protected $messageSeparatorString = '</li><li>';

    public function __construct(MessangerPlugin $messangerPlugin, Array $config)
    {
        $this->pluginMessangerHelper = $messangerPlugin;

        if (array_key_exists('flashMessanger', $config)) {
            $this->config = $config['flashMessanger'];
        }
    }

    /**
     *
     * @param arrayZ|null $messages
     * @param boolean|null $autoEscape
     * @return string|\Admin\Zend\View\Helper\Messanger
     */
    public function __invoke($messages = NULL, $autoEscape = NULL)
    {
        if (is_null($messages)) {
            return $this;
        }

        return $this->render($messages, $autoEscape);
    }

    /**
     *
     * @param boolean|null $autoEscape
     * @return string HTML
     */
    public function renderSuccessMessages($autoEscape = null)
    {
        $this->setSuccessFormat();
        $messages = $this->pluginMessangerHelper->getSuccessMessages();

        return $this->render($messages, $autoEscape);
    }

    /**
     *
     * @param boolean|null $autoEscape
     * @return string HTML
     */
    public function renderErrorMessages($autoEscape = null)
    {
        $this->setErrorFormat();
        $messages = $this->pluginMessangerHelper->getErrorMessages();

        return $this->render($messages, $autoEscape);
    }

    /**
     *
     * @return string
     */
    public function renderMessages()
    {
        $markup = $this->renderErrorMessages()
                . $this->renderSuccessMessages();

        return $markup;
    }

    /**
     *
     * @param string $message
     * @return string HTML
     */
    public function renderSuccessMessage($message) {
        $this->setSuccessFormat();
        return $this->renderMessage($message);
    }

    /**
     *
     * @param string $message
     * @return string HTML
     */
    public function renderErrorMessage($message) {
        $this->setErrorFormat();
        return $this->renderMessage($message);
    }

    /**
     *
     * @param string $message
     * @return string HTML
     */
    public function renderMessage($message) {
        return $this->render((array) $message);
    }

    private function render(Array $messages, $autoEscape = NULL)
    {
        if (empty($messages)) {
            return '';
        }

        if (is_null($autoEscape)) {
            $autoEscape = $this->getAutoEscape();
        }

        $translator = $this->getTranslator();
        $escapeHtml = $this->getEscapeHtmlHelper();
        $messagesToPrint = array();
        foreach ($messages as $message) {
            if (!is_null($translator)) {
                $message = $translator->translate($message);
            }

            if ($autoEscape) {
                $message = $escapeHtml($message);
            }

            $messagesToPrint[] = $message;
        }

        // Generate markup
        $markup = $this->getMessageOpenFormat();
        $markup .= implode(
                $this->getMessageSeparatorString(), $messagesToPrint
        );
        $markup .= $this->getMessageCloseString();
        return $markup;
    }

    private function setErrorFormat()
    {
        if (array_key_exists('errorMessage', $this->config)) {
            $this->setMessageOpenFormat($this->config['errorMessage']['openFormat'])
                    ->setMessageSeparatorString($this->config['errorMessage']['separatorString'])
                    ->setMessageCloseString($this->config['errorMessage']['closeString']);
        }
    }

    private function setSuccessFormat()
    {
        if (array_key_exists('successMessage', $this->config)) {
            $this->setMessageOpenFormat($this->config['successMessage']['openFormat'])
                    ->setMessageSeparatorString($this->config['successMessage']['separatorString'])
                    ->setMessageCloseString($this->config['successMessage']['closeString']);
        }
    }

    /**
     * Retrieve the escapeHtml helper
     *
     * @return EscapeHtml
     */
    protected function getEscapeHtmlHelper()
    {
        if ($this->escapeHtmlHelper) {
            return $this->escapeHtmlHelper;
        }

        if (method_exists($this->getView(), 'plugin')) {
            $this->escapeHtmlHelper = $this->view->plugin('escapehtml');
        }

        if (!$this->escapeHtmlHelper instanceof EscapeHtml) {
            $this->escapeHtmlHelper = new EscapeHtml();
        }

        return $this->escapeHtmlHelper;
    }

    /**
     *
     * @return string
     */
    public function getMessageCloseString()
    {
        return $this->messageCloseString;
    }

    /**
     *
     * @return string
     */
    public function getMessageOpenFormat()
    {
        return $this->messageOpenFormat;
    }

    /**
     *
     * @return string
     */
    public function getMessageSeparatorString()
    {
        return $this->messageSeparatorString;
    }

    /**
     *
     * @param string $messageCloseString
     * @return \Admin\Zend\View\Helper\Messanger
     */
    public function setMessageCloseString($messageCloseString)
    {
        $this->messageCloseString = $messageCloseString;
        return $this;
    }

    /**
     *
     * @param string $messageOpenFormat
     * @return \Admin\Zend\View\Helper\Messanger
     */
    public function setMessageOpenFormat($messageOpenFormat)
    {
        $this->messageOpenFormat = $messageOpenFormat;
        return $this;
    }

    /**
     *
     * @param string $messageSeparatorString
     * @return \Admin\Zend\View\Helper\Messanger
     */
    public function setMessageSeparatorString($messageSeparatorString)
    {
        $this->messageSeparatorString = $messageSeparatorString;
        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function getAutoEscape()
    {
        return $this->autoEscape;
    }

    public function setAutoEscape($autoEscape = TRUE)
    {
        $this->autoEscape = (bool) $autoEscape;
        return $this;
    }

}
