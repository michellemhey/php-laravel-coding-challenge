@extends('layout.layout')
@section('content')
<h1>Showing User: {{ $user->first_name }}</h1>
<div class="jumbotron text-center">
  <p>
    <strong>First Name:</strong> {{ $user->first_name }}<br>
    <strong>Last Name:</strong> {{ $user->last_name }}<br>
    <strong>Email:</strong> {{ $user->email }}<br>
    <strong>Gender:</strong> {{ $user->gender }}<br>
    <strong>Country:</strong> {{ $user->country }}
  </p>
</div>
@endsection
