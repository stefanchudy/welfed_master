<?php

namespace Utility;

/**
 * Description of DbResult
 *
 * @author martin
 */

/**
 * @property string $mode Contains the mode of the executed query
 * @property int $time Contains the executuion time of the query
 * @property int $error Contains the error code of the query execution
 * @property string $query Contains the text of the executed query
 * @property int $num_rows Contains the number of rows of the executed query
 * @property array $rows Contains the result of the executed query as $key->$value array
 * @property int $insert_id Contains the ID after insert query execution
 */
class DbQueryResult {

    private $_data = Array();

    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        } else {
            return NULL;
        }
    }

    public function __toArray() {
        return array(
            'mode' => $this->mode,
            'time' => $this->time,
            'error' => $this->error,
            'query' => $this->query,
            'num_rows' => $this->num_rows,
            'insert_id' => $this->insert_id,
            'rows' => $this->rows,
        );
    }

    public function __toJson() {
        return json_encode($this->__toArray());
    }

}
