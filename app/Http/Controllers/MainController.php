<?php

    namespace App\Http\Controllers;
    
    use Illuminate\View\View;
    
    /**
     * 
     * Class of main controller
     *
     */
    class MainController extends Controller
    {
        /**
         * Show main page
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
