<?php
  use App\Models\Animal;
  use App\Models\AdoptionRequest;
  use App\Models\User;
?>

@extends('layouts.app')

@guest
@else
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      <div class="card">
        <div class="card-header">Adoption Request Info</div>

        <!-- display the errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
        <ul> @foreach ($errors->all() as $error)
        <li>{{ $error }}</li> @endforeach
        </ul>
        </div><br />
         @endif

        <!-- display the success status -->
        @if (\Session::has('success'))
        <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
        </div><br />
        @endif

        <div class="card-body">
          <table class="table table-striped table-bordered table-hover" >
            <tr> <td> <b>Request ID </th> <td> {{$request['id']}}</td></tr>
            <tr> <td> <b>Request Date </th> <td> {{$request->created_at}}</td></tr>
            <tr> <td> <b>Request Status </th> <td> {{$request->status}}</td></tr>
          </table>
          <table class="table table-striped table-bordered table-hover" >
            <?php $animal = Animal::where('id', $request->animal_id)->get()->first(); ?>
            <tr> <th>Animal ID</th> <td>{{$animal->id}}</td></tr>
            <tr> <th>Animal Name</th> <td>{{$animal->name}}</td></tr>
            <tr> <th>Date of Birth </th> <td>{{$animal->birth_date}}</td></tr>
            <tr> <th>Description </th> <td style="max-width:150px;" >{{$animal->description}}</td></tr>
            <tr> <td colspan='2' ><img style="width:100%" src="{{ asset('storage/images/'.$animal->image)}}"></td></tr>
            <tr> <th>Date Added </th> <td>{{$animal->created_at}}</td></tr>
          </table>
          @if (Gate::allows('isadmin'))
          <table class="table table-striped table-bordered table-hover" >
            <?php $user = User::where('id', $request->user_id)->get()->first(); ?>
            <tr> <th>User ID</th> <td>{{$user->id}}</td></tr>
            <tr> <th>User Name</th> <td>{{$user->name}}</td></tr>
            <tr> <th>E-mail</th> <td>{{$user->email}}</td></tr>
          </table>
          @endif
          <table>
            <tr>
              <td><a href="{{url()->previous()}}" class="btn btn-primary" role="button">Back to list</a></td>
              @if (Gate::allows('isadmin') && $request->status == 'pending')
              <td>
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                      action="{{ route('adoptionrequests.update', ['adoptionrequest' => $request['id']]) }}">
                  @method('PATCH')
                  @csrf
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="operation" value="approve">
                  <button class="btn btn-success" type="submit">Approve</button>
                </form>
              </td>
              <td>
                <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                      action="{{ route('adoptionrequests.update', ['adoptionrequest' => $request['id']]) }}">
                  @method('PATCH')
                  @csrf
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="operation" value="deny">
                  <button class="btn btn-danger" type="submit">Deny</button>
                </form>
              </td>
              @endif
            </tr>
          </table>
        </div>
      </div>
      @if (Gate::allows('isadmin') && $request->status == 'pending')
      <br>
      <div class="card">
        <div class="card-header">Other adoption requests for {{$animal->name}}</div>
        <?php $requests = AdoptionRequest::where('animal_id', $request->animal_id)->where('user_id', '!=' , $request->user_id)->get(); ?>
        <div class="card-body">
          @if (!$requests->isEmpty())
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th> ID</th>
                <th> USER </th>
                <th> DATE </th>
                <th> STATUS</th>
              </tr>
            </thead>
            <tbody>
              @foreach($requests as $request)
              <?php $animalName = Animal::where('id', $request->animal_id)->get()->first()->name; ?>
              <?php $userName = User::where('id', $request->user_id)->get()->first()->name ?>
              <tr>
                <td> {{$request->id}} </td>
                <td> {{$userName }} </td>
                <td> {{$request->created_at}}</td>
                <td> {{$request->status}} </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
            No other requests.
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
@endguest
