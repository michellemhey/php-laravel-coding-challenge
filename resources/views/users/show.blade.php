@extends('layout.layout')
 
@section('content')
            <h1>Showing User {{ $user->first_name }}</h1>
 
    <div class="jumbotron text-center">
        <p>
            <strong>First Name:</strong> {{ $user->first_name }}<br>
            <strong>Last Name:</strong> {{ $user->last_name }}<br>
            <strong>Email:</strong> {{ $user->email }}
        </p>
    </div>
@endsection