@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-6 py-10">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-8 py-10">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 4l-5.5 5.5a2 2 0 11-.7-.7L15 11l4-4z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Reset Password</h1>
                    <p class="text-gray-500 mt-1">Masukkan email untuk mendapatkan link reset password</p>
                </div>
                
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-600 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-base"
                                placeholder="nama@contoh.com">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @if ($errors->has('email'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Kirim Link Reset Password
                        </button>
                    </div>
                </form>
                
                <div class="mt-8 text-center text-sm text-gray-500">
                    Ingat password Anda?
                    <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-500">
                        Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection