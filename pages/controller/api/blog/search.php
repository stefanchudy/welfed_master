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

    public function init() {

        $request = $this->model_api->getParams('search_string');

        if ($request) {
            $search_string = base64_decode($request);
            $this->loadModel('blog');
            $this->model_blog
                    ->setSiteId($this->model_api->getSiteId())
                    ->init_search($search_string);

            $response = array(
                'collection' => array(),
                'five' => array(),
                'datelist' => $this->model_blog->getDateList()
            );

            

            $users = $this->user->getFullList();



            $collection = $this->model_blog->getSearchResult($search_string);

            foreach ($collection as $key => $value) {
                $response['collection'][$key] = array(
                    'date' => $value['date'],
                    'title' => $value['title'],
                    'content' => $value['content'],
                    'url' => $value['url'],
                    'author' => array(
                        'id' => $value['created_by'],
                        'name' => (trim($users[$value['created_by']]['screen_name']) ? $users[$value['created_by']]['screen_name'] : 'Administrator')
                    ),
                );
            }
            foreach ($this->model_blog->getFive() as $key => $value) {
                $response['five'][$key] = array(
                    'image' => $value['image'],
                    'url' => $value['url'],
                    'title' => $value['title'],
                    'date' => $value['date'],
                    'author' => array(
                        'id' => $value['created_by'],
                        'name' => (trim($users[$value['created_by']]['screen_name']) ? $users[$value['created_by']]['screen_name'] : 'Administrator')
                    )
                );
            }
        } else {
            $response = 'error';
        }

        $this->model_api->sendResponse($response);
    }

}
