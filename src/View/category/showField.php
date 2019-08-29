<?php

print_r ($field);

echo "\t\n<table class='TicTacToe'>";
    foreach ($field as $i => $v) {
        echo "\t\n<tr>";
        foreach ($v as $j =>$val) {
            echo "\t<td><a href='$targetURL&col=$j&row=$i'>$val</a></td>";
        }
        echo '</tr>';
    }
echo '</table><hr>';

echo "<a href='$targetNewGame'>New Game</a>";
echo $game_state;

?>