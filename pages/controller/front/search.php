<?php

/**
 * Description of newPHPClass
 * @return Controller
 * @author martin
 */
class Controller extends System\MainController {

      /**
     *
     * @var model_donations $model_donations
     */
    protected $model_donations = Null;
    
    public function init() {
        if (!$this->user->logged) {
            $this->redirect('');
        }
        date_default_timezone_set('UTC');
        $this->loadModel('donations');
        
        $this->html->addHeaderTag('<script src="https://maps.googleapis.com/maps/api/js?key=' . $this->db_settings->get('google_maps_api', '') . '"></script>');
        $this->html->addHeaderTag('<script type="text/javascript" src="js/DonationSearcher.js"></script>');
        
        $this->pageData['city_list'] = $this->model_donations->getCityList();
        
        
        $this->pageData['allergy'] = str_split($this->user->logged['data']['alergies']);
        $this->pageData['preferences'] = (int)$this->user->logged['data']['preferences'];
        
        $this->html->setTitle($this->short_name . ' | Search');
        $this->renderPage('front/search');
    }

    

}
