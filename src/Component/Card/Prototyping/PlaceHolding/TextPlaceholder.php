<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Prototyping\CardVariable;
use Star\GameEngine\Component\Card\Prototyping\MissingPlaceholderValue;
use Star\GameEngine\Component\Card\Prototyping\Type\TextType;

final class TextPlaceholder implements TemplatePlaceholder
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function buildVariables(PlaceholderData $data): array
    {
        if (! $data->hasKey($this->name)) {
            throw new MissingPlaceholderValue($this->name, $data);
        }

        return [
            new CardVariable($this->name, (new TextType())->stringToVariableValue($data->getStringValue($this->name))),
        ];
    }
}
