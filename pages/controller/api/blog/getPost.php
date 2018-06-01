<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     * 
     * @var model_api $model_api
     */
    protected $model_api = null;

    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;
    private $_userList = null;

    public function init() {

        $this->_userList = $this->user->getFullList();

        $url = $this->model_api->getParams('id');

        $this->loadModel('blog')
                ->setSiteId($this->model_api->getSiteId())
                ->init_front();

        if ($blog = $this->model_blog->getPostByUrl($url)) {
            $response = array();
            
            $response['post'] = array(
                'id' => $blog['id'],
                'date' => $blog['date'],
                'image' => $blog['image'],
                'url' => $blog['url'],
                'title' => $blog['title'],
                'content' => $blog['content'],
                'active' => $blog['active'],
                'created_by' => array(
                    'id' => $blog['created_by'],
                    'name' => $this->_getUserName($blog['created_by'])
                ),
            );

            foreach ($this->model_blog->getFive() as $key => $value) {
                $response['five'][$key] = array(
                    'image' => $value['image'],
                    'url' => $value['url'],
                    'title' => $value['title'],
                    'date' => $value['date'],
                    'author' => array(
                        'id' => $value['created_by'],
                        'name' => $this->_getUserName($value['created_by'])
                    )
                );
            }

            $response['datelist'] = $this->model_blog->getDateList();
        } else {
            $response = null;
        }



        $this->model_api->sendResponse($response);
    }

    private function _getUserName($id) {
        $user_name = 'Administrator';

        if (isset($this->_userList[$id])) {
            $user = $this->_userList[$id];
            $user_name = (trim($user['screen_name']) ? $user['screen_name'] : 'Administrator');
        }
        return $user_name;
    }

}
