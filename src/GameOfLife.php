<?php

class GameOfLife {
    public $board;     // nasza tablica
    private $boardSize; // rozmiar tablicy

    private function getNextStepForCell($row, $column){       // podanie namiarów komórki do sprawdzenia
        $lifeNeighbours = 0;
        for($i = $row - 1; $i <= $row + 1; $i++){            // sprawdzenie wszytkich rzędów naokoło wybranej komórki
            for($j = $column - 1; $j <= $column + 1; $j++){  // sprawdzenie wszystkich kolumn naokoło
                if( !($i === $row && $j === $column) ){      // jeśli współrzędne nie są równę współrzędnym komórki (wykluczmay ją, gdyż interesuje nas tylko to co jest w okoł niej)
                    if($i >= 0 && $j >= 0 && $i < $this->boardSize && $j < $this->boardSize) // jeśli podany rząd i kolumna istnieją, czyli są większe od 0 i mniejsze od wielkości tablicy
                        if($this->board[$i][$j] === true){
                            $lifeNeighbours++;                // sprawdza liczbę żywych sąsiadów
                        }
                }
            }
        }
        if($this->board[$row][$column] === true){ // jeśli komórka jest żywa
            if($lifeNeighbours === 2 || $lifeNeighbours === 3){ // jeśli żywych sąsiadów jest 2 lub 3 to pozostaw komórkę na żywą
                return true;
            } else {
                return false;
            }
        } else {                              // jeśli komórka jest martwa
            if($lifeNeighbours === 3){        // jeśli są 3 komórki żywe zamień martwą komórkę na żywą
                return true;
            } else {
                return false;
            }
        }
    }

    public function __construct($newSize){
        if(is_integer($newSize)){              // określenie rozmiaru tablicy
            $this->boardSize = $newSize;
        } else {
            $this->boardSize = 10;
        }

        $this->board = [];                            // stworzenie tablicy
        for($i = 0; $i < $this->boardSize; $i++){
            $this->board[$i] = [];
            for($j = 0; $j < $this->boardSize; $j++){
                $this->board[$i][$j] = false;          // na początku zakładamy, że wszystkie komórki są martwe
            }
        }
    }

    public function printBoard(){ // stworzenie tablicy w  html
        echo("<table>");
        for($i = 0; $i <$this->boardSize; $i++){
            echo("<tr>");
            for($j = 0; $j < $this->boardSize; $j++){
                if($this->board[$i][$j] === true){
                    echo("<td class='alive'>");   // oznaczenie żywych komórek
                    echo("</td>");
                } else {
                    echo("<td>");
                    echo("</td>");
                }
            }
            echo("</tr>");
        }
        echo("</table>");
    }

    public function setCell($row, $column, $value){
        if(is_int($row) === false || is_int($column) === false || is_bool($value) === false
            || $row < 0 || $column < 0 || $column >= $this->boardSize || $row >= $this->boardSize){
            return;
        } else {
            $this->board[$row][$column] = $value;           // usatwienie pierwszych żywych komórek
        }
    }

    public function computeNextStep(){   // sprawdzenie całej tablicy poprzez stworzenie tablicy tymczasowej i po całym sprawdzeniu zaimplementowanie tablicy tymczasowej jako prawdziwej tablicy
        $tempBoard = [];
        for($i = 0; $i < $this->boardSize; $i++){
            $tempBoard[$i] = [];
            for($j = 0; $j < $this->boardSize; $j++){
                $tempBoard[$i][$j] = $this->getNextStepForCell($i, $j);
            }
        }
        $this->board = $tempBoard;
    }
	
	public function setFirstAliveCells($cell1, $cell2, $boardSize){
			$this->setCell($cell1, $cell2, true);
			if($cell1 <= $boardSize - 1){
				$this->setCell($cell1 + 2, $cell2, true);
				$this->setCell($cell1 + 1, $cell2, true);
			} else {
				$this->setCell($cell1 - 2, $cell2, true);
			}
			if($cell2 <= $boardSize - 1){
				$this->setCell($cell1, $cell2 + 1, true);
				$this->setCell($cell1, $cell2 - 2, true);
			} else {
				$this->setCell($cell1, $cell2 - 2, true);
			}
	}
}
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 2016-01-28
 * Time: 15:30
 */