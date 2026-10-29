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

    public $tmpUrl;

    public function __construct(
        $name,
        $acceptedFiles = '.jpeg,.jpg,.png,.webp',
        $maxFileSize = 2,
        $existingFiles = [],
        $uploadUrl = null,
        $removeUrl = null,
        $tmpUrl = null
    ) {
        $this->name = $name;
        $this->acceptedFiles = $acceptedFiles;
        $this->maxFileSize = $maxFileSize;
        $this->existingFiles = $existingFiles;
        $this->uploadUrl = $uploadUrl ?: route('backend.images.store');
        $this->removeUrl = $removeUrl ?: route('backend.images.destroy');
        $this->tmpUrl = rtrim($tmpUrl ?: asset('upload/tmp/' . auth()->id()), '/') . '/';
    }

    public function render()
    {
        return view('components.dropzone');
    }
}
