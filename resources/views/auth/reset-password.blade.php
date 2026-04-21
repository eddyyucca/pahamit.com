@extends('auth.layout', ['title' => 'Reset Password'])

@section('content')
    <h1>Reset Password</h1>
    <p class="subtitle">Buat password baru untuk akun admin Pahamit.com.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', request('email')) }}" autocomplete="email" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password">Password Baru</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
        </div>

        <button class="btn" type="submit">Simpan Password Baru</button>
    </form>
@endsection
