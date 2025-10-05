<?php

    namespace App\Http\Controllers;
    
    use Illuminate\View\View;
    
    /**
     * 
     * 
     *
     */
    class MainController extends Controller
    {
        /**
         * 
         * @return View
         */
        public function index(): View
        {
            return view('index',[
                'app_name' => $this->app_name
            ]);
        }
    }
?>
