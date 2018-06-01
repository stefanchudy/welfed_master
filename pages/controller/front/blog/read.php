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
        $this->html->setTitle('Well Fed Foundation | Read post');
        $this->loadModel('common');

        if ($id = $this->get_hidden['id']) {
            $this->loadModel('blog')
                    ->init_front();

            if ($this->model_blog->publicationExists($id)) {
                
                $blogPost = $this->model_blog->getRecord($id);
                
                $this->html->setSocialTags(array(
                    'image' => $blogPost['image'],
                    'title' => $blogPost['title'],
                    'description' => strip_tags(html_entity_decode($blogPost['content']))
                ));
                
                $this->pageData['postData'] = $blogPost;
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
        $this->renderPage('front/blog/read');
    }

}
