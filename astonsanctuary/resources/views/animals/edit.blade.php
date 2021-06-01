@extends('layouts.app')

@guest
@else
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8 ">
      <div class="card">
        <div class="card-header">Edit animal information</div>
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div><br />
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div>
        <br />
        @endif
        <div class="card-body">
          <form class="form-horizontal" method="POST" action="{{ route('animals.update',
            ['animal' => $animal['id']]) }}" enctype="multipart/form-data" >
            @method('PATCH')
            @csrf
            <table class="table">
              <tr> <th>Name </th> <td><input type="text" name="name" placeholder="Name" maxlength="30" value="{{$animal->name}}" required/></td></tr>
              <tr> <th>Date of Birth </th> <td><input type="date" name="birth_date" value="{{$animal->birth_date}}" required/></td></tr>
              <tr> <th>Description </th> <td><textarea rows="4" cols="50" name="description" maxlength="256" placeholder="Description of the animal" required>{{$animal->description}}</textarea></td></tr>
              <tr> <th>Image</th><td><input type="file" name="image" placeholder="Image file"/></td></tr>
            </table>
            <div class="col-md-6 col-md-offset-4">
              <a href="{{url()->previous()}}" class="btn btn-primary" role="button">Back</a>
              <input type="submit" class="btn btn-success" />
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
@endguest
