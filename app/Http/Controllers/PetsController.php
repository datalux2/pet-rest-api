<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * 
 * 
 *
 */
class PetsController extends Controller
{
    /**
     * 
     * @return View
     */
    public function index(): View
    {
        return view('pets/index', [
            'app_name' => $this->app_name
        ]);
    }
    
    /**
     * 
     * @return unknown
     */
    public function add()
    {
        return view('pets/add', [
            'app_name' => $this->app_name
        ]);
    }
    
    /**
     * 
     * @param Request $request
     * @return View
     */
    public function pet_add_api(Request $request): View
    {
        if ($request->isMethod('post'))
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_name' => 'string|max:255',
                'tag_names' => 'sometimes|required|array',
                'tag_names.*' => 'required|string|max:255',
                'status' => 'required|string|max:255'
            ]);
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'api_key' => env('API_KEY')
            ])->post(env('PET_REST_API_URL'), $validated);
            
            $httpCode = $response->status();
            
            if ($httpCode == 200)
            {
                $dataResponse = $response->json();
                
                return redirect()->route('list-by-status', [
                    'status' => $validated['status']
                ])->with('success', 'Element PET o id ' . $dataResponse['id'] . ' został ' .
                    'dodany do listy w REST API');
            }
            else
            {
                switch($httpCode)
                {
                    case 405:
                        $message = 'Nieprawidłowe dane wejściowe';
                        break;
                        
                    default:
                        $message = 'Nieokreślony błąd';
                        break;
                }
                
                return redirect()->back()->with('error', 'Wystąpił błąd przesyłania danych. ' . 
                    '<br/><br/>Kod błędu HTTP: ' . $httpCode . '<br/><br/>' . $message);
            }
        }
    }
    
   /**
    * 
    * @param unknown $id
    * @return View
    */
    public function edit($id): View
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'api_key' => env('API_KEY')
        ])->get(env('PET_REST_API_URL') . '/' . $id);
        
        $httpCode = $response->status();
        
        $data = $response->json();
        
        return view('pets/edit', [
            'data' => $data,
            'httpCode' => $httpCode,
            'app_name' => $this->app_name
        ]);
    }
    
    /**
     * 
     * @param Request $request
     * @return View
     */
    public function pet_edit_api(Request $request): View
    {
        if ($request->isMethod('post'))
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'category_name' => 'string|max:255',
                'tag_names' => 'sometimes|required|array',
                'tag_names.*' => 'required|string|max:255',
                'status' => 'required|string|max:255'
            ]);
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'api_key' => env('API_KEY')
            ])->put(env('PET_REST_API_URL'), $validated);
            
            $httpCode = $response->status();
            
            if ($httpCode == 200)
            {
                $dataResponse = $response->json();
                
                return redirect()->route('list-by-status', [
                    'status' => $data['status']   
                ])->with('success', 'Element PET o id ' . $data['id'] . ' został ' . 
                    'zaktualizowany na liscie w REST API');
            }
            else
            {
                switch($httpCode)
                {
                    case 400:
                        $message = 'Nieprawidłowe pole ID';
                        break;
                    
                    case 404:
                        $message = 'Nie znaleziono elementu PET dla zasobu REST API';
                        break;
                        
                    case 405:
                        $message = 'Wystąpił błąd walidacji';
                        break;
                        
                    default:
                        $message = 'Nieokreślony błąd';
                        break;
                }
                
                return redirect()->back()->with('error', 'Wystąpił błąd przesyłania danych. ' .
                    '<br/><br/>Kod błędu HTTP: ' . $httpCode . '<br/><br/>' . $message);
            }
        }
    }
    
    /**
     * 
     * @param Request $request
     */
    public function pet_delete_api(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $id = $request->input('id');
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'api_key' => env('API_KEY')
            ])->delete(env('PET_REST_API_URL') . '/' . $id);
            
            $httpCode = $response->status();
            
            if ($httpCode == 200)
            {
                $dataResponse = $response->json();
                
                session()->flash('success', 'Element PET o id ' . $id . ' został usunięty z zasobu REST API');
            }
            else 
            {
                switch($httpCode)
                {
                    case 400:
                        $message = 'Nieprawidłowe pole ID';
                        break;
                        
                    case 404:
                        $message = 'Nie znaleziono elementu PET dla zasobu REST API';
                        break;
                        
                    default:
                        $message = 'Nieokreślony błąd';
                        break;
                }
                
                session()->flash('error', 'Wystąpił błąd przesyłania danych. <br/><br/>Kod błędu HTTP: ' . 
                    $httpCode . '<br/><br/>' . $message);
            }
        }
    }
    
    /**
     * 
     * @param Request $request
     * @param string $status
     * @return View
     */
    public function list_by_status(Request $request, string $status): View
    {        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'api_key' => env('API_KEY')
        ])->get(env('PET_REST_API_URL') . '/findByStatus', [
            'status' => $status
        ]);
        
        $httpCode = $response->status();
        
        if ($httpCode == 200)
        {
            $data = $response->json();
            
            // Convert an array to a collection
            $collection = collect($data);
            
            // Pagination parameters
            $perPage = config('pagination.per_page', 10);
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();
            
            // Create a paginator
            $paginator = new LengthAwarePaginator(
                $currentItems,
                $collection->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        else 
        {
            $paginator = null;
        }
        
        return view('pets/list-by-status', [
            'data' => $paginator,
            'status' => $status,
            'httpCode' => $httpCode,
            'app_name' => $this->app_name
        ]);
    }
}
