<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Gate;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (Gate::denies('isadmin')) { // normal user
        $animalsQuery = Animal::where('name', 'LIKE', '%Rabbit%')->get();

        $userID = Auth::user()->id;
        $animalsQuery = Animal::where('adopter_id', $userID);
        //check if there is any filtering request
        if (isset($_REQUEST['filter']) && trim($_REQUEST['filter']) !== '') {
          $filter = trim($_REQUEST['filter']);
          $animalsQuery = $animalsQuery->where('name', 'LIKE', '%'.$filter.'%');
        }

        $animalsQuery = $animalsQuery->get()->sortBy($this->getSortingOrder());
        return view('animals.index', array('animals'=>$animalsQuery, 'onlyAdopted'=>true));

      } else {  // admin user
        //check if there is any filtering request
        if (isset($_REQUEST['filter']) && trim($_REQUEST['filter']) !== '') {
          $filter = trim($_REQUEST['filter']);
          $animalsQuery = Animal::where('name', 'LIKE', '%'.$filter.'%')->get();
        } else {
          $animalsQuery = Animal::all();
        }

        $animalsQuery = $animalsQuery->sortBy($this->getSortingOrder());
        return view('animals.index', array('animals'=>$animalsQuery));
      }
    }

    private function getSortingOrder() {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('animals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (Gate::allows('isadmin')) {
        // form validation
        $animal = $this->validate(request(), [
          'name' => 'required',
          'birth_date' => 'required|date',
          'description' => 'required',
          'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000'
        ]);

        //Handles the uploading of the image
        if ($request->hasFile('image')) {
          //Gets the filename with the extension
          $fileNameWithExt = $request->file('image')->getClientOriginalName();
          //just gets the filename
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
          //Just gets the extension
          $extension = $request->file('image')->getClientOriginalExtension();
          //Gets the filename to store
          $fileNameToStore = $filename.'_'.time().'.'.$extension;
          //Uploads the image
          $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
          $fileNameToStore = 'noimage.jpg';
        }

        // create a Vehicle object and set its values from the input
        $animal = new Animal();
        $animal->name = $request->input('name');
        $animal->birth_date = $request->input('birth_date');
        $animal->description = $request->input('description');
        $animal->created_at = now();
        $animal->image = $fileNameToStore;
        // save the Vehicle object
        $animal->save();
        // generate a redirect HTTP response with a success message
        return redirect('animals')->with('success', 'The new animal has been added.');
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $animal = Animal::find($id);
      return view('animals.show', compact('animal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $animal = Animal::find($id);
      return view('animals.edit', compact('animal'));
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
        $animal = Animal::find($id);
        $this->validate(request(), [
          'name' => 'required',
          'birth_date' => 'required|date',
          'description' => 'required',
          'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:1000'
        ]);

        //Handles the uploading of the image
        if ($request->hasFile('image')){
          //Gets the filename with the extension
          $fileNameWithExt = $request->file('image')->getClientOriginalName();
          //just gets the filename
          $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
          //Just gets the extension
          $extension = $request->file('image')->getClientOriginalExtension();
          //Gets the filename to store
          $fileNameToStore = $filename.'_'.time().'.'.$extension;
          //Uploads the image
          $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
          $animal->image = $fileNameToStore;
        }

        $animal->name = $request->input('name');
        $animal->birth_date = $request->input('birth_date');
        $animal->description = $request->input('description');
        $animal->updated_at = now();

        $animal->save();
        return redirect('animals')->with('success', 'The animal has been updated.');
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

    }
}
