<?php

namespace Utility;

/**
 * Description of MainUtility
 *
 * @author martin
 */
class MainUtility {

    public function debug($data, $exit = TRUE) {
        echo '<pre>' . print_r($data, TRUE) . '</pre>';
        if ($exit) {
            exit();
        }
    }

    public function redirect($page) {
        $redirect = '/' . $page;
        header("Location: " . $redirect);
    }
    
    function upload_file($field, $fileName = '', $max_size = 4194304) {
        $paths = \Utility\Paths::getInstance();
        $folder = $paths->upload;

        $split = explode(DIRECTORY_SEPARATOR, $fileName);

        $result = Array(
            'success' => FALSE,
            'file' => '',
            'messages' => Array()
        );
        $file_record = FALSE;
        if (is_array($field)) {
            $file_record = $field;
        } else {
            if (isset($_FILES[$field])) {
                $file_record = $_FILES[$field];
            } else {
                $result['messages'][] = 'No upload';
                return $result;
            }
        }

        while (count($split) > 1) {
            if (!file_exists($folder)) {
                mkdir($folder);
            }
            $folder.=$split[0] . DIRECTORY_SEPARATOR;
            unset($split[0]);
            $split = array_values($split);
        }
        if (!file_exists($folder)) {
            mkdir($folder);
        }
        $fileName = $split[0];

        if ($file_record['error'] == 0) {
            $_extension = pathinfo($file_record['name'], PATHINFO_EXTENSION);


            $_fileName = str_replace($_extension, '', $fileName) . '.' . $_extension;
            if ($_fileName == '') {
                $_fileName = $file_record['name'];
            }
            if ($file_record['size'] <= $max_size) {
                if (move_uploaded_file($file_record['tmp_name'], $folder . $_fileName)) {
                    $result['success'] = TRUE;
                    $result['file'] = $_fileName;
                    $result['messages'][] = 'File uploaded sucessfuly.';
                }
            } else {
                $result['messages'][] = 'The maximum allowed size is ' . (int) ($max_size / 1024 / 1024) . ' mb';
            }
        } else {
            $result['messages'][] = 'Error with file upload, err code : ' . $file_record['error'];
        }
        return $result;
    }

}
