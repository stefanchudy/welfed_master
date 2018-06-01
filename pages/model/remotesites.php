<?php

class model_remotesites extends \System\Model {

    /**
     *
     * @var \Utility\OrmDataset $remoteSites
     */
    private $remoteSites = null;
    private $_salt = 'We1lfED';
    private $_pepper = 'f0uND@t1oN';

    public function init() {
        $this->remoteSites = new Utility\OrmDataset('remote_sites');
        $this->remoteSites->_init();
    }

    public function getCollection() {
        $remote_sites = $this->remoteSites->_getCollection(TRUE);

        foreach ($remote_sites as $k => $v) {
            $remote_sites[$k]['filter'] = base64_encode(
                json_encode(
                        array(
                            'ip' => $v['ip'],
                            'token' => $v['token'],
                            'name' => $v['name'] ? $v['name'] : 'Invalid token',
                        )
                ) 
            );
        }

        return $remote_sites;
    }

    public function add($post) {
        $token = sha1($this->_salt . $post['ip'] . $this->_pepper);
        return $this->remoteSites->_clear()
                        ->_setData('ip', $post['ip'])
                        ->_setData('name', $post['name'])
                        ->_setData('admin_mail', $post['admin_mail'])
                        ->_setData('token', $token)
                        ->_save()
                        ->_getCurrentKey();
    }

    public function update($id, $post) {
        return $this->remoteSites->_clear()
                        ->_load($id)
                        ->_setData('name', $post['name'])
                        ->_setData('admin_mail', $post['admin_mail'])
                        ->_save();
    }

    public function load($key) {
        if ($this->remoteSites->keyExists($key)) {
            return $this->remoteSites->_load($key)
                            ->_getData();
        } else {
            return NULL;
        }
    }

    public function delete($key) {
        $this->remoteSites->_load($key)
                ->_delete();
    }

}
