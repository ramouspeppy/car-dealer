<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropzone extends Component
{
    public $name;
    public $acceptedFiles;
    public $maxFileSize;
    public $existingFiles;
    public $uploadUrl;
    public $removeUrl;

    public function __construct(
        $name,
        $acceptedFiles = '.jpeg,.jpg,.png,.webp',
        $maxFileSize = 2,
        $existingFiles = [],
        $uploadUrl = null,
        $removeUrl = null
    ) {
        $this->name = $name;
        $this->acceptedFiles = $acceptedFiles;
        $this->maxFileSize = $maxFileSize;
        $this->existingFiles = $existingFiles;
        $this->uploadUrl = $uploadUrl ?: route('backend.images.store');
        $this->removeUrl = $removeUrl ?: route('backend.images.destroy');
    }

    public function render()
    {
        return view('components.dropzone');
    }
}
