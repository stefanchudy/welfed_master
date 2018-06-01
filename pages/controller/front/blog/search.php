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
        $this->html->setTitle('Well Fed Foundation | Blog | Search');
        $this->loadModel('common');
        if (isset($this->input->get['search_string'])) {
            $search_string = $this->input->get['search_string'];
            if (!empty($search_string)) {
                $this->loadModel('blog')
                        ->init_search($search_string);
                $this->pageData['collection'] = $this->model_blog->getSearchResult($search_string);
                $this->pageData['users'] = $this->user->getFullList();
                $this->pageData['sidebar'] = $this->renderWidget('widget/blog_sidebar', array(
                    'datelist' => $this->model_blog->getDateList(),
                    'users' => $this->pageData['users'],
                    'five' => $this->model_blog->getFive(),
                ));
            } else {
                $this->redirect('blog');
            }
        } else {
            $this->redirect('blog');
        }
        $this->renderPage('front/blog/search');
    }

}
