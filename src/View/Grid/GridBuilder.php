<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

final class GridBuilder implements GridFactory
{
    /**
     * @var GridHeader
     */
    private $columnHeader;

    /**
     * @var GridHeader
     */
    private $rowHeader;

    public function __construct(GridHeader $columnHeader, GridHeader $rowHeader)
    {
        $this->columnHeader = $columnHeader;
        $this->rowHeader = $rowHeader;
    }

    public function createGrid(): GameGrid
    {
        $grid = new Grid();
        $columnMaxCount = $this->columnHeader->maximumCount();
        $rowMaxCount = $this->rowHeader->maximumCount();

        for ($column = 1; $column <= $columnMaxCount; $column++) {
            for ($row = 1; $row <= $rowMaxCount; $row++) {
                $grid->createCell(
                    Coordinate::fromStrings(
                        $this->columnHeader->generateId($column),
                        $this->rowHeader->generateId($row)
                    )
                );
            }
        }

        return $grid;
    }
}
