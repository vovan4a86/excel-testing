<?php

namespace App\View\Components;

use App\Repositories\Interfaces\PageRepositoryInterface;
use Fanky\Admin\Models\Page;
use Illuminate\View\Component;
use Request;

class Header extends Component {
    public $headerClass, $navClass;
    public $mainMenu, $aboutMenu;

    public function __construct($headerClass = null, $navClass = null) {
        $this->headerClass = $headerClass;
        $this->navClass = $navClass;
        if(Request::is('/')) {
            $this->headerClass .= ' header--homepage';
            $this->navClass .= ' nav--homepage';
        }

        $pageRepository = app(PageRepositoryInterface::class);
        $this->mainMenu = $pageRepository->getMainMenu();
        $this->aboutMenu = $pageRepository->getAboutMenu();
    }

    public function render() {
        return view('components.header');
    }
}