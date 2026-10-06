<?php

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Component;

class DataField extends Component
{
    protected string $view = 'forms.components.data-field';

    public static function make(): static
    {
        return new static();
    }

    protected array | Closure $items = [];

    protected string $description = '';

    public function items(array | Closure $items): static
    {
        $this->items = $items;
        
        return $this;
    }

    public function getItems(): array
    {
        return $this->evaluate($this->items);
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->evaluate($this->description);
    }
}
