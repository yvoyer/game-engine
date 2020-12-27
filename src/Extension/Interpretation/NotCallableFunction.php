<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use RuntimeException;
use function get_class;
use function sprintf;

final class NotCallableFunction extends RuntimeException
{
    public function __construct(GameFunction $function)
    {
        parent::__construct(
            sprintf(
                'The function "%s" is not callable. '
                . 'You need to implement the __invoke() method on the class "%s".',
                $function->getName(),
                get_class($function)
            )
        );
    }
}
