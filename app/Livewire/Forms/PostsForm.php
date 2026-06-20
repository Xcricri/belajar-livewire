<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PostsForm extends Form
{

    #[Validate('required|image|max:2048')]
    public $image;

    #[Validate('required')]
    public $title;

    #[Validate('required')]
    public $content;
}
