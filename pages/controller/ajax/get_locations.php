<?php

class Controller extends System\MainController {

    /**
     *
     * @var model_location_types
     */
    protected $model_location_types = Null;

    /**
     *
     * @var model_locations
     */
    protected $model_locations = Null;

    /**
     *
     * @var model_users 
     */
    protected $model_users = Null;

    public function init() {
        $this->loadModel('location_types');
        $this->loadModel('locations');
        $this->loadModel('users');

        $types = $this->model_location_types->get();
        $locations = $this->model_locations->getCollection();
        $users = $this->model_users->getUsers();

        $output_data = Array();

        if ($this->user && $this->user->logged) {
            $user_filter = $this->user->isAdmin() ? null : $this->user->logged['id'];

            foreach ($locations as $id => $location) {
                if ($user_filter && ($user_filter != $location['user_id'])) {
                    continue;
                }
                if ($location['location_verified']) {
                    $user_link = $this->input->self_url . '/admin/' . (($users[$location['user_id']]['access'][0] == 1) ? 'administrators' : 'users') . '/edit?id=' . $location['user_id'];
                    $output_data[$id] = Array(
                        'id' => $location['id'],
                        'title' => $location['location_title'],
                        'country' => $location['location_country'],
                        'city' => $location['location_city'],
                        'state' => $location['location_state'],
                        'address' => $location['location_address'],
                        'logo' => $location['location_logo'],
                        'geo' => Array(
                            'lat' => $location['location_geo_lat'],
                            'lng' => $location['location_geo_lng'],
                        ),
                        'user' => Array(
                            'id' => $location['user_id'],
                            'email' => $users[$location['user_id']]['email'],
                            'link' => $user_link
                        ),
                        'type' => Array(
                            'id' => $location['location_type'],
                            'title' => $types[$location['location_type']]['title'],
                        )
                    );
                }
            }
        }


        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');

        echo json_encode($output_data);
    }

}
