<?php

namespace System;

/**
 * Description of Html
 * @var \System\Html
 * @author martin
 */
class Html extends \Utility\MainUtility {

    private $config = null;
    private $db_settings = null;
    private $title = '';
    private $headerTags = null;
    private $path = null;
    private $language = null;
    private $user = false;
    public $loadHeader = true;
    public $loadFooter = true;
    private $body_params = Array();
    protected $errors = Array();
    protected $social = null;

    function setUser($user) {
        $this->user = $user;
    }

    public function setCommonPath($path) {
        $this->path->setCommonPath($path);
    }

    public function __construct() {
        $this->path = \Utility\Paths::getInstance();
        $this->config = \System\Config::getInstance();
        $this->headerTags = $this->config->header;
        $this->language = \System\Language::getInstance();
        $this->language->init();
        $this->input = \System\PageInput::getInstance();
        $this->db_settings = \System\DB_settings::getInstance();
        if (count($this->config->social)) {
            $this->setSocialTags($this->config->social);
        }
    }

    private function createHeader() {
        $result = '';
        $result .= '<!DOCTYPE html>' . PHP_EOL;
        $result .= '<html>' . PHP_EOL;
        $result .= '<head>' . PHP_EOL;
        $result .= '<title>' . $this->title . '</title>' . PHP_EOL;
        $result .= implode(PHP_EOL, $this->headerTags) . PHP_EOL;
        if (count($this->config->social)) {
            $result .= implode(PHP_EOL, $this->addSocialTags()) . PHP_EOL;
        }
        $result .= '</head>' . PHP_EOL;
        $result .= '<body ' . $this->getBodyParams() . '>' . PHP_EOL;


        return $result;
    }

    public function setBodyParams($params) {
        $this->body_params = $params;
    }

    private function getBodyParams() {
        $result = Array();
        foreach ($this->body_params as $key => $value) {
            $result[] = $key . '="' . $value . '"';
        }
        return implode(' ', $result);
    }

    public function addHeaderTag($tag) {
        $this->headerTags[] = $tag;
    }

    public function setSocialTags($tags) {
        $this->social = $tags;
    }

    public function disableHeaderTag($tag) {
        if (in_array($tag, $this->headerTags)) {
            unset($this->headerTags[array_search($tag, $this->headerTags)]);
        }
    }

    public function setHeaderTags($params) {
        $this->headerTags = $params;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function render($pageData = Array(), $template = '', $widget = FALSE) {
        $page = '';
        $user = $this->user;
        $pageData['user'] = $user;

        if (!$widget) {
            $page .= $this->createHeader();
            if ($this->loadHeader && file_exists($this->path->commonView . 'header.php')) {
                $page .= $this->loader($this->path->commonView . 'header.php', $pageData);
            }
            if (count(\System\Alerts::getErrors())) {
                foreach (\System\Alerts::getErrors() as $key => $error) {
                    if (is_integer($key)) {
                        $page .= $this->showAlert($error, 'E');
                    }
                }
            }
            if (count(\System\Alerts::getNotifications())) {
                foreach (\System\Alerts::getNotifications() as $key => $notify) {
                    if (is_integer($key)) {
                        $page .= $this->showAlert($notify, 'N');
                    }
                }
            }
            if (count(\System\Alerts::getSuccess())) {
                foreach (\System\Alerts::getSuccess() as $key => $success) {
                    if (is_integer($key)) {
                        $page .= $this->showAlert($success, 'S');
                    }
                }
            }
        }
        if (file_exists($this->path->views . $template . '.php')) {
            $page .= $this->loader($this->path->views . $template . '.php', $pageData);
        }

        if (!$widget) {
            if ($this->loadFooter && file_exists($this->path->commonView . 'footer.php')) {
                $page .= $this->loader($this->path->commonView . 'footer.php', $pageData);
            }
            $page .= '</body>';
            $page .= '</html>';
        }
        if (isset($this->input->get['highlight'])) {
            $page = $this->highlight($page, $this->input->get['highlight']);
        }
        if (!$widget) {
            echo $page;
        } else {
            return $page;
        }
    }

    private function loader($file, $data = Array()) {
        extract($data);
        ob_start();
        require($file);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    private function addSocialTags() {
        $result = Array();
        $self_url = $this->input->self_url . '/';

        $image = ((isset($this->social['image']) && $this->social['image']) ? $self_url . $this->social['image'] : '');        
        $title = ((isset($this->social['title']) && $this->social['title'])?$this->social['title']:'');
        $description = ((isset($this->social['description']) && $this->social['description'])?$this->social['description']:'');

        //Social links
        $result[] = '<meta itemprop = "image" content = "' . $image . '" />';
        $result[] = '<meta itemprop = "name" content = "' . $title . '" />';
        $result[] = '<meta itemprop = "description" content = "' . $description . '"/>';
        // Facebook
        $result[] = '<meta property = "og:url" content = "' . $self_url.$this->input->url . '" />';
        $result[] = '<meta property = "og:title" content = "' . $title . '" />';
        $result[] = '<meta property = "og:type" content = "website" />';
        $result[] = '<meta property = "og:site_name" content = "' . $title . '" />';
        $result[] = '<meta property = "og:description" content = "' . $description . '" />';
        $result[] = '<meta property = "og:image" content = "' . $image . '" />';
        // Twitter
        if (isset($this->social['twitter']) && ($this->social['twitter'] != '')) {
            $result[] = '<meta property="twitter:card" content="summary_large_image">';
            $result[] = '<meta property="twitter:site" content="' . $this->social['twitter'] . '">';
            $result[] = '<meta property="twitter:title" content = "' . $title . '" />';
            $result[] = '<meta property="twitter:description" content = "' . $description . '" />';
            $result[] = '<meta property="twitter:image" content = "' . $image . '" />';
        }

        return $result;
    }

    public function setErrors($errors) {
        $this->errors = $errors;
    }

    //common methods to be used in the pages    
    /**
     * 
     * @param string $page
     * @param string $highlight
     * @return string
     */
    private function highlight($page, $highlight) {
        $found_1 = Array();
        $offset = 0;

        while (mb_stripos($page, $highlight, $offset) !== FALSE) {
            $pos = mb_stripos($page, $highlight, $offset);
            $found_1[] = $pos;
            $offset = $pos + mb_strlen($highlight) - 1;
        }
        $found = Array();
        $sub = Array();
        foreach ($found_1 as $value) {
            $first = mb_strpos($page, '<', $value);
            $secound = mb_strpos($page, '>', $value);

            if ($first <= $secound) {
                $found[] = $value;
                $sub[] = mb_substr($page, $value - 5, mb_strlen($highlight) + 5);
            }
        }

        $shift = 0;
        foreach ($found as $value) {
            $page = mb_substr($page, 0, $value + $shift)
                    . '<span class="highlight">'
                    . mb_substr($page, $value + $shift, mb_strlen($highlight))
                    . '</span>'
                    . mb_substr($page, $value + $shift + mb_strlen($highlight));
            $shift += 31;
        }
        return $page;
    }

    public function cutString($string, $length) {
        $_string = explode(' ', $string);
        while (mb_strlen(implode(' ', $_string)) > $length) {
            unset($_string[count($_string) - 1]);
        }
        if (mb_strlen($string) > mb_strlen(implode(' ', $_string))) {
            return implode(' ', $_string) . ' ...';
        } else {
            return $string;
        }
    }

    public function formDate($date, $month_style = 0, $order = '') {
        //$month_style values : 0 = full name,1=short name,2=numeric
        $result = '';
        if ($this->language->get('_dates') != '$_dates') {
            $format = $this->language->get('_dates');
            if ($order != '') {
                $format['order'] = $order;
            }
            $day = date_format(date_create($date), 'd');
            $month = date_format(date_create($date), 'm');
            $year = date_format(date_create($date), 'Y');


            for ($i = 0; $i < (strlen($format['order'])); $i++) {
                switch ($format['order'][$i]) {
                    case 'D' : {
                            $result .= $day;
                            break;
                        }
                    case 'M' : {
                            switch ($month_style) {
                                case 0 : {
                                        $result .= $format['months_names'][(int) $month];
                                        break;
                                    }
                                case 1 : {
                                        $result .= $format['months_short'][(int) $month];
                                        break;
                                    }
                                case 2 : {
                                        $result .= $month;
                                        break;
                                    }
                                default : {
                                        $result .= $format['months_names'][(int) $month];
                                        break;
                                    }
                            }

                            break;
                        }
                    case 'Y' : {
                            $result .= $year;
                            break;
                        }
                    default : {
                            $result .= $format['order'][$i];
                            break;
                        }
                }
            }
        } else {
            $result = date_format(date_create($date), 'd F Y');
        }
        return $result;
    }

    public function showAlert($message, $type = 'E') {
        $result = '';
        $class = Array(
            'E' => 'alert-danger',
            'N' => 'alert-info',
            'S' => 'alert-success'
        );
        $text = Array(
            'E' => 'Error! ',
            'N' => 'Notification : ',
            'S' => 'Success! '
        );

        $result .= '<div class="alert ' . $class[$type] . '">';
        $result .= '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        $result .= '<strong>' . $text[$type] . ' </strong>';
        $result .= $message;
        $result .= '</div>';
        return $result;
    }

    public function format_number($number, $decimals = 2) {
        $result = number_format($number, $decimals, '.', ' ');

        if ($number < 0) {
            $result = '<span style="color:red">' . $result . '</span>';
        }
        return $result;
    }

    public function showErrors($field) {
        $result = '';
        if (!empty($this->errors[$field])) {
            if(!is_array($this->errors[$field])){
                $this->errors[$field] = [$this->errors[$field]];
            }            
            foreach ($this->errors[$field] as $error) {
                $result .= $this->showAlert($error);
            }
        }
        return $result;
    }

}
