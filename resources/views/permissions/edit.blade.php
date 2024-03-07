@extends('layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box"> 
         <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                    Edit permission 
            </h2>
         </div>      
         <div class="intro-y box p-5">
            <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
                @method('patch')
                @csrf
                <div class="mt-3">
                    <label>Name</label>
                    <input value="{{ $permission->name }}" type="text" class="input w-full rounded-full border mt-2" name="name" placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="text-right mt-5">
                    <button type="submit" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white">Save</button>
                    <a href="{{ route('permissions.index') }}"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300">Back</button></a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection