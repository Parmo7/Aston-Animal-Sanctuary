<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;
use Gate;

class AdoptionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Gate::denies('isadmin')) { // normal user
        $userID = Auth::user()->id;
        $requestsQuery = AdoptionRequest::where('user_id', $userID)->get()->sortBy($this->getSortingOrder());
        return view('requests.index', array('requests'=>$requestsQuery, 'onlyPending'=>true));

      } else {  // admin user
        $requestsQuery = AdoptionRequest::all()->sortBy($this->getSortingOrder());
        return view('requests.index', array('requests'=>$requestsQuery));
      }
    }

    private function getSortingOrder() {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $adoptionRequest = new AdoptionRequest();
      $adoptionRequest->animal_id = $request->input('animal_id');
      $adoptionRequest->user_id = Auth::user()->id;
      $adoptionRequest->created_at = now();

      $adoptionRequest->save();
      return redirect('home')->with('success', 'The request has been recorded.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $request = AdoptionRequest::find($id);
      $myUserID = Auth::user()->id;

      if (!(Gate::denies('isadmin') && $request->user_id != $myUserID)) {
        return view('requests.show', compact('request'));//
      } else {
        return redirect('home');
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if (Gate::allows('isadmin')) {
        $adoptionRequest = AdoptionRequest::find($id);

        if ($request->input('operation') == "approve") {
          $adoptionRequest->status = "approved";
          $adoptionRequest->updated_at = now();
          $adoptionRequest->save();

          // update the adopter_id of the animal
          $animal = Animal::find($adoptionRequest->animal_id);
          $animal->adopter_id = $adoptionRequest->user_id;
          $animal->updated_at = now();
          $animal->save();

          // deny all other requests
          $otherRequests = AdoptionRequest::where('id', '!=', $adoptionRequest->id)
                            ->where('animal_id', $adoptionRequest->animal_id)->get();
          foreach($otherRequests as $otherRequest) {
            $otherRequest->status = "denied";
            $otherRequest->updated_at = now();
            $otherRequest->save();
          }

          return redirect('home')->with('success', 'You have successfully accepted the adoption request.');

        } else if ($request->input('operation') == "deny") {
          // deny the current request
          $adoptionRequest->status = "denied";
          $adoptionRequest->updated_at = now();
          $adoptionRequest->save();
          return redirect('home')->with('success', 'You have successfully rejected the adoption request.');
        }
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
