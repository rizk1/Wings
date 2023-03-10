@extends('layouts.app')

@section('content')
@php
    // dd(Session::get('error'));
@endphp
<div class="d-flex justify-content-center pt-5">
    <div class="w-25 p-4 border rounded">

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $message)
                <li>{{$message}}</li>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>{{ $message }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST">
            @csrf
            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="formUsername">User</label>
                <input type="text" name="user" id="formUsername" class="form-control" />
            </div>
        
            <!-- Password input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="formPassword">Password</label>
                <input type="password" name="password" id="formPassword" class="form-control" />
            </div>
        
            <!-- Submit button -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
              </div>
        
            <!-- Register buttons -->
            <div class="text-center">
                <p>Not a member? <a href="/register">Register</a></p>
            </div>
        </form>
    </div>
</div>
@endsection