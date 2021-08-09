<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;

/**
 * @internal This class is internal to the CardBuilder class.
 * @see CardBuilder
 */
final class StringPlaceholder implements TemplatePlaceholder
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function buildVariables(VariableBuilder $builder, PlaceholderData $data): array
    {
        return [
            $builder->textVariable($this->name, $data->getStringValue($this->name)),
        ];
    }
}
