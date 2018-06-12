@extends('layout.layout')
@section('content')
<h1>Add New User</h1>
<hr>
<form action="/users" method="post">
  {{ csrf_field() }}
  <div class="form-group">
    <label for="first_name">First Name</label>
    <input type="text" class="form-control" id="userFirstName"  name="first_name">
  </div>
  <div class="form-group">
    <label for="last_name">Last Name</label>
    <input type="text" class="form-control" id="userLastName"  name="last_name">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="userEmail"  name="email">
  </div>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
