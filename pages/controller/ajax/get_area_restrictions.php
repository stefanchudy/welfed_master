<?php

Class Controller extends System\MainController {

    /**
     *
     * @var model_arearestrictions
     */
    protected $model_arearestrictions = Null;

    public function init() {
        $this->loadModel('arearestrictions');
        $this->model_arearestrictions->init()
                ->initFront();
        $restrictions = $this->model_arearestrictions->getJsonList();

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        echo json_encode($restrictions);
    }

}
