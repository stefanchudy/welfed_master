<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_donations
     */
    protected $model_donations = Null;

    public function init() {
        date_default_timezone_set('UTC');
        $result = Array(
            'status' => 0,
            'count' => 0,
            'items' => Array()
        );
        $this->loadModel('donations');
        if (isset($this->input->get['lng'], $this->input->get['lat'])) {
            $allergens = Array();
            $preferences = 0;
            if (isset($this->input->get['allergens']) && (trim($this->input->get['allergens']) != '')) {
                $allergens = explode(',', $this->input->get['allergens']);
            }
            if (isset($this->input->get['preferences'])) {
                $preferences = (int) $this->input->get['preferences'];
            }
            $search = $this->model_donations->searchForDonation((float) $this->input->get['lat'], (float) $this->input->get['lng'], $allergens, $preferences);
            if ($search->error == 0) {
                $result = Array(
                    'status' => 1,
                    'count' => $search->num_rows,
                    'items' => $search->rows
                );
            }
        }
        $result['max_distance'] = $this->db_settings->get('booking_radius', 30);
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        echo json_encode($result);
    }

}
