<?php
/*
 * Instead of loading files all the time in classes, this inbuilt function (after _autoload became depleted)
 * Basically checks for all instantiated classes within the namespace that will be defined and autoloads them
 * Instead of requiring/including classes every now and then
 */
spl_autoload_register(function ($className){
    /*since we're already using app instead of '/'(directory separator)
    *We look for app and replace it with '/'
    */

    $className = str_replace("app\\", DIRECTORY_SEPARATOR, $className);
    $path = __DIR__ . '/' . $className . '.php';
    if(!file_exists($path)){
        return false;
    }
    require $path;
});