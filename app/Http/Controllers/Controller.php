<?php

namespace App\Http\Controllers;

/**
 * 
 * 
 *
 */
abstract class Controller
{
    /**
     * 
     * @var string
     */
    public string $app_name;
    
    /**
     * 
     */
    public function __construct()
    {
        $this->app_name = env('APP_NAME');
    }
}
