<?php

namespace Utility;

class OrmDataset {

    /**
     *
     * @var \System\DB $db 
     */
    private $db = null;

    /**
     *
     * @var string $_table_name 
     */
    private $_table_name = '';

    /**
     *
     * @var array,null $_collection 
     */
    private $_collection = Null;

    /**
     *
     * @var string $_primary_key
     */
    private $_primary_key = 'id';

    /**
     *
     * @var string $_where 
     */
    private $_where = '';

    /**
     *
     * @var string $_order_by
     */
    private $_order_by = '';

    /**
     *
     * @var boolean $_initialized 
     */
    private $_initialized = FALSE;

    /**
     *
     * @var Array $_fields 
     */
    private $_fields = Array();

    /**
     *
     * @var array $_data 
     */
    private $_data = Array();

    /**
     *
     * @var array $_origData 
     */
    private $_origData = Array();

    /**
     *
     * @var null|int $_currentKey 
     */
    private $_currentKey = NULL;

    /**
     *
     * @var null|int $_insert_id 
     */
    private $_insert_id = NULL;

    /**
     * 
     * @param string $table_name
     * @param type $primary_key if not provided the primary key will be 'id' by default
     */
    public function __construct($table_name) {
        $this->db = \System\DB::getInstance();
        $this->_table_name = $table_name;
    }

    public function _init() {
        if (!$this->_initialized) {
            $query = $this->db->query('SHOW COLUMNS FROM `' . $this->_table_name . '`');

            foreach ($query->rows as $row) {
                if (strtolower($row['Key']) == 'pri') {
                    $this->_primary_key = $row['Field'];
                } else {
                    $this->_fields[] = $row['Field'];
                }
            }
            $this->_initialized = TRUE;
        }
        return $this;
    }

    public function _clear() {
        if ($this->_initialized) {
            $this->_origData = Array();
            $this->_data = Array();
            $this->_currentKey = NULL;
        }
        return $this;
    }

    public function _set_Where($where) {
        if ($this->_initialized) {
            die('This method cannot be called after init');
        }
        $this->_where = $where;
        $this->_records = NULL;
        return $this;
    }

    public function _set_Order_by($order_by) {
        if ($this->_initialized) {
            die('This method cannot be called after init');
        }
        if (!is_array($order_by)) {
            $order_by = [$order_by];
        }

        $order_fields = Array();

        foreach ($order_by as $field) {
            $order_fields[] = $field;
        }
        $this->_order_by = implode(', ', $order_fields);

        $this->_records = NULL;
        return $this;
    }

    public function _getCollection($refresh = False) {
        if (!$this->_initialized) {
            $this->init();
        }
        if ($refresh || ($this->_collection === NULL)) {
            $this->_refreshCollection();
        }
        return $this->_collection;
    }

    public function _load($key) {
        if (!$this->_initialized) {
            $this->init();
        }
        $query = $this->db->query('SELECT * FROM `' . $this->_table_name . '` WHERE `' . $this->_primary_key . '`=' . $key);
        if ($query->num_rows != 0) {
            $result = $query->rows[0];
            $this->_currentKey = $key;
        } else {
            die('no such record');
        }
        $this->_origData = $this->_parseResults($result);
        $this->_data = $this->_parseResults($result);
        return $this;
    }

    public function keyExists($key) {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        $query = $this->db->query('SELECT `' . $this->_primary_key . '` FROM `' . $this->_table_name . '` WHERE `' . $this->_primary_key . '`=' . $key);
        return ($query->num_rows === 1);
    }

    public function columnExists($column) {
        return in_array($column, $this->_fields);
    }

    public function _getCurrentKey() {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        return $this->_currentKey;
    }

    public function _save() {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        $changes = $this->_getChanges();
        if (count($changes)) {
            if ($this->_currentKey === NULL) {
                $query = $this->db->query('INSERT INTO `' . $this->_table_name . '` ' . $this->db->buildQuery($changes));
                if ($query->error === 0) {
                    $this->_origData = $this->_data;
                    $this->_currentKey = $query->insert_id;
                } else {
                    $error_message = json_encode(array(
                        'message' => 'DB error, unable to insert record',
                        'class' => 'ORMDataSet',
                        'method' => '_save',
                        'details' => $query->__toArray()
                    ));
                    die($error_message);
                }
            } else {
                if (count($this->_getChanges()) != 0) {
                    $query = $this->db->query('UPDATE `' . $this->_table_name . '` ' . $this->db->buildQuery($changes, TRUE) . ' WHERE `' . $this->_primary_key . '` = ' . $this->_currentKey);
                    if ($query->error === 0) {
                        $this->_origData = $this->_data;
                    } else {
                        $error_message = json_encode(array(
                            'message' => 'DB error, unable to insert record',
                            'class' => 'ORMDataSet',
                            'method' => '_save',
                            'details' => $query->__toArray()
                        ));
                        die($error_message);
                    }
                }
            }
        }
        return $this;
    }

    public function _delete() {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        if ($this->_currentKey !== NULL) {
            $this->db->query('DELETE FROM `' . $this->_table_name . '` WHERE `' . $this->_primary_key . '` = ' . $this->_currentKey);
            $this->_currentKey = null;
            $this->_origData = Array();
            $this->_data = Array();
        }
        return $this;
    }

    public function _getData($key = NULL) {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        if ($key === NULL) {
            return $this->_data;
        } else {
            if ($this->columnExists($key)) {
                return $this->_data[$key];
            } else {
                die('Wrong field name ' . $key);
            }
        }
    }

    public function _getChanges() {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        $changes = Array();
        if ($this->_currentKey !== NULL) {
            foreach ($this->_origData as $key => $value) {
                if ($this->_data[$key] != $value) {
                    $changes[$key] = $this->_data[$key];
                }
            }
        } else {
            $changes = $this->_data;
        }

        return $changes;
    }

    public function _getOrigData($key = NULL) {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        if ($key === NULL) {
            return $this->_origData;
        } else {
            if ($this->columnExists($key)) {
                return $this->_origData[$key];
            } else {
                die('Wrong field name ' . $key);
            }
        }
    }

    public function _setData($key, $value) {
        if (!$this->_initialized) {
            die('You need to initialize first');
        }
        if (!$this->columnExists($key)) {
            die('Wrong field name ' . $key);
        }
        $this->_data[$key] = $value;
        return $this;
    }

    private function _parseResults($data) {
        if (is_array($data)) {
            $result = Array();
            foreach ($data as $key => $value) {
                $result[$key] = (is_numeric($value) ? $value : htmlspecialchars($value));
            }
            return $result;
        } else {
            return is_numeric($data) ? $data : htmlspecialchars($data);
        }
    }

    private function _refreshCollection() {
        $where = $this->_where ? $this->_where : NULL;

        $order_by = $this->_order_by ? ' ORDER BY ' . $this->_order_by : NULL;

        $this->_collection = $this->db->getTable($this->_table_name, $where, $this->_primary_key, $order_by);
    }

//==============================================================================
    public function debug($data, $exit = TRUE) {
        echo '<pre>' . print_r($data, TRUE) . '</pre>';
        if ($exit) {
            exit();
        }
    }

}
