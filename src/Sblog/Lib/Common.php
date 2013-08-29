<?php
/**
 * Common functions
 * global functions
 *
 */
namespace Sblog\Lib\Common;

// print debug string
function pr($var) {
    if (DEBUG_PRINT) {
        $array = debug_backtrace();
        echo '[DEBUG] ' . $array[0]['file'] . " (line " . $array[0]['line'] . ")\n";
        echo '[DEBUG] ';
        print_r($var);
        echo "\n";
    }
}
