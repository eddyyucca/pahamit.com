@extends('errors.layout')

@section('title', 'Terjadi Kesalahan')
@section('code', '500')
@section('heading', 'Ada kendala di server.')
@section('message', 'Maaf, sistem belum bisa memproses permintaan ini. Tim pahamIT perlu memeriksa log aplikasi.')
@section('hint', 'Coba beberapa saat lagi. Jika masih terjadi, kirim detail halaman yang Anda buka lewat WhatsApp.')
