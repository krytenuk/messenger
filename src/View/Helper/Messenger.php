<?php

namespace FwsMessenger\View\Helper;

use Zend\View\Helper\AbstractHelper;
use FwsMessenger\Controller\Plugin\Messenger as PluginMessenger;
use Zend\View\Helper\TranslatorAwareTrait;
use Zend\View\Helper\EscapeHtml;

/**
 * Messenger
 *
 * @author Garry Childs <info@freedomwebservices.net>
 */
class Messenger extends AbstractHelper
{

    use TranslatorAwareTrait;

    protected $classMessages = [
        'info' => PluginMessenger::NAMESPACE_INFO,
        'error' => PluginMessenger::NAMESPACE_ERROR,
        'success' => PluginMessenger::NAMESPACE_SUCCESS,
        'default' => PluginMessenger::NAMESPACE_DEFAULT,
        'warning' => PluginMessenger::NAMESPACE_WARNING,
    ];

    /**
     * Templates for the open/close/separators for message tags
     *
     * @var string
     */
    protected $messageCloseString = '</li></ul>';
    protected $messageOpenFormat = '<ul%s><li>';
    protected $messageSeparatorString = '</li><li>';

    /**
     * Flag whether to escape messages
     *
     * @var bool
     */
    protected $autoEscape = true;

    /**
     * Html escape helper
     *
     * @var EscapeHtml
     */
    protected $escapeHtmlHelper;

    /**
     * Flash messenger plugin
     *
     * @var PluginMessenger
     */
    protected $pluginMessenger;

    /**
     * Returns the flash messenger plugin controller
     *
     * @param  string|null $namespace
     * @return FlashMessenger|PluginFlashMessenger
     */
    public function __invoke($namespace = null)
    {
        if (null === $namespace) {
            return $this;
        }
        $messenger = $this->getPluginMessenger();

        return $messenger->getMessages($namespace);
    }

    /**
     * Render Messages
     *
     * @param  string    $namespace
     * @param  array     $classes
     * @param  null|bool $autoEscape
     * @return string
     */
    public function render($namespace = 'default', array $classes = [], $autoEscape = null)
    {
        $messengerPlugin = $this->getPluginMessenger();
        $messages = $messengerPlugin->getMessages($namespace);
        return $this->renderMessages($namespace, $messages, $classes, $autoEscape);
    }
    
    /**
     * Render a single message
     * @param string $message
     * @param string $namespace
     * @param array $classes
     * @param string $autoEscape
     * @return string
     */
    public function renderMessage($message, $namespace = 'default', array $classes = [], $autoEscape = null)
    {
        return $this->renderMessages($namespace, [$message], $classes, $autoEscape);
    }

    /**
     * Render Messages
     *
     * @param string    $namespace
     * @param array     $messages
     * @param array     $classes
     * @param bool|null $autoEscape
     * @return string
     */
    protected function renderMessages(
            $namespace = 'default',
            array $messages = [],
            array $classes = [],
            $autoEscape = null
    )
    {
        if (empty($messages)) {
            return '';
        }

        // Prepare classes for opening tag
        if (empty($classes)) {
            if (isset($this->classMessages[$namespace])) {
                $classes = $this->classMessages[$namespace];
            } else {
                $classes = $this->classMessages['default'];
            }
            $classes = [$classes];
        }

        if (null === $autoEscape) {
            $autoEscape = $this->getAutoEscape();
        }

        // Flatten message array
        $escapeHtml = $this->getEscapeHtmlHelper();
        $messagesToPrint = [];
        $translator = $this->getTranslator();
        $translatorTextDomain = $this->getTranslatorTextDomain();
        array_walk_recursive(
                $messages,
                function ($item) use (& $messagesToPrint, $escapeHtml, $autoEscape, $translator, $translatorTextDomain) {
            if ($translator !== null) {
                $item = $translator->translate($item, $translatorTextDomain);
            }

            if ($autoEscape) {
                $messagesToPrint[] = $escapeHtml($item);
                return;
            }

            $messagesToPrint[] = $item;
        }
        );

        if (empty($messagesToPrint)) {
            return '';
        }

        // Generate markup
        $markup = sprintf($this->getMessageOpenFormat(), ' class="' . implode(' ', $classes) . '"');
        $markup .= implode(
                sprintf($this->getMessageSeparatorString(), ' class="' . implode(' ', $classes) . '"'),
                $messagesToPrint
        );
        $markup .= $this->getMessageCloseString();
        return $markup;
    }

    /**
     * Set whether or not auto escaping should be used
     *
     * @param  bool $autoEscape
     * @return Messenger
     */
    public function setAutoEscape($autoEscape = true)
    {
        $this->autoEscape = (bool) $autoEscape;
        return $this;
    }

    /**
     * Return whether auto escaping is enabled or disabled
     *
     * return bool
     */
    public function getAutoEscape(): bool
    {
        return $this->autoEscape;
    }

    /**
     * Set the string used to close message representation
     *
     * @param  string $messageCloseString
     * @return FlashMessenger
     */
    public function setMessageCloseString($messageCloseString)
    {
        $this->messageCloseString = (string) $messageCloseString;
        return $this;
    }

    /**
     * Get the string used to close message representation
     *
     * @return string
     */
    public function getMessageCloseString()
    {
        return $this->messageCloseString;
    }

    /**
     * Set the formatted string used to open message representation
     *
     * @param  string $messageOpenFormat
     * @return FlashMessenger
     */
    public function setMessageOpenFormat($messageOpenFormat)
    {
        $this->messageOpenFormat = (string) $messageOpenFormat;
        return $this;
    }

    /**
     * Get the formatted string used to open message representation
     *
     * @return string
     */
    public function getMessageOpenFormat()
    {
        return $this->messageOpenFormat;
    }

    /**
     * Set the string used to separate messages
     *
     * @param  string $messageSeparatorString
     * @return FlashMessenger
     */
    public function setMessageSeparatorString($messageSeparatorString)
    {
        $this->messageSeparatorString = (string) $messageSeparatorString;
        return $this;
    }

    /**
     * Get the string used to separate messages
     *
     * @return string
     */
    public function getMessageSeparatorString()
    {
        return $this->messageSeparatorString;
    }
    public function getPluginMessenger(): PluginMessenger
    {
        return $this->pluginMessenger;
    }
    
    /**
     * 
     * @param PluginMessenger $pluginMessenger
     * @return $this
     */
    public function setPluginMessenger(PluginMessenger $pluginMessenger)
    {
        $this->pluginMessenger = $pluginMessenger;
        return $this;
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

        if (! $this->escapeHtmlHelper instanceof EscapeHtml) {
            $this->escapeHtmlHelper = new EscapeHtml();
        }

        return $this->escapeHtmlHelper;
    }

}
