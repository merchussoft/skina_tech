<?php

function api_autoload($class_name) {

    if (file_exists(CONTROLLERS . "{$class_name}.php")) {
        include_once(CONTROLLERS . "{$class_name}.php");
    }

    if (file_exists(MODELS . "{$class_name}.php")) {
        include_once(MODELS . "{$class_name}.php");
    }

    if (file_exists(SYSTEMS . "{$class_name}.php")) {
        include_once(SYSTEMS . "{$class_name}.php");
    }

}