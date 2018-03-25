<?php

namespace tm\database;

/**
 * class for creating new table in database
 */
class Table
{
    private $cols = [];
    private $fkeys = [];

    private $name;
    private $engine = 'InnoDB';
    
    public function __construct($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * add new column to collection
     * @param string name - column name
     * @param string type - column type
     * @param string format
     * @param bool notNull - can by value as null or not. Default value is false
     * @param bool pk -primary key, default value = false
     * @param bool autoincrement
     *
     * @return object
     */
    public function addColumn(string $name, string $type, string $format, bool $notNull = false, bool $pk = false, bool $autoincrement = false)
    {
        if (array_key_exists(trim($name), $this->cols)) {
            return $this;
        }
 
        $col = [
             'pk' => $pk,
             'type' => $type,
             'format' => $format,
             'notNull' => $notNull,
             'ai' => $autoincrement
         ];
 
        $this->cols[$name] = $col;
 
        return $this;
    }

    public function addForeignKey(string $own_key, string $f_table, string $f_key, string $onDel = 'RESTRICT', string $onUpd = 'RESTRICT')
    {
        if (!array_key_exists(trim($own_key), $this->cols)) {
            return $this;
        }
        if (array_key_exists(trim($own_key), $this->fkeys)) {
            return $this;
        }
        
        $this->fkeys[$own_key] = [
            'table' => $f_table,
            'f_key' => $f_key,
            'onDelete' => $onDel,
            'onUpdate' => $onUpd
        ];

        return $this;
    }

    public function buildSQL()
    {
        $col_text = $this->createColumnesText();
        $fk_text = $this->createTextForeignKeys();
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->name . " (" . $col_text . $fk_text .") engine=" . $this->engine;

        return $sql;
    }

    private function createColumnesText()
    {
        $strings = [];
        foreach ($this->cols as $name => $params) {
            $ai = ($params['ai'] === true) ? ' AUTOINCREMENT ' : ' ';
            $pk = ($params['pk'] === true) ? ' PRIMARY KEY ' : ' ';
            $notNull = ($params['notNull'] === true) ? ' NOT NULL ' : ' ';
            $strings[] = $name . ' ' . $params['type'] . ' (' . $params['format'] . ') ' . $notNull . $pk . $ai;
        }

        return \implode(",", $strings);
    }

    private function createTextForeignKeys()
    {
        if (empty($this->fkeys)) {
            return "";
        }
        
        $strings = [];

        foreach ($this->fkeys as $key => $params) {
            $strings[] = " FOREIGN KEY fk_" . $key . '(' . $key . ') REFERENCES '  . $params['table']
                . '(' . $params['f_key'] . ') ON DELETE ' . $params['onDelete']  . ' ON UPDATE ' .$params['onUpdate'];
        }

        return ',' . \implode(",", $strings);
    }
}
