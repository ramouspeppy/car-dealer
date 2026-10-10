<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JasniBootstrap extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name;
    public $model;
    public $accept;

    public function __construct(
        $name,
        $model,
        $accept = 'image/*'
    ) {
        $this->name = $name;
        $this->model= $model;
        $this->accept = $accept;
    }

    public function render()
    {
        return view('components.jasni-bootstrap');
    }
}
