<?php

namespace GeekhubShop\Controllers;

use Symfony\Component\HttpFoundation\Request;
use function render_template;

class HelloController
{
    public function index(Request $request)
    {
        return render_template($request);
    }
}