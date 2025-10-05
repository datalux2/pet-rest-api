<?php

namespace App\Http\Controllers;

/**
 * 
 * Abstract class from which all classes inherit
 *
 */
abstract class Controller
{
    /**
     * Application name
     * 
     * @var string
     */
    public string $app_name;
    
    /**
     * Constructor of abstract class containing
     * setting of application name from .env
     * parameter file
     */
    public function __construct()
    {
        $this->app_name = env('APP_NAME');
    }
}
