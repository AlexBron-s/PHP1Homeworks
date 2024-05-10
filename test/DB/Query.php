<?php

namespace DB;

class Query
{
    private $select;
    private $from;
    private $insert;
    private $where;
    private $update;
    private $joins;

    public function __construct()
    {
        $this->select = null;
        $this->from = null;
        $this->insert = null;
        $this->where = null;
        $this->update = null;
        $this->joins = '';
    }

    public function table($table)
    {
        $this->from = $table;
        return $this;
    }
    public function select($fields)
    {
        $this->select = $fields;
        return $this;
    }
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    public function innerJoin($table, $on)
    {
        return $this->join($table, $on, 'INNER');
    }

    public function join($table, $on, $type = '')
    {
        $this->joins = $this->joins.' '.$type.' JOIN '."`$table`".' ON '.$on.' ';
        return $this;
    }

    private function stringWhere()
    {
        $where = '';
        if ($this->where !== null) {
            foreach ($this->where as $key => $value) {
                if ($where === '') {
                    $where = ' WHERE ';
                } else {
                    $where = " AND ";
                }
                $where = "$where $key = '$value'";
            }
        }
        return $where;
    }
    private function stringSelect()
    {
        $select = '';
        if ($this->select !== null) {
            foreach ($this->select as $key => $value) {
                if ($select !== '') {
                    $select = $select.', ';
                }
                if (is_int($key)) {
                    $select = $select."$value";
                } else {
                    $select = "$select$value AS $key";
                }
            }
        } else {
            $select = '*';
        }
        return $select;
    }


    public function insert($insert)
    {
        $fields = null;
        $values = null;
        foreach ($insert as $key => $value) {
            if ($fields === null && $values === null) {
                $fields = "`$key`";
                $values = "'$value'";
            } else {
                $fields = $fields.','."`$key`";
                $values = $values.','."'$value'";
            }
        }

        $this->insert = "($fields) VALUES ($values)";
        return $this;
    }

    public function update($update)
    {
        $fields = null;
        foreach ($update as $key => $value) {
            if ($fields !== null) {
                $fields = "$fields,";
            }
            $fields = "$fields `$key` = '$value'";
        }
        $this->update = $fields;
        return $this;
    }

    public function execute()
    {
        require_once 'MySQL.php';
        if (!$this->from) {
            return false;
        }
        if ($this->insert !== null) {
            return MySQL::insert('INSERT INTO '."`$this->from`".$this->insert.$this->stringWhere());
        } elseif ($this->update) {
            return MySQL::insert('UPDATE '."`$this->from`".' SET '.$this->update.$this->stringWhere());
        } else {
            return MySQL::query('SELECT '.$this->stringSelect().' FROM '."`$this->from`".$this->joins.$this->stringWhere());
        }
    }

    public function delAll()
    {
        require_once 'MySQL.php';
        if ($this->from) {
            return MySQL::del('DELETE FROM '."`$this->from`".$this->stringWhere());
        }
        return false;
    }
}