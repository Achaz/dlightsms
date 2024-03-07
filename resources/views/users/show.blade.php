@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="p-5" id="vertical-form">
            <div class="preview">
                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                       <h1>User Details</h1>
                    </div>
                    <div class="mt-3">
                        <div> Name: {{ $user->name }} </div>
                        <div> Email: {{ $user->email }} </div>
                        <div> Username: {{ $user->username }} </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user->id) }}"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white">Edit</button></a> 
                        <a href="{{ route('users.index') }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300" type="button">Back</button></a> 
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
