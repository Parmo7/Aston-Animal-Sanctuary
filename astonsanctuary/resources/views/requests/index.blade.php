<?php
  use App\Models\Animal;
  use App\Models\User;
?>
@extends('layouts.app')

@guest
@else
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
              <?php
                if (Gate::allows('isadmin')) {
                  $header = (isset($onlyPending) && $onlyPending)? 'Pending Requests' : 'All Requests';
                } else {
                  $header = 'My Requests';
                }
              ?>
                <div class="card-header">{{$header}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- display the success status -->
                    @if (\Session::has('success'))
                      <div class="alert alert-success">
                      <p>{{ \Session::get('success') }}</p>
                      </div><br />
                    @endif

                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="id">
                            </form>
                          </th>
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="animal">
                            </form>
                          </th>
                          @if (Gate::allows('isadmin'))
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="user">
                            </form>
                          </th>
                          @endif
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="date">
                            </form>
                          </th>
                          @if (!(isset($onlyPending) && $onlyPending) || Gate::denies('isadmin'))
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase"
                                     type="submit" name="sort" value="status">
                            </form>
                          </th>
                          @endif
                          <th> ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($requests as $request)
                        <?php $animalName = Animal::where('id', $request->animal_id)->get()->first()->name; ?>
                        <?php $userName = User::where('id', $request->user_id)->get()->first()->name ?>
                        <tr>
                          <td> {{$request->id}} </td>
                          <td> {{$animalName}} </td>
                          @if (Gate::allows('isadmin'))
                          <td> {{$userName}} </td>
                          @endif
                          <td> {{$request->created_at}}</td>
                          @if (!(isset($onlyPending) && $onlyPending) || Gate::denies('isadmin'))
                          <td> {{$request->status}} </td>
                          @endif
                          <td>
                            <a href="{{route('adoptionrequests.show', ['adoptionrequest' => $request['id']] )}}" class="btn btn-primary">
                              View
                            </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endguest
