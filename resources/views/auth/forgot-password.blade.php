@extends('auth.layout', ['title' => 'Lupa Password'])

@section('content')
    <h1>Lupa Password</h1>
    <p class="subtitle">Masukkan email admin. Link reset akan dikirim memakai konfigurasi mail aplikasi.</p>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <form method="post" action="{{ route('password.email') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button class="btn" type="submit">Kirim Link Reset</button>
    </form>

    <a class="back" href="{{ route('login') }}">Kembali ke login</a>
@endsection
