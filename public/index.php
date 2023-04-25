<?php

use App\Kernel;
// Routeur : route(uri) => le code à executer
//echo('cc GL2');
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
