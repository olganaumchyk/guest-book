<?php

class DB_entity
{
    
    protected $table_name;
    protected $link;
    protected $page_size = 10;
    protected $default_select = [
        'SELECT' => '*',
        'FROM' => null,
        'WHERE' => 1,
        'GROUP BY' => null,
        'HAVING' => null,
        'ORDER BY' => null,
        'LIMIT' => null
    ];
    protected $current_select = [];
    public $error_list = [];

    function __construct($link, $table_name)
    {
        $this->link = $link;
        $this->table_name = $table_name;
        $this->current_select['FROM'] = $this->table_name;
    }

    function get_sql()
    {
        $sql = '';
        foreach (array_merge($this->default_select, $this->current_select) as $key => $value) {
            if (!empty($value)) {
                $sql .= "$key $value\n";
            }
        }
        return $sql;
    }

    function query()
    {
        $query_result = $this->execute_sql($this->get_sql());

        if ($query_result !== false) {
            return $this->result_query_table($query_result);
        } else {
            return false;
        }
        // return (($query_result = $this->execute_sql($this->get_sql())) !== false) ? $this->result_query_table($query_result) : false;
    }

    protected function execute_sql($sql)
    {
        $query_result = $this->link->query($sql);
        if (!empty($this->link->error)) {
            $this->error_list[] = $this->link->error;
        }
        return $query_result;
    }

    protected function result_query_table($query_result)
    {
        $result = [];
        while ($row = $query_result->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }


    function add_where_condition($add_query)
    {
        $this->current_select['WHERE'] = !empty($this->current_select['WHERE']) ? $this->current_select['WHERE'] . " AND $add_query" : $add_query;
        return $this;
    }

    function reset_where_condition()
    {
        unset($this->current_select['WHERE']);
        return $this;
    }



    function add_order_by_asc($str)
    {
        $this->current_select['ORDER BY'] = !empty($this->current_select['ORDER BY']) ? $this->current_select['ORDER BY'] . ", $str" : $str;
        return $this;
    }

    function add_order_by_desc($str)
    {
        $this->current_select['ORDER BY'] = !empty($this->current_select['ORDER BY']) ? $this->current_select['ORDER BY'] . ", $str DESC" : $str . " DESC";
        return $this;
    }

    function reset_order_by()
    {
        unset($this->current_select['ORDER BY']);
        return $this;
    }

    function reset_select()
    {
        unset($this->current_select['SELECT']);
        return $this;
    }

    function add_select_field($str)
    {
        $this->current_select['SELECT'] = !empty($this->current_select['SELECT']) ? $this->current_select['SELECT'] . ", $str" : $str;
        return $this;
    }

    function set_page($page)
    {
        $this->current_select['LIMIT'] = $page * $this->page_size . ", " . $this->page_size;
        return $this;
    }

    function set_page_size($size)
    {
        $this->page_size = $size;
        return $this;
    }

    function page_count()
    {
        return ceil($this->row_count() / $this->page_size);
    }

    function reset_page()
    {
        unset($this->current_select['LIMIT']);
        return $this;
    }

    function add_group_by($str)
    {
        $this->current_select['GROUP BY'] = !empty($this->current_select['GROUP BY']) ? $this->current_select['GROUP BY'] . ", $str" : $str;
        return $this;
    }

    function reset_group_by()
    {
        unset($this->current_select['GROUP BY']);
        return $this;
    }

    function add_having_condition($add_query)
    {
        $this->current_select['HAVING'] = !empty($this->current_select['HAVING']) ? $this->current_select['HAVING'] . " AND $add_query" : $add_query;
        return $this;
    }

    function reset_having_condition()
    {
        unset($this->current_select['HAVING']);
        return $this;
    }

    function reset_default_select()
    {
        $this->current_select = [];
        $this->current_select['FROM'] = $this->table_name;
        return $this;
    }

    function get_fields()
    {
        return array_column($this->result_query_table($this->execute_sql('SHOW COLUMNS FROM ' . $this->table_name)), 'Field');
    }

    function get_field_comments() {
        $com_nam = $this->result_query_table($this->execute_sql("SELECT COLUMN_COMMENT, COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '$this->table_name'"));
        return array_combine(array_column($com_nam, 'COLUMN_NAME'), array_column($com_nam, 'COLUMN_COMMENT'));
    }

    function delete($id)
    {
        $this->execute_sql("DELETE FROM `$this->table_name` WHERE id = $id");
        return $this->link->affected_rows;
    }

    function add($add_arr)
    {
        // echo "INSERT INTO `$this->table_name`(" . implode(',', array_keys($add_arr)) . ") VALUES ('" . implode("', '", $add_arr) . "')";
        $this->execute_sql("INSERT INTO `$this->table_name`(" . implode(',', array_keys($add_arr)) . ") VALUES ('" . implode("', '", $add_arr) . "')");
        return $this->link->affected_rows;
    }

    function row_count()
    {
        return $this->result_query_table($this->execute_sql("SELECT COUNT(*) AS C FROM $this->table_name"))[0]['C'];
    }

    function clear_table()
    {
        $this->execute_sql("DELETE FROM `$this->table_name`");
        return $this->link->affected_rows;
    }

    function drop_table()
    {
        $this->execute_sql("DROP TABLE `$this->table_name`");
        return $this->link->affected_rows;
    }

    function edit($id, $arr)
    {
        // echo "UPDATE `$this->table_name` SET " . implode(',', array_keys($arr)) . " = " . implode("', '", $arr) . " WHERE id = $id";
        $new_arr = [];
        foreach ($arr as $key => $value) {
            $new_arr[] = "$key='$value'";
        }

        // echo "UPDATE `$this->table_name` SET " . implode(', ', $new_arr) . " WHERE id = $id";
        $this->execute_sql("UPDATE `$this->table_name` SET " . implode(', ', $new_arr) . " WHERE id = $id");
    }

    function array_fields_filter($arr_fields)
    {
        return array_intersect_key($arr_fields, array_flip($this->get_fields()));
    }

    function get_row_by_id($id)
    { 
        $arr = $this->add_where_condition("id=$id")->query()[0];
        unset($arr['id']);
        return $arr;
    }

}
