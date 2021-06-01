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
                    $header = 'All Animals';
                  } else {
                    $header = $onlyAdopted? 'My adopted animals':'Animals available for adoption';
                  }
                ?>
                <div class="card-header">
                  {{$header}}
                  @if (Gate::allows('isadmin'))
                  <a href="{{route('animals.create')}}" class="btn btn-dark float-right"> Add </a>
                  @endif
                </div>

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

                    <form action=""> @csrf
                      <div class="input-group">
                        <input type="search" name="filter" class="form-control rounded"
                               maxlength="15" placeholder="Search animals by name here..."/>
                        <input type="submit" value="Search" class="btn btn-outline-secondary" style="margin-left: 10px;"/>
                        <a href="{{strtok($_SERVER["REQUEST_URI"], '?')}}" class="btn btn-outline-info" style="margin-left: 10px;"/>Refresh</a>
                      </div>
                    </form>
                    <br>
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="id"/>
                            </form>
                          </th>
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="name"/>
                            </form>
                          </th>
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="date of birth"/>
                            </form>
                          </th>
                          <th>
                            <form action=""> @csrf
                              <input style="background:none;color:inherit;border:none;padding:0;font:inherit;cursor:pointer;outline:inherit;text-transform:uppercase;"
                                     type="submit" name="sort" value="date added"/>
                            </form>
                          </th>
                          <th>
                             ACTION
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($animals as $animal)
                        <tr>
                          <td> {{$animal->id}} </td>
                          <td> {{$animal->name }} </td>
                          <td> {{$animal->birth_date }} </td>
                          <td> {{$animal->created_at }} </td>
                          <td>
                            <a href="{{route('animals.show', ['animal' => $animal['id'] ] )}}" class="btn btn-primary">
                              View
                            </a>
                            @if (Gate::allows('isadmin'))
                            <a href="{{ route('animals.edit', ['animal' => $animal['id']]) }}" class="btn btn-warning">Edit</a>
                            @endif
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
