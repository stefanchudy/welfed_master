<?php

/**
 * Description of DB
 * @return /system/DB/
 * @author martin
 */

namespace System;

class DB extends \Utility\MainUtility {

    private static $instance = null;
    private $database = null;
    private $db_name = null;
    private $totalTime = 0;
    private $queries = 0;
    public $connected = false;

    private function __construct() {
        
    }

    /**
     * @return $db /System/DB
     */
    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function connect($host, $user, $pass, $database) {
        $this->database = mysqli_connect($host, $user, $pass, $database);
        if ($this->database) {
            mysqli_set_charset($this->database, 'utf8');
            $this->connected = TRUE;
            $this->db_name = $database;
        }
    }

    /**
     * Executes a query on the database
     * 
     * @param string $query
     * @return \Utility\DbQueryResult
     */
    public function query($query) {
        $return = FALSE;
        $mode = 'other';
        if (strpos($query, 'SELECT') !== FALSE) {
            $mode = 'select';
        }
        if (strpos($query, 'INSERT') !== FALSE) {
            $mode = 'insert';
        }
        if (strpos($query, 'UPDATE') !== FALSE) {
            $mode = 'update';
        }
        if (strpos($query, 'DELETE') !== FALSE) {
            $mode = 'delete';
        }
        if (strpos($query, 'SHOW') !== FALSE) {
            $mode = 'show';
        }

        $startTime = microtime(TRUE);
        $table = mysqli_query($this->database, $query);
        $execTime = (microtime(TRUE) - $startTime);

        $this->totalTime+=$execTime;

        $this->queries++;
        $return = new \Utility\DbQueryResult();        
        
        $return->mode = $mode;
        $return->time = $execTime;
        $return->error = mysqli_errno($this->database);
        $return->query = $query;

        if ($mode == 'select' || $mode == 'show') {
            $result = Array();
            if ($table->num_rows != 0) {
                while ($row = mysqli_fetch_assoc($table)) {
                    $result[] = $row;
                }
            }
            $return->num_rows = count($result);
            $return->rows = $result;
        }
        if ($mode == 'insert') {
            $return->insert_id = mysqli_insert_id($this->database);
        }
        return $return;
    }

    public function escape($string) {
        return mysqli_real_escape_string($this->database, $string);
    }

    public function getDbStatus() {
        return $this->database;
    }

    public function getTime() {
        return Array(
            'db_time' => $this->totalTime,
            'db_executions' => $this->queries
        );
    }

    public function getTable($table_name, $where = NULL, $primary_key = 'id', $suffix = '') {
        if (!$this->connected) {
            die('You must connect to a database first');
        }
        $result = Array();
        $query = $this->query('SELECT * FROM `' . $table_name . '`' . (($where !== NULL) ? ' WHERE ' . $where : '') . ' ' . $suffix);

        foreach ($query->rows as $row) {
            $result[$row[$primary_key]] = $row;
        }        
        return $result;
    }

    public function getRecordCount($table_name, $where = '') {
        return $this->query('SELECT COUNT(*) AS `count` FROM `' . $table_name . '`' . (($where != '') ? ' WHERE ' . $where : ''))->rows[0]['count'];
    }

    public function buildQuery($array, $update = FALSE) {
        $fields = Array();
        if (!$update) {
            $values = Array();
            foreach ($array as $key => $value) {
                $fields[] = '`' . $key . '`';
                if (!is_numeric($value)) {
                    if (substr($value, 0, 1) != '@') {
                        $values[] = '"' . $value . '"';
                    } else {
                        $values[] = substr($value, 1);
                    }
                } else {
                    $values[] = $value;
                }
            }
            return '(' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
        } else {
            $result = 'SET ';
            foreach ($array as $key => $value) {
                $temp = '`' . $key . '`';
                if (!is_numeric($value)) {

                    if (substr($value, 0, 1) != '@') {
                        $temp.='="' . $value . '"';
                    } else {
                        $temp.='=' . substr($value, 1);
                    }
                } else {
                    $temp.='=' . $value;
                }
                $fields[] = $temp;
            }
            $result.= implode(', ', $fields);
            return $result;
        }
    }

    public function getStructure() {
        if (!$this->connected) {
            die('You must connect to a database first');
        }
    }

}
