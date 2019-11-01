<?php

namespace GeekhubShop\Views;

use function ob_get_clean;
use function ob_start;

class BaseView
{
    private const TEMPLATES_DIR = '/application/src/templates/';

    /**
     * @param $data
     * @param $template
     * @return string
     * @throws \Exception
     */
    public function renderTemplate($data, $template): string
    {
        $file = self::TEMPLATES_DIR . $template;
        if (!file_exists($file)) {
            throw new \Exception("Template file not found: $file");
        }
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
