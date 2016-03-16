<?php
require_once("./src/GameOfLife.php");
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['send'])){
		if(isset($_POST['size']) && isset($_POST['cell1']) && isset($_POST['cell2'])){
			$sizeOfBoard = intval($_POST['size']);
			$cell1 = intval($_POST['cell1']) - 1;
			$cell2 = intval($_POST['cell2']) - 1;
			if($sizeOfBoard > 4 && 
			    $cell1 >= 0 && $cell1 <= $sizeOfBoard && 
			    $cell2 >= 0 && $cell2 <= $sizeOfBoard){
				
				$_SESSION['size'] = $sizeOfBoard;
				$game = new GameOfLife($_SESSION['size']);
				$_SESSION['game'] = $game;
				$game->setFirstAliveCells($cell1, $cell2, $_SESSION['size']);
			} else {
				echo("Invalid data. Are you sure you enter positive numbers? Try one more time.");
			}
		}
	} elseif(isset($_POST['clear'])){
		header('refresh: 1;');
		echo('Thank you for choosing our game. Hope you had fun!');
		session_destroy();	
	} elseif(isset($_POST['step'])) {
		$_SESSION['game']->board = $_SESSION['newBoard'];
		$_SESSION['game']->computeNextStep();
	}
}
 ?>

<!DOCTYPE html>
<head>
    <link type="text/css" rel="stylesheet" href="./style/css.css">
    <meta charset="UTF-8">
</head>
<body>
    <form method="POST">
		<?php
		if(isset($_SESSION['size'])){
			echo('<br><input type="submit" name="step" value="Next step">
			<input type="submit" name="clear" value="Stop Game">');
			$_SESSION['game']->printBoard();
			$_SESSION['newBoard'] = $_SESSION['game']->board;
		} else {
			echo('
			<p>Choose size of the board (size of the board must be greater than 4)</p>
			<input type="text" name="size">
			<p>Choose coordinates for the first cell (remember to pick digits within the size of the board)</p>
			<input type="text" name="cell1">
			<input type="text" name="cell2">
			<input type="submit" name="send" value="Start game">
			');
		}
		?>
    </form>
    <br>

</body>
</html>
