<?php

class model_blog extends System\Model {

    /**
     *
     * @var \Utility\OrmDataset $_donations 
     */
    private $_blog = NULL;
    private $_date_list = NULL;
    private $_siteId = 0;

    public function init() {
        $this->_blog = new Utility\OrmDataset('publications');
    }

    public function setSiteId($id) {
        $this->_siteId = (int) $id;
        return $this;
    }

    public function init_admin() {
        $this->_blog->_set_Where('(`site_id` = ' . $this->_siteId . ') ');        
        $this->_blog->_set_Order_by('`date` DESC');
        $this->_blog->_init();
        return $this;
    }

    public function init_front($filter = null) {
        $this->_blog->_set_Where($this->_getWhere($filter));
        $this->_blog->_init();
    }

    public function init_search($search_string) {
        $search = explode(' ', $search_string);
        $where = '((`active` = 1) AND (`site_id` = ' . $this->_siteId . '))';

        $conditions = array();
        foreach ($search as $value) {
            $conditions[] = '(`title` LIKE "%' . $value . '%") OR (`content` LIKE "%' . $value . '%")';
        }
        $where .= ' AND (' . implode(' OR ', $conditions) . ')';
        $this->_blog->_set_Where($where);
        $this->_blog->_init();
    }

    public function getCollection() {
        return $this->_blog->_getCollection();
    }

    public function getSearchResult($search_string) {
        $_collection = $this->getCollection();
        $collection = array();
        foreach ($_collection as $item) {
            $collection[] = array(
                'date' => $item['date'],
                'title' => $this->_highLignt($search_string, $item['title']),
                'content' => $this->_highLignt($search_string, $item['content']),
                'created_by' => $item['created_by'],
                'url' => $item['url']
            );
        }

        return $collection;
    }

    public function addBlogPost($_title, $_userId = null) {
        $user_id = $_userId ? $_userId : (int) $this->user->logged['id'];
        $title = trim($_title);
        $new_id = $this->_blog->_clear()
        ->_setData('date', '@NOW()')
        ->_setData('title', $title)
        ->_setData('url', '')
        ->_setData('content', '')
        ->_setData('image', '')
        ->_setData('created_by', $user_id)
        ->_setData('site_id', $this->_siteId)
        ->_setData('active', 0)
        ->_save()
        ->_getCurrentKey();

        return $this->_blog->_clear()
                        ->_load($new_id)
                        ->_setData('url', $this->_formCeoURL($new_id, $title))
                        ->_save()
                        ->_getCurrentKey();
    }

    public function getRecord($key) {
        return $this->_blog->_clear()
                        ->_load($key)
                        ->_getData();
    }

    public function setImage($key, $image) {
        $this->_blog->_clear()
                ->_load($key)
                ->_setData('image', $image)
                ->_save();
    }

    public function updateRecord($key, $data) {
        $this->_blog->_clear()
                ->_load($key)
                ->_setData('title', $this->_escape($data['title']))
                ->_setData('url', $this->_formCeoURL($key, $data['title']))
                ->_setData('date', $data['date'])
                ->_setData('content', $this->_escape($data['content']))
                ->_setData('active', (int) $data['active'])
                ->_save();
    }

    public function deleteRecord($key) {
        $this->_blog->_clear()
                ->_load($key)
                ->_delete();
    }

    public function publicationExists($key) {
        return $this->_blog->keyExists($key);
    }

    public function getDateList() {
        if ($this->_date_list === NULL) {
            $this->_date_list = array();
            $query = 'SELECT DATE_FORMAT(`date`,"%Y-%m") AS `short_date`, 
                         DATE_FORMAT(`date`,"%M %Y") AS `long_date`, 
                         COUNT(`date`)               AS `count` 
                    FROM `publications` 
                   WHERE ((`active` = 1) AND (`site_id` = ' . $this->_siteId . '))
                GROUP BY `short_date`,`long_date`
                ORDER BY `short_date` DESC';
            $select = $this->db->query($query);
            foreach ($select->rows as $row) {
                $split = explode('-', $row['short_date']);
                $this->_date_list[$row['short_date']] = Array(
                    'formatted' => $row['long_date'],
                    'count' => $row['count'],
                    'year' => $split[0],
                    'month' => $split[1],
                );
            }
        }
        return $this->_date_list;
    }

    public function getFive() {
        $result = array();
        $query = 'SELECT `title`,`url`,`date`,`created_by`,`image` 
                    FROM `publications` 
                   WHERE ((`active` = 1) AND (`site_id` = ' . $this->_siteId . ')) 
                ORDER BY `date` DESC 
                   LIMIT 5';

        $select = $this->db->query($query);
        foreach ($select->rows as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function getPostByUrl($url) {
        $collection = $this->getCollection();
        foreach ($collection as $entry) {
            if ($entry['url'] == $url) {
                return $entry;
            }
        }
        return null;
    }

    private function _formCeoURL($id, $title) {
        return str_replace(' ', '-', strtolower($title)) . '-' . $id;
    }

    private function _escape($string) {
        return $this->db->escape($string);
    }

    private function _getWhere($filter = null) {
        $result = '((`active` = 1) AND (`site_id` = ' . $this->_siteId . ')) ';

        $date_list = $this->getDateList();
        if (!empty($date_list)) {
            reset($date_list);
            $first_key = key($date_list);

            $month = $date_list[$first_key]['month'];
            $year = $date_list[$first_key]['year'];
        } else {
            $month = date('m');
            $year = date('Y');
        }


        if ($filter) {
            if (isset($date_list[$filter])) {
                $month = $date_list[$filter]['month'];
                $year = $date_list[$filter]['year'];
            }
        }
        $result .= ' AND (MONTH(`date`) = ' . $month . ' AND YEAR(`date`)=' . $year . ') ';

        return $result;
    }

    private function _highLignt($words, $string) {
        $_string = strip_tags($string);
        foreach (explode(' ', $words) as $word) {
            $_string = str_replace($word, '<span class="theme-color highlight">' . $word . '</span>', $_string);
        }
        return $_string;
    }

}
