@extends('layout.guest')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                   
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">


                        <form method="POST" action="{{ route('register.create') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="username" name="name" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                    id="nim" name="nim" value="{{ old('nim') }}" required>
                            </div>
                            @error('nim')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <!-- Password Input -->
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" required>
                            </div>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation" value="{{ old('password') }}" required>
                            </div>
                          
                            <!-- Remember Me Checkbox -->
                           

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
