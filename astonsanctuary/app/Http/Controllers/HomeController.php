<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Models\Animal;
use App\Models\AdoptionRequest;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Gate::denies('isadmin')) { // normal user
          $animalsQuery = Animal::where('adopter_id', null)
          ->whereNotIn('id', function ($query) {
              $userID = Auth::user()->id;
              $query->select('animal_id')->from('adoption_requests')->where('user_id', $userID);
          });
          //check if there is any filtering request
          if (isset($_REQUEST['filter']) && trim($_REQUEST['filter']) !== '') {
            $filter = trim($_REQUEST['filter']);
            $animalsQuery = $animalsQuery->where('name', 'LIKE', '%'.$filter.'%');
          }

          $animalsQuery = $animalsQuery->get()->sortBy($this->getAnimalSortingOrder());
          return view('animals.index', array('animals'=>$animalsQuery, 'onlyAdopted'=>false));

        } else {  // admin user
          $requestsQuery = AdoptionRequest::where('status', 'pending')->get()->sortBy($this->getRequestSortingOrder());
          return view('requests.index', array('requests'=>$requestsQuery, 'onlyPending'=>true));
        }
    }

    private function getRequestSortingOrder() {
      $order = 'id';
      if (isset($_REQUEST['sort'])) {
        switch($_REQUEST['sort']) {
          case 'animal':
            $order = 'animal_id';
            break;
          case 'status':
            $order = 'status';
            break;
          case 'date':
            $order = 'created_at';
            break;
          case 'user':
            $order = 'user_id';
            break;
          default:
            $order = 'id';
            break;
        }
      }
      return $order;
    }

    private function getAnimalSortingOrder() {
      $order = 'id';
      if (isset($_REQUEST['sort'])) {
        switch($_REQUEST['sort']) {
          case 'name':
            $order = 'name';
            break;
          case 'date of birth':
            $order = 'birth_date';
            break;
          case 'date added':
            $order = 'created_at';
            break;
          default:
            $order = 'id';
            break;
        }
      }
      return $order;
    }
}
