<?php
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
        <div class="card-header">Animal Info</div>

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
          <table class="table table-striped table-bordered table-hover">
            <tr> <td> <b>ID </th> <td> {{$animal['id']}}</td></tr>
            <tr> <th>Name </th> <td>{{$animal->name}}</td></tr>
            <tr> <th>Date of Birth </th> <td>{{$animal->birth_date}}</td></tr>
            <tr> <th>Description </th> <td style="max-width:150px;" >{{$animal->description}}</td></tr>
            <tr> <td colspan='2' ><img style="width:100%" src="{{ asset('storage/images/'.$animal->image)}}"></td></tr>
            <tr> <th>Date added </th> <td>{{$animal->created_at}}</td></tr>
            @if (Gate::allows('isadmin'))
              <tr>
                <th> Adopter </th>
                <td>
                  <?php
                    if ($animal->adopter_id == null) {
                      echo "--";
                    } else {
                      $userName = User::where('id', $animal->adopter_id)->get()->first()->name;
                      echo $userName . ' [ID: ' . $animal->adopter_id . ']';
                    }
                  ?>
                </td>
              </tr>
            @endif
          </table>
          <table>
            <tr>
              <td><a href="{{url()->previous()}}" class="btn btn-primary" role="button">Back to list</a></td>
              @if (Gate::allows('isadmin'))
              <td>
                <a href="{{ route('animals.edit', ['animal' => $animal['id']]) }}" class="btn btn-warning">Edit</a>
              </td>
              @elseif ($animal->adopter_id == null)
              <td>
                <form action="{{ url('adoptionrequests') }}" method="post">
                  @csrf
                  <input name="animal_id" type="hidden" value="{{$animal['id']}}">
                  <button class="btn btn-success" type="submit">Request adoption</button>
                </form>
              </td>
              @endif
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@endguest
