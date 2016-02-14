<!DOCTYPE html>
<head>
    <link type="text/css" rel="stylesheet" href="./style/css.css">
    <meta charset="UTF-8">
</head>
<body>
<form method="GET">
    <p>Wybierz rozmiar tablicy</p>
    <input type="text" name="size">
    <p>Podaj liczby dwie liczby startowe</p>
    <input type="text" name="nr1">
    <input type="text" name="nr2">
    <input type="submit" name="wyslij" value="Rozpocznij grę">
    <input type="submit" name="dalej" value="Graj">
</form>
<br>
<?php
require_once("./src/GameOfLife.php");
session_start();
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['wyslij'])){
        if(isset($_GET['size']) && isset($_GET['nr1']) && isset($_GET['nr2'])){
            $sizeOfBoard = intval($_GET['size']);
            $nr1 = intval($_GET['nr1']);
            $nr2 = intval($_GET['nr2']);
            if($sizeOfBoard > 2 && $nr1 >= 0 && $nr2 >= 0){
                $game = new GameOfLife($sizeOfBoard);
                $game->setCell(($nr1-1),($nr2-1),true);
                if($nr1 >= 0 && $nr1 <= $sizeOfBoard -1){
                    $game->setCell($nr1,($nr2-1),true);
                }
                if($nr2 >= 0 && $nr2 <= $sizeOfBoard -1){
                    $game->setCell(($nr1-1),$nr2,true);
                }
                $game->printBoard();
                $_SESSION['size'] = $sizeOfBoard;
                $_SESSION['nr1'] = $nr1-1;
                $_SESSION['nr2'] = $nr2-1;
            } else {
                echo("Zle podane dane. Pamietaj aby wybrac dodatnie liczby calkowite");
            }
        }
    }
    $_SESSION['game'] = new GameOfLife($_SESSION['size']);
    $_SESSION['game']->setCell($_SESSION['nr1'], $_SESSION['nr2'], true);
    $_SESSION['game']->setCell($_SESSION['nr1']+1,($_SESSION['nr2']),true);
    $_SESSION['game']->setCell($_SESSION['nr1'], $_SESSION['nr2']+1,true);
    if(isset($_GET['dalej'])){
        $_SESSION['game']->computeNextStep();
        $_SESSION['game']->printBoard();
    }


}
/*
$game = new GameOfLife(5);
$game->setCell(3,4,true);
$game->setCell(2,4,true);
$game->setCell(3,3,true);
$game->printBoard();

$game->computeNextStep();
$game->printBoard();
*/
?>

</body>
</html>
