<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use LogicException;
use function gettype;
use function sprintf;
use function strval;

final class NotSupportedTypeConversion extends LogicException
{
    /**
     * @param mixed $raw
     * @param string $to
     */
    public function __construct($raw, string $to)
    {
        parent::__construct(
            sprintf(
                'Conversion of value "%s" to "%s()" is not supported.',
                $this->getReadableType($raw),
                $to
            )
        );
    }

    /**
     * @param mixed $raw
     * @return string
     */
    private function getReadableType($raw): string
    {
        $type = gettype($raw);
        switch ($type) {
            case 'double':
                $type = 'float';
                break;
        }

        return sprintf('%s(%s)', $type, strval($raw));
    }
}
