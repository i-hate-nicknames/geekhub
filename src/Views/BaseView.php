<?php

namespace GeekhubShop\Views;

use GeekhubShop\App;

class BaseView
{
    /**
     * @param $data
     * @param $template
     * @throws \Exception
     */
    public function renderTemplate($data, $template)
    {
        $file = App::TEMPLATES_DIR . $template;
        if (!file_exists($file)) {
            throw new \Exception("Template file not found: $template");
        }
        include $file;
    }
}
