<?php

class model_sociallogin extends System\Model {

    private $_providerSetup = null;
    private $_providerName = null;

    public function init() {
        
    }

    public function loadProviderSetup($provider) {
        $this->_providerName = $provider;
        if ($provider_setup = $this->_loadProvider()) {
            $this->_providerSetup = array(
                "base_url" => $this->input->self_url . '/' . $this->input->url,
                "callback" => $this->input->self_url . '/login-success' ,
                'providers' => $this->_loadProvider(),
//                "debug_mode" => true,
//                "debug_file" => "hybrid-login.log",
            );
        } else {
            die('no such provider');
        }


        return $this;
    }

    public function connectProvider() {
        if ($this->_providerSetup['providers'][$this->_providerName]['enabled']) {
            require_once( $this->path->lib . 'hybridauth' . DIRECTORY_SEPARATOR . 'Auth.php' );
            
            //$this->debug($this->_providerSetup);
            try {
                $hybridauth = new Hybrid_Auth($this->_providerSetup);
//                $this->debug($hybridauth->getConnectedProviders());
                $adapter = $hybridauth->authenticate($this->_providerName);
                $adapter->getAccessToken();
                return $adapter->getUserProfile();                                
            } catch (Exception $e) {

                if (isset($_SESSION['HA::CONFIG'])) {
                    unset($_SESSION['HA::CONFIG']);
                }
                if (isset($_SESSION['HA::STORE'])) {
                    unset($_SESSION['HA::STORE']);
                }

                $code = $e->getCode();
                $message = $e->getMessage();
                $this->debug(Array(
                    'code' => $code,
                    'message' => $message
                ));
            }
        } else {
            $this->redirect('');
        }
    }

    public function processEndpoint() {
        require_once( $this->path->lib . 'hybridauth' . DIRECTORY_SEPARATOR . 'Auth.php' );
        require_once( $this->path->lib . 'hybridauth' . DIRECTORY_SEPARATOR . 'Endpoint.php' );

        Hybrid_Endpoint::process();
    }

    private function getCurrentUrl($reload = FALSE) {
        $params = http_build_query($this->input->get);
        if ($reload) {
            $params .= '&reload=1';
        }

        //$result =$this->input->self_url. '/'.$this->input->url.'?'.$params;
        $result = $this->input->url . '?' . $params;

        return $result;
    }

    public function getProviderSetup() {
        return $this->_providerSetup;
    }

    private function _loadProvider() {
        $providers = Array(
            'Facebook' => Array(
                'Facebook' => array(
                    'enabled' => (bool) $this->db_settings->get('soc-login-facebook-enabled', FALSE),
                    'keys' => array(
                        'id' => $this->db_settings->get('soc-login-facebook-client', ''),
                        'secret' => $this->db_settings->get('soc-login-facebook-secret', ''),
                    ),
                    "trustForwarded" => false,
                ),
            ),
            'Twitter' => Array(
                'Twitter' => array(
                    'enabled' => (bool) $this->db_settings->get('soc-login-twitter-enabled', FALSE),
                    'keys' => array(
                        'key' => $this->db_settings->get('soc-login-twitter-client', ''),
                        'secret' => $this->db_settings->get('soc-login-twitter-secret', ''),
                    ),
                    'includeEmail' => TRUE
                ),
            ),
            'Google' => Array(
                'Google' => array(
                    'enabled' => (bool) $this->db_settings->get('soc-login-gplus-enabled', FALSE),
                    'keys' => array(
                        'id' => $this->db_settings->get('soc-login-gplus-client', ''),
                        'secret' => $this->db_settings->get('soc-login-gplus-secret', ''),
                    ),
                ),
            ),
        );
        return isset($providers[$this->_providerName]) ? $providers[$this->_providerName] : NULL;
    }

}
