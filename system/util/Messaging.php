<?php

namespace Utility;

/**
 * Description of Messaging
 *
 * @author martin
 */
class Messaging extends \Utility\MainUtility {

    const MESSAGE_TYPE_UNKNOWN = 0;
    const MESSAGE_TYPE_CONTACT_FORM = 1;
    const MESSAGE_TYPE_UPGRADE_APPLICATION = 2;
    const MESSAGE_TYPE_REQUEST_DELIVERY = 3;

    private static $_message_types = Array(
        self::MESSAGE_TYPE_UNKNOWN => 'Unknown',
        self::MESSAGE_TYPE_CONTACT_FORM => 'Contact form',
        self::MESSAGE_TYPE_UPGRADE_APPLICATION => 'Upgrade application',
        self::MESSAGE_TYPE_REQUEST_DELIVERY => 'Request for delivery',
    );
    private static $_instance = null;

    /*
     * 
     * @var \System\Config $config 
     */
    private $_config = null;
    private $_dbSettings = null;
    /*
     * 
     * @var \PHPMailer $_mailer
     */
    private $_mailer = null;

    /**
     *
     * @var \System\DB $db 
     */
    private $db = null;

    /**
     *
     * @var \Utility\OrmDataset $_messages 
     */
    private $_messages = null;

    private function __construct() {
        
    }

    private function _init() {
        $this->_config = \System\Config::getInstance();

        $this->db = \System\DB::getInstance();

        if (isset($this->_config->db['settings_table']) && ($this->_config->db['settings_table'] != '')) {
            $this->_dbSettings = \System\DB_settings::getInstance();
            $this->_dbSettings->init();
        }

        $this->_messages = new \Utility\OrmDataset('contact');
        $this->_messages->_set_Order_by('id');
        $this->_messages->_init();

        $this->_loadMailer();
    }

    public static function __callStatic($name, $arguments) {
        if (self::$_instance === null) {
            self::$_instance = new self;
            self::$_instance->_init();
        }
        $_this = self::$_instance;

        $methodName = '_' . $name;

        if (method_exists($_this, $methodName)) {
            return $_this->$methodName(isset($arguments[0]) ? $arguments[0] : null);
        }
    }

    public static function getMessageType($type_id) {
        return isset(self::$_message_types[$type_id]) ? self::$_message_types[$type_id] : self::$_message_types[self::MESSAGE_TYPE_UNKNOWN];
    }

    public function _getInboxByUser($user_id) {
        
    }

    private function _createMessage($params = Array()) {
        if (isset($params['name'], $params['email'], $params['message'])) {
            $type = self::MESSAGE_TYPE_UNKNOWN;
            if (isset($params['type']) && isset(self::$_message_types[$params['type']])) {
                $type = (int) $params['type'];
            }

            $this->_messages->_clear();
            $this->_messages->_setData('date', '@NOW()');
            $this->_messages->_setData('type', $this->db->escape($type));
            $this->_messages->_setData('name', $this->db->escape($params['name']));
            $this->_messages->_setData('email', $this->db->escape($params['email']));
            $this->_messages->_setData('message', $this->db->escape($params['message']));
            if (isset($params['phone'])) {
                $this->_messages->_setData('phone', $this->db->escape($params['phone']));
            }            
            $this->_messages->_save();

            if ($message_id = $this->_messages->_getCurrentKey()) {
                $this->_sendByMail($message_id);
            }

            return $message_id;
        }
    }

    private function _loadMailer() {

        if (count($this->_config->mailer) != 0) {
            $mailer_config = $this->_config->mailer;
            if (isset($mailer_config['host'], $mailer_config['username'], $mailer_config['password'])) {

                $this->_mailer = new \PHPMailer;

                $this->_mailer->isSMTP();
//
                $this->_mailer->SMTPAuth = isset($mailer_config['SMTPAuth']) ? $mailer_config['SMTPAuth'] : 1;
                $this->_mailer->Host = $mailer_config['host'];
                $this->_mailer->Port = isset($mailer_config['port']) ? $mailer_config['port'] : 587;
                $this->_mailer->Username = $mailer_config['username'];
                $this->_mailer->Password = $mailer_config['password'];
                $this->_mailer->setFrom($mailer_config['username'], $this->_config->main['site_name']);
                $this->_mailer->addReplyTo($mailer_config['username']);
                $this->_mailer->AltBody = isset($mailer_config['altbody']) ? $mailer_config['altbody'] : 'To view the message, please use an HTML compatible email viewer!';
            }
        }
    }

    private function _sendByMail($message_id) {
        if ($this->_dbSettings) {
            $distribution = $this->_dbSettings->get('distribution_list');
            if ($distribution != '') {
                $distribution_list = explode(',', $distribution);

                $message_details = $this->_getMessageContent($message_id);
                $this->_mailer->Subject = $message_details['subject'];
                $this->_mailer->msgHTML($message_details['content']);
                $this->_mailer->ClearAllRecipients();
                foreach ($distribution_list as $value) {
                    $this->_mailer->addAddress($value);
                }
                $this->_mailer->send();
            }
        }
    }

    private function _getMessageContent($message_id) {
        $result = Array(
            'subject' => '',
            'content' => ''
        );
        $this->_messages->_load($message_id);
        $message = $this->_messages->_getData();

        switch ($message['type']) {
            case self::MESSAGE_TYPE_CONTACT_FORM : {
                    $result['subject'] = $this->_config->main['site_name'] . ' Contact form message';
                    $result['content'] = '<div">' .
                            '<h1>' . $this->_config->main['site_name'] . '</h1>' .
                            '<br>' .
                            '<h3 style="font-weight:bold;">New message from the contact form</h3>' .
                            '<br>' .
                            '<strong>Sender name  : </strong>' . $message['name'] . '<br>' .
                            '<strong>Sender email : </strong><a href="' . $message['email'] . '">' . $message['email'] . '</a><br>' .
                            '<strong>Sender phone : </strong>' . $message['phone'] . '<br>' . '<br>' .
                            '<fieldset>' .
                            '<legend>Message text</legend>' .
                            '<pre style="font-size: 14px;">' . $message['message'] . '</pre>' .
                            '</fieldset>' .
                            '</div>';
                    break;
                }
            case self::MESSAGE_TYPE_UPGRADE_APPLICATION : {
                    $result['subject'] = $this->_config->main['site_name'] . ' New upgrade application';
                    $result['content'] = '<div">' .
                            '<h1>' . $this->_config->main['site_name'] . '</h1>' .
                            '<br>' .
                            '<h3 style="font-weight:bold;">New application for account upgrade</h3>' .
                            '<br>' .
                            '<strong>Sender name  : </strong>' . $message['name'] . '<br>' .
                            '<strong>Sender email : </strong><a href="' . $message['email'] . '">' . $message['email'] . '</a><br>' .
                            '<strong>Sender phone : </strong>' . $message['phone'] . '<br>' . '<br>' .
                            'The full application details awaits you in the admin section in the site.' .
                            '</div>';
                    break;
                }
            case self::MESSAGE_TYPE_REQUEST_DELIVERY : {
                $result['subject'] = $this->_config->main['site_name'] . ' New delivery request';
                $result['content'] = htmlspecialchars_decode($message['message']);
                break;
            }
            default : break;
        }
        return $result;
    }

    private function _sendWelcomeMessage($params){        
        $email = $params['email'];
        $message = $params['message'];
        $send_user = clone $this->_mailer;
        $send_user->Subject = 'Well Fed Foundation : Welcome';
        $send_user->msgHTML($message);
        $send_user->clearAllRecipients();
        $send_user->addAddress($email);
        $send_user->send();
    }
}
