<?php

namespace App\Livewire\Ui;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class FormSelect extends Component
{
    #[Modelable]
    public $value = null;

    public ?string $label = null;
    public array $options = [];
    public ?string $placeholder = null;
    public bool $disabled = false;

    public string $containerClass = '';
    public string $labelClass = '';
    public string $wrapperClass = '';
    public string $selectClass = '';

    public function render()
    {
        return view('livewire.ui.form-select');
    }
}
