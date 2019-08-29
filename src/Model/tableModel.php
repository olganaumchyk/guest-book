<?php

class tableModel extends DB_entity {
    
    protected $table_name2;

    function __construct($link, $table_name, $table_name2 = null)
    {
        parent::__construct($link, $table_name);
        $this->table_name2 = $table_name2;
        $this->current_select['FROM'] = ($table_name2 == null) ? $this->table_name : $this->table_name.", ".$this->table_name2;
    }

}

?>