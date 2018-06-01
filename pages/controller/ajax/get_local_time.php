<?php

class Controller extends System\MainController {

    public function init() {
        date_default_timezone_set('UTC');
        if (isset($this->input->get['lng'], $this->input->get['lat'])) {

            $lat = $this->input->get['lat'];
            $lng = $this->input->get['lng'];

            $timestamp = time();
            $time_formatted = date('Y-m-d H:i:s', $timestamp);

            $shift = $this->getGeoShift($lat, $lng, $timestamp);
            $output_data = Array(
                'result' => 'OK',
                'shift' => $shift,
                'timestamp' => $timestamp + $shift,
                'formatted' => date('Y-m-d H:i:s', $timestamp + $shift),
                'utc' => date('Y-m-d H:i:s', $timestamp),
            );
        } else {
            $output_data = array('result' => 'error');
        }
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        echo json_encode($output_data);
    }

    private function getGeoShift($lat, $lng, $timestamp) {
        $url = 'https://maps.googleapis.com/maps/api/timezone/json';

        $header = array();
        $header[] = 'Accept: application/json';
        $header[] = 'Content-type: application/json';

        $location = $lat . ',' . $lng;
        $params = http_build_query(Array(
            'timestamp' => $timestamp,
            'location' => $location,
        ));

        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, $url . '?' . $params);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($crl, CURLOPT_HEADER, 0);
        curl_setopt($crl, CURLOPT_HTTPGET, true);
        curl_setopt($crl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, 0);
        $rest = curl_exec($crl);

        if ($rest === false) {
            echo json_encode(Array(
                'curl_error' => curl_error($crl)
            ));
            exit;
        }
        curl_close($crl);

        $response = json_decode($rest, TRUE);
        $shift = 0;
        if (isset($response['rawOffset'])) {
            $shift += $response['rawOffset'];
        }
        if (isset($response['dstOffset'])) {
            $shift += $response['dstOffset'];
        }
        return $shift;
    }

}
