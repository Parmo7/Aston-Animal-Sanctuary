<!-- inherite master template app.blade.php -->
@extends('layouts.app')

@guest
@else
<!-- define the content section -->
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 ">
      <div class="card">
        <div class="card-header">Add a new animal</div>
        <!-- display the errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul> @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> @endforeach
          </ul>
        </div><br /> @endif
        <!-- display the success status -->
        @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br /> @endif
        <!-- define the form -->
        <div class="card-body">
          <form class="form-horizontal" method="POST"
            action="{{url('animals') }}" enctype="multipart/form-data">
            @csrf
            <table class="table">
              <tr> <th>Name </th> <td><input type="text" name="name" placeholder="Name" maxlength="30" required/></td></tr>
              <tr> <th>Date of Birth </th> <td><input type="date" name="birth_date" required/></td></tr>
              <tr> <th>Description </th> <td><textarea rows="4" cols="50" name="description" maxlength="256" placeholder="Description of the animal" required></textarea></td></tr>
              <tr> <th>Image</th><td><input type="file" name="image" placeholder="Image file" required/></td></tr>
            </table>
            <div class="col-md-6 col-md-offset-4">
              <a href="{{url()->previous()}}" class="btn btn-primary" role="button">Back</a>
              <input type="reset" class="btn btn-secondary" />
              <input type="submit" class="btn btn-success" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@endguest
