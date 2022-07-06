<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumbs extends Component {
    public $items;
    public function __construct(array $items) {
        $this->items = $items;
    }

    public function render() {
        return view('components.breadcrumbs');
    }
}