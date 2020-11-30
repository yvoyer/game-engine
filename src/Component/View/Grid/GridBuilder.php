<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use Star\GameEngine\Component\View\Coordinate;

final class GridBuilder
{
    public function square(int $size, HeaderIdStrategy $columnHeader, HeaderIdStrategy $rowHeader): GameGrid
    {
        return $this->rectangle($size, $size, $columnHeader, $rowHeader);
    }

    public function rectangle(int $xSize, int $ySize, HeaderIdStrategy $columnHeader, HeaderIdStrategy $rowHeader): GameGrid
    {
        $grid = new Grid();

        for ($column = 1; $column <= $xSize; $column++) {
            for ($row = 1; $row <= $ySize; $row++) {
                $grid->placeToken(
                    Coordinate::fromStrings(
                        $columnHeader->generateId($column),
                        $rowHeader->generateId($row)
                    ),
                    new EmptyCell()
                );
            }
        }

        return $grid;
    }
}
