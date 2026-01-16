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

    public function __construct(
        $name,
        $model
    ) {
        $this->name = $name;
        $this->model= $model;
    }

    public function render()
    {
        return view('components.jasni-bootstrap');
    }
}
