@extends('layout.layout')
@section('content')
<div class="row">
  <div class="col-md-12">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Gender</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td><a href="/users/{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</a></td>
            <td>{{$user->email}}</td>
            <td>{{$user->gender}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
