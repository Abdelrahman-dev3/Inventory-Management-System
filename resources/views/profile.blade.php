@extends('layouts.main')

@section('title' , 'Profile')

@section('content')
<div class="container">
    <div class="card mx-auto" style="max-width: 80%;">
        <div class="card-body text-center">
            <img src="{{ asset('uploads/users/' . $user->user_image) }}" alt="Profile Picture" class="rounded-circle mb-3" width="150" height="150">
            <h4 class="card-title">{{ $user->user_name }}</h4>
            <p class="text-muted mb-1"> {{ $user->email  }}</p>
            <a href="{{ route('profile_edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
        </div>
    </div>
</div>
@endsection