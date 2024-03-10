<?php

namespace App\Http\View\Composers;

use App\Module;
use Illuminate\View\View;

class HeaderComposer {

    public function compose(View $view) {
        $view->with('modules', Module::all());
    }

}
