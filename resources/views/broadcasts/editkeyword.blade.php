@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">      
                Edit Keyword:
            </h2>
        </div>
        <div class="intro-y box p-5">
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form name="theform" class="cmxform form-horizontal tasi-form" id="signupForm" action="{{ route('update.keyword', $keyword) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mt-3">
                <label >Keyword:</label>
                <div class="col-lg-3">
                    <input class="input w-full rounded-full border mt-2" placeholder="Keyword" id="keywd" name="keywd" type="text" value="{{ $keyword->keywd }}"/>
                </div>
            </div>
            <div class="mt-3">
                <label >Keyword Alias:</label>
                <div class="col-lg-3">
                    <input class="input w-full rounded-full border mt-2" placeholder="Keyword Alias" id="keywd_alias" name="keywd_alias" type="text" value="{{ $keyword->keywd_alias }}"/>
                </div>
            </div>
            <div class="mt-3">
                <label >Response:</label>
                <div class="col-lg-3">
                    <textarea class="input w-full border mt-2" id="response" name="response" value="{{ $keyword->response }}"  cols="21" rows="5"></textarea>
                </div>
            </div>          
            <div class="mt-3">
                <div class="text-right mt-5">
                    <a href="{{ route('broadcasts.keywords') }}" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-9 text-white">Back</a>
                    <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit">Edit</button>                    
                </div>
            </div>                        
        </form>
      </div>       
    </div>
</div>
@endsection