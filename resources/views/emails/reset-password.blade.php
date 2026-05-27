@extends('layout.layout')
@section('title', 'Password Reset')
@section('content')

<h2>Password Reset Request</h2>

<p>You requested to reset your password.</p>

<p>
    Click the link below to reset your password:
</p>

<a href="{{ $url }}" style="padding:10px 15px; background:#3490dc; color:#fff; text-decoration:none;">
    Reset Password
</a>

{{-- <p>Or use this token manually:</p>
<strong>{{ $token }}</strong> --}}

<p>This link will expire in 15 minutes.</p>

@endsection