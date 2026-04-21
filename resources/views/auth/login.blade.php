@extends('auth.layout', ['title' => 'Login Admin'])

@section('content')
    <h1>Login Dashboard</h1>
    <p class="subtitle">Masuk untuk mengelola berita, tutorial, jualan, dan media post Pahamit.com.</p>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <form method="post" action="{{ route('login.store') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="check-row">
            <label><input name="remember" type="checkbox" value="1"> Ingat saya</label>
            <a class="link" href="{{ route('password.request') }}">Lupa password?</a>
        </div>

        <button class="btn" type="submit">Masuk</button>
    </form>

    <a class="back" href="{{ route('home') }}">Kembali ke website</a>
@endsection
