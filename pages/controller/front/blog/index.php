<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_common
     */
    protected $model_common = Null;

    /**
     *
     * @var model_blog
     */
    protected $model_blog = Null;

    public function init() {
        $this->html->setTitle('Well Fed Foundation | Blog');
        $this->loadModel('common');
        $this->loadModel('blog')
                ->init_front(isset($this->input->get['month'])?$this->input->get['month']:null);
        $this->pageData['collection'] = $this->model_blog->getCollection();
        $this->pageData['users'] = $this->user->getFullList();       
        $this->pageData['sidebar'] = $this->renderWidget('widget/blog_sidebar', array(
            'datelist' => $this->model_blog->getDateList(),
            'users' => $this->pageData['users'],
            'five' => $this->model_blog->getFive(),
        ));
        
        $this->renderPage('front/blog/index');
    }

}
