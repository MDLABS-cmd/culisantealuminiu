<?php

namespace App\Livewire\Ui;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class FormInput extends Component
{
    #[Modelable]
    public $value = null;

    public ?string $label = null;
    public string $type = 'text';
    public ?string $placeholder = null;
    public ?string $step = null;
    public ?string $min = null;
    public ?string $max = null;

    public string $containerClass = '';
    public string $labelClass = '';
    public string $wrapperClass = '';
    public string $inputClass = '';

    public function render()
    {
        return view('livewire.ui.form-input');
    }
}
