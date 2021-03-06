<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\View\ViewRenderer;

final class GridBuilderTest extends TestCase
{
    public function test_it_should_create_a_square(): void
    {
        $builder = new GridBuilder();
        $grid = $builder->square(4, new NumericHeader(), new NumericHeader());
        $renderer = $this->createMock(ViewRenderer::class);
        $renderer
            ->expects(self::exactly(16))
            ->method('collectCellToken');

        $grid->render($renderer);
    }

    public function test_it_should_create_a_rectangle(): void
    {
        $builder = new GridBuilder();
        $grid = $builder->rectangle(2, 4, new NumericHeader(), new NumericHeader());
        $renderer = $this->createMock(ViewRenderer::class);
        $renderer
            ->expects(self::exactly(8))
            ->method('collectCellToken');

        $grid->render($renderer);
    }
}
