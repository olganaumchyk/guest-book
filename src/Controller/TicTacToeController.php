<?php

class TicTacToeController extends Controller {
    public $field_size = 3;
    
    function __construct($view) {
        parent::__construct($view);
        $this->game = new AI($this->field_size, 'cross');
        $this->game->load_data_from_session();
    }

    function __destruct()
    {
        $this->game->save_data_to_session();
    }

    function actionShowField () {

        print_r ($_SESSION);
        $this->render("showField", [
            'field' => $this->game->array,
            'targetURL' => '?t='.$this->classNameNP().'&a=move',
            'targetNewGame' => '?t='.$this->classNameNP().'&a=newGame',
            'game_state' => $_SESSION['Tic_Tac_Toe']['game_state']
            ]);

    }

    function actionMove () {
        
        if (isset($_GET['col']) && isset($_GET['row'])) {
            $i = $_GET['col'];
            $j = $_GET['row'];
            if ($this->game->check_winner() == '') {
                $this->game->put_cross($j, $i);
    
                if ($this->game->check_winner() != '') {
                    $_SESSION['Tic_Tac_Toe']['game_state'] = $this->game->check_winner();
                } else {
                    $this->game->put_random_circle();
    
                    if ($this->game->check_winner() != '') {
                        $_SESSION['Tic_Tac_Toe']['game_state'] = $this->game->check_winner();
                    }
                }
            }
        }

        $this->redirect('?t='.$this->classNameNP().'&a=showField');

    }

    function actionNewGame () {
        $this->game = new AI($this->field_size, 'cross');
        unset($_SESSION['Tic_Tac_Toe']);
        $this->redirect('?t='.$this->classNameNP().'&a=showField');

    }

}

?>