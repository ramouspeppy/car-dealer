<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropzone extends Component
{
    public $name;
    public $acceptedFiles;
    public $maxFileSize;
    public $existingFiles;

    public function __construct(
        $name,
        $acceptedFiles = '.jpeg,.jpg,.png,.webp',
        $maxFileSize = 2,
        $existingFiles = []
    ) {
        $this->name = $name;
        $this->acceptedFiles = $acceptedFiles;
        $this->maxFileSize = $maxFileSize;
        $this->existingFiles = $existingFiles;
    }

    public function render()
    {
        return view('components.dropzone');
    }
}
