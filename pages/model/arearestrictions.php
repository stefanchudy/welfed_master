<?php

class model_arearestrictions extends \System\Model {

    /**
     *
     * @var \Utility\OrmDataset $_areas 
     */
    private $_areas = null;
    private $_siteId = 0;

    public function init() {
        $this->_areas = new Utility\OrmDataset('slider');
        return $this;
    }

    public function setSiteId($id) {
        $this->_siteId = $id;
        return $this;
    }

    public function initAdmin() {
        $this->_areas->_set_Where('(`site_id` = ' . $this->_siteId . ')');
        $this->_areas->_init();
        return $this;
    }

    public function initFront() {
        $this->_areas->_set_Where('(`country` <> "") AND (`city` <> "") AND (`site_id` = ' . $this->_siteId . ')');
        $this->_areas->_init();
        return $this;
    }

    public function getCollection() {
        return $this->_areas->_getCollection(true);
    }

    public function getRecord($key) {
        return $this->_areas->_clear()
                        ->_load($key)
                        ->_getData();
    }

    public function recordExists($key) {
        return $this->_areas->keyExists($key);
    }

    public function add() {
        return $this->_areas->_clear()
                        ->_setData('country', '')
                        ->_setData('city', '')
                        ->_setData('site_id', $this->_siteId)
                        ->_save()
                        ->_getCurrentKey();
    }

    public function update($key, $params) {
        if ($this->_areas->keyExists($key)) {
            $this->_areas->_clear()
                    ->_load($key);
            foreach ($params as $column => $value) {
                if ($this->_areas->columnExists($column)) {
                    $this->_areas->_setData($column, $value);
                }
            }
            $this->_areas->_save();
        }
        return $this;
    }

    public function delete($key) {
        if ($this->recordExists($key)) {
            $slide = $this->getRecord($key);
            if ($slide['image'] != '' && file_exists($this->path->www . $slide['image'])) {
                unlink($this->path->www . $slide['image']);
            }
            $this->_areas->_clear()
                    ->_load($key)
                    ->_delete();
        }
        return $this;
    }

    public function setImage($key, $image) {
        $this->_areas->_clear()
                ->_load($key)
                ->_setData('image', $image)
                ->_save();
        return $this;
    }

    public function getJsonList() {
        $collection = $this->getCollection();
        $result = array();
        foreach ($collection as $value) {
            $result[$value['country']][$value['city']] = [];
        }

        return $result;
    }

    public function getSlides() {
        $result = array();

        foreach ($this->getCollection() as $row) {
            if (($row['image'] != '') && $row['city'] != '' && $row['country'] != '') {
                $result[$row['id']] = array(
                    'image' => $row['image'],
                    'sort_order' => $row['sort_order'],
                    'caption' => ($row['caption'] != '') ? $row['caption'] : $row['city'] . ' / ' . $row['country'],
                );
            }
        }

        return $result;
    }

}
