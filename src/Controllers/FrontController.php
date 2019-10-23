<?php

namespace GeekhubShop\Controllers;

use GeekhubShop\Views\BaseView;

class FrontController extends BaseController
{
    private const CONTROLLERS = [
        'store' => StoreController::class
    ];

    /**
     * Find an appropriate controller for action in the request and call it. Called controller
     * is responsible for printing output.
     * Print error page in case no controller for given action can be found.
     */

    public function run()
    {
        $controller = $this->getPageController();
        if ($controller !== null) {
            $controller->run();
        }
    }

    /**
     * Get a controller object appropriate for handling page request. Page name should be passed
     * as GET or POST request.
     * @return BaseController|null
     */
    private function getPageController(): ?BaseController
    {
        // todo: just switch to a good request parser library in future tbh
        $page = @$_REQUEST['page'];
        if (!array_key_exists($page, self::CONTROLLERS)) {
            $this->error(404, 'Page not found');
            return null;
        }
        $class = self::CONTROLLERS[$page];
        return new $class;
    }
}
