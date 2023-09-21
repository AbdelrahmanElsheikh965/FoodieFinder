<?php

namespace App\Http\Traits;

trait helpers{

    public function adminGenerals($module)
    {
        return view("admin.$module");
    }
}
