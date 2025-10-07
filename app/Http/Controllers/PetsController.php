<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use App\Enums\Rest_Api_Action_Type;

/**
 * 
 * Class of controller concerning
 * pets
 *
 */
class PetsController extends Controller
{
    /**
     * Show links to pets lists by available, pending and sold status
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
     * Show pet add form
     * 
     * @return View
     */
    public function add(): View
    {
        return view('pets/add', [
            'app_name' => $this->app_name
        ]);
    }
    
    /**
     * Adding pet to REST API PET list
     * 
     * @param Request $request
     * @return View
     */
    public function pet_add_api(Request $request): RedirectResponse
    {    
        return $this->rest_api_action(Rest_Api_Action_Type::Add, $request);
    }
    
    /**
     * Show pet edit form
     * 
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
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
     * Updating pet in REST API PET list
     * 
     * @param Request $request
     * @return View
     */
    public function pet_edit_api(Request $request): RedirectResponse
    {
        return $this->rest_api_action(Rest_Api_Action_Type::Edit, $request);
    }
    
    /**
     * Deleting pet in REST API PET list
     * 
     * @param Request $request
     * @return void
     */
    public function pet_delete_api(Request $request)
    {
        $this->rest_api_action(Rest_Api_Action_Type::Delete, $request);
    }
    
    /**
     * Executes REST API action like add, edit
     * or delete element depending on type
     * parameter
     * 
     * @param Rest_Api_Action_Type $type
     * @param Request $request
     */
    private function rest_api_action(Rest_Api_Action_Type $type, Request $request)
    {
        if ($request->isMethod('post'))
        {
            if($type == Rest_Api_Action_Type::Add || $type == Rest_Api_Action_Type::Edit)
            {
                $paramaters = [
                    'name' => 'required|string|max:255',
                    'category_name' => 'nullable|string|max:255',
                    'tag_names' => 'sometimes|required|array',
                    'tag_names.*' => 'required|string|max:255',
                    'status' => 'required|string|max:255'
                ];
                
                if ($type == Rest_Api_Action_Type::Edit)
                {
                    $paramaters['id'] = 'required|integer|min:0';    
                }
                
                $validated = $request->validate($paramaters);
                
                $validated['name'] = trim($validated['name']);
                $validated['category_name'] = trim($validated['category_name']);
                $validated['status'] = trim($validated['status']);
                
                if(trim($validated['category_name']) != '')
                {
                    $validated['category']['name'] = $validated['category_name'];
                    
                    unset($validated['category_name']);
                }
                
                if(isset($validated['tag_names']) && is_array($validated['tag_names']) && !empty($validated['tag_names']))
                {
                    foreach($validated['tag_names'] as $key => $tag)
                    {
                        $validated['tags'][]['name'] = trim($tag);
                    }
                    
                    unset($validated['tag_names']);
                }
            }
            else if($type == Rest_Api_Action_Type::Delete)
            {
                $id = $request->input('id');
            }
            
            switch($type)
            {
                case Rest_Api_Action_Type::Add:
                    $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'api_key' => env('API_KEY')
                    ])->post(env('PET_REST_API_URL'), $validated);
                    
                    break;
                    
                case Rest_Api_Action_Type::Edit:
                    $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'api_key' => env('API_KEY')
                    ])->put(env('PET_REST_API_URL'), $validated);
                    
                    break;
                    
                case Rest_Api_Action_Type::Delete:
                    $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'api_key' => env('API_KEY')
                    ])->delete(env('PET_REST_API_URL') . '/' . $id);
                    
                    break;
            }
            
            $httpCode = $response->status();
            
            if ($httpCode == 200)
            {
                $dataResponse = $response->json();
                
                switch($type)
                {
                    case Rest_Api_Action_Type::Add:
                        return redirect()->route('list-by-status', [
                        'status' => $validated['status']
                        ])->with('success', 'Element PET o id ' . $dataResponse['id'] . ' został ' .
                            'dodany do listy w REST API');
                        
                        break;
                        
                    case Rest_Api_Action_Type::Edit:
                        return redirect()->route('list-by-status', [
                        'status' => $validated['status']
                        ])->with('success', 'Element PET o id ' . $dataResponse['id'] . ' został ' .
                            'zaktualizowany na liście w REST API');
                        
                        break;
                        
                    case Rest_Api_Action_Type::Delete:
                        session()->flash('success', 'Element PET o id ' . $id . ' został usunięty z zasobu REST API');
                        
                        break;
                }
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
                        $message = 'Nieprawidłowe dane wejściowe';
                        break;
                        
                    default:
                        $message = 'Nieokreślony błąd';
                        break;
                }
                
                if ($type == Rest_Api_Action_Type::Add || 
                        $type == Rest_Api_Action_Type::Edit)
                {
                    return redirect()->back()->with('error', 'Wystąpił błąd przesyłania danych. ' .
                        '<br/><br/>Kod błędu HTTP: ' . $httpCode . '<br/><br/>' . $message);
                }
                else if ($type == Rest_Api_Action_Type::Delete)
                {
                    session()->flash('success', 'Element PET o id ' . $id . ' został usunięty z zasobu REST API');
                }
            }
        }
    }
    
    /**
     * Show list of pets in REST API PET by status
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
