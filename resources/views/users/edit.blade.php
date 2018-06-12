@extends('layout.layout')
@section('content')
<h1>Edit User</h1>
<hr>
<form action="{{url('users', [$user->id])}}" method="POST">
<input type="hidden" name="_method" value="PUT">
{{ csrf_field() }}
<div class="form-group">
<label for="gender">Gender</label>
<input type="text" value="{{$user->gender}}" class="form-control" id="userGender"  name="gender" >
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
