<?php

namespace App\Livewire;

use Livewire\Component;

class Input extends Component
{
  public $type;
  public $placeholder;
  public $required;
  public $disabled;
  public $value;
  public $name;
  public $label;
  public $icon;
  public $class;
  public function __construct(
    $type = 'text',
    $placeholder = '',
    $required = false,
    $disabled = false,
    $value = '',
    $name = '',
    $label = '',
    $icon = '',
    $class = ''
  )
  {
    $this->type = $type;
    $this->placeholder = $placeholder;
    $this->required = $required;
    $this->disabled = $disabled;
    $this->value = $value;
    $this->name = $name;
    $this->label = $label;
    $this->icon = $icon;
    $this->class = $class;
  }

  public function render()
  {
      return view('livewire.input');
  }
}
