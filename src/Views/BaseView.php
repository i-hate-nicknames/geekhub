<?php

namespace GeekhubShop\Views;

use GeekhubShop\App;
use function ob_get_clean;
use function ob_start;

class BaseView
{
    /**
     * @param $data
     * @param $template
     * @throws \Exception
     */
    public function renderTemplate($data, $template): string
    {
        $file = App::TEMPLATES_DIR . $template;
        if (!file_exists($file)) {
            throw new \Exception("Template file not found: $template");
        }
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
