<?

class Tic_Tac_Toe
{

    public $array;
    protected $move;


    function create_array($size)
    {
        $this->array = [];
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $this->array[$i][$j] = '';
            }
        }
    }

    function __construct($size, $move = null)
    {
        $this->create_array($size);
        if ($move === null) {
            if (round(rand(1, 1))) {
                $this->move = 'cross';
            } else {
                $this->move = 'circle';
            }
        } else {
            $this->move = $move;
        }
        
    }

    function show()
    {
        echo "\t\n<table>";
        foreach ($this->array as $v) {
            echo "\t\n<tr>";
            foreach ($v as $val) {
                echo "\t<td>$val</td>";
            }
            echo '</tr>';
        }
        echo '</table><hr>';
    }

    function put_cross($i, $j)
    {
        if ($this->in_matrix($i, $j) && $this->is_empty($i, $j) && $this->check_move('cross')) {
            $this->array[$i][$j] = 'X';
            $this->turn_move();
        }
    }

    function put_circle($i, $j)
    {
        if ($this->in_matrix($i, $j) && $this->is_empty($i, $j) && $this->check_move('circle')) {
            $this->array[$i][$j] = 'O';
            $this->turn_move();
        }
    }

    public function is_empty($i, $j)
    {
        return $this->array[$i][$j] == '' ? true : false;
    }

    protected function in_matrix($i, $j)
    {
        $size = count($this->array);
        return ($i >= $size || $j >= $size || $i < 0 || $j < 0) ? false : true;
    }

    function check_move($player)
    {
        if ($player == $this->move) {
            return true;
        } else {
            return false;
        }
    }

    function turn_move()
    {
        if ($this->move == 'cross') {
            $this->move = 'circle';
        } else {
            $this->move = 'cross';
        }
    }

    function transpose($array)
    {
        foreach ($array as $i => $row) {
            foreach ($row as $j => $val) {
                $new_array[$j][$i] = $val;
            }
        }
        return $new_array;
    }

    function check_winner()
    {
        if ($this->check_winner_by_col($this->array) != '') {
            return $this->check_winner_by_col($this->array);
        } else if ($this->check_winner_by_row($this->array) != '') {
            return $this->check_winner_by_row($this->array);
        } else if ($this->check_winner_by_diagonal($this->array) != '') {
            return $this->check_winner_by_diagonal($this->array);
        }
        return '';
    }

    function check_winner_by_col($array)
    {
        return $this->check_winner_by_row($this->transpose($array));
    }

    function check_winner_by_diagonal($array)
    {
        $size = count($array);
        $cross_count = 0;
        $circle_count = 0;
        $cross_count2 = 0;
        $circle_count2 = 0;
        for ($i = 0; $i < $size; $i++) {
            if ($array[$i][$i] == "O") {
                $circle_count++;
            }
            if ($array[$i][$i] == "X") {
                $cross_count++;
            }
            if ($array[$i][$size - $i - 1] == "O") {
                $circle_count2++;
            }
            if ($array[$i][$size - $i - 1] == "X") {
                $cross_count2++;
            }
        }
        if ($circle_count == $size || $circle_count2 == $size) {
            return "O";
        }
        if ($cross_count == $size || $cross_count2 == $size) {
            return "X";
        }
        return '';
    }

    function check_winner_by_row($array)
    {
        $size = count($array);
        foreach ($array as $v) {
            $cross_count = 0;
            $circle_count = 0;
            foreach ($v as $val) {
                if ($val == "X") {
                    $cross_count++;
                }
                if ($val == "O") {
                    $circle_count++;
                }
            }
            if ($cross_count == $size) {
                return "X";
            }
            if ($circle_count == $size) {
                return "O";
            }
        }
        return '';
    }
}


