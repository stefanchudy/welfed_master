<?php

class model_location_types extends \System\Model {

    const TABLE_NAME = 'pickup_locations_types';

    private $location_types = null;

    private $_siteId = 0;

    public function init() {
        return $this;
    }

    public function setSiteId($id) {
        $this->_siteId = $id;
    }

    private function load() {
        return $this->db->getTable(self::TABLE_NAME, '(`site_id` = ' . $this->_siteId . ')', 'id', 'ORDER BY `title`');
    }

    public function get() {
        if ($this->location_types === null) {
            $this->location_types = $this->load();
        }
        return $this->location_types;
    }

    public function get_name($id) {        
        $collection = $this->get();        
        return isset($collection[$id])?$collection[$id]['title']:null;
    }

    public function add($_title, $_description) {
        $insert_array = Array(
            'title' => $this->db->escape($_title),
            'description' => $this->db->escape($_description),
            'site_id' => $this->_siteId
        );
        $insert_query = $this->db->query('INSERT INTO `' . self::TABLE_NAME . '` ' . $this->db->buildQuery($insert_array));
        if ($insert_query->error == 0) {
            $this->location_types = NULL;
        }
        return $insert_query->insert_id;
    }

    public function update($id, $title, $description) {
        $update_array = Array(
            'title' => $this->db->escape($title),
            'description' => $this->db->escape($description)
        );
        $update_query = $this->db->query('UPDATE `' . self::TABLE_NAME . '` ' . $this->db->buildQuery($update_array, TRUE) . ' WHERE `id` = ' . $id);
        if ($update_query->error == 0) {
            $this->location_types = NULL;
        }
        return $update_query;
    }

    public function delete($id) {
        $delete_query = $this->db->query('DELETE FROM `' . self::TABLE_NAME . '` WHERE `id`=' . $id);

        if ($delete_query->error == 0) {
            $this->location_types = NULL;
        }
        return $delete_query;
    }

    public function getAdminHtml() {
        $result = '<div class="list-group item-list">';
        $collection = $this->get();
        If (count($collection)) {
            foreach ($collection as $item) {
                $result .= '<div class="list-group-item">';
                $result .= '<span class="pull-right">';
                $result .= '<div class="item-control">';
                $result .= '<a class="btn btn-success btn-xs btn-type-edit" data-id="' . $item['id'] . '" data-title="' . $item['title'] . '" data-description="' . $item['description'] . '">Edit</a> ';
                $result .= '<a class="btn btn-danger btn-xs btn-type-delete" data-id="' . $item['id'] . '">Delete</a>';
                $result .= '</div>';
                $result .= '</span>';
                $result .= '<strong>' . $item['title'] . '</strong>';
                $result .= '<br>';
                $result .= '<em>' . $item['description'] . '</em>';

                $result .= '</div>';
            }
        } else {
            $result .= '<em>No records in the database</em>';
        }
        $result .= '</div>';

        return $result;
    }

    public function getSelector($id, $selected = 0) {
        $collection = $this->get();
        $result = '<select id="' . $id . '" name="' . $id . '" class="form-control">';
        $result .= '<option value="0"' . (($selected == 0) ? ' selected="selected"' : '') . '>Choose a location type from the list</option>';
        foreach ($collection as $type) {
            $result .= '<option value="' . $type['id'] . '"' . (($type['id'] == $selected) ? ' selected="selected"' : '') . '>' . $type['title'] . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    public function exists($title) {        
        foreach ($this->get() as $value) {
            if ($value['title'] == $title) {
                return $value['id'];
            }
        }
        return NULL;
    }

}
