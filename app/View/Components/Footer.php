<?php

namespace App\View\Components;

use App\Repositories\Interfaces\PageRepositoryInterface;
use Illuminate\View\Component;

class Footer extends Component {
    public $mainMenu;
    public function __construct() {
        $pageRepository = app(PageRepositoryInterface::class);
        $this->mainMenu = $pageRepository->getMainMenu();
    }

    public function render() {
        return view('components.footer');
    }
}