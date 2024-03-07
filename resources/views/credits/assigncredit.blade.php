@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">      
                Assign Credits:
            </h2>
        </div>
        <div class="intro-y box p-5">
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form class="cmxform form-horizontal tasi-form" id="signupForm" action="/assigncreditaction" method="POST">
            @csrf
            <input type="hidden" name="t" value="">
            <input type="hidden" name="id" value="">
            
            <div class="mt-3">
                <label>Select Account:</label>
                <div class="mt-2">
                    <select name="user_id" class="tail-select w-full">
                        <option value=0>Select User</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
            <label>Units:</label>
            <div class="col-lg-3">
                <input class="input w-full rounded-full border mt-2" id="units" name="units" type="text" value=""/>		  
            </div>
        </div>
        <div class="mt-3">
            <label for="firstname" class="control-label col-lg-2">SMS Rate:</label>
            <div class="col-lg-3">
                <input class="input w-full rounded-full border mt-2" id="smscost" name="smscost" type="text" value=""/>	  
            </div>
        </div>
        <div class="mt-3">
            <label for="firstname" class="control-label col-lg-2">Credited By:</label>
            <div class="col-lg-3">
                <input class="input w-full rounded-full border mt-2" id="owner" name="owner" type="text" value="{{ $names }}" disabled/>			  
            </div>
        </div>                      
        <div class="mt-3">
        <div class="text-right mt-5">
            <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit">Assign</button>
            <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-12 text-white" type="reset">Reset</button>
            <button class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300" type="button" onClick='window.location.href="{{ route('credits.index')}}"'>Cancel</button>
        </div>
        </div>
        </div>
        </form>
                              
        </div>
      </div>
    </div>
@endsection