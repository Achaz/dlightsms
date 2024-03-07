@extends('../layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">

<div class="intro-y box">
<div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Add List Here:
            </h2>
        </div>
<div class="p-5" id="vertical-form">           
    <div class="preview">
        @include('../layouts.partials.errors')              
        <div class="form">
            <form class="cmxform form-horizontal tasi-form" id="signupForm" action="/addlistsaction" method="POST">
            @csrf
                <input type="hidden" name="t" value="">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                </div>
                <div class="mt-3">
                    <label for="firstname">List Name:</label>
                    <div class="col-md-6">
                        <input class="input w-full rounded-full border mt-2" id="list_name" name="list_name" type="text" value=""/>                             
                    </div>
                </div>
                <div class="mt-3">
                    <label for="firstname">Description:</label>
                    <div class="col-md-6">
                        <input class="input w-full rounded-full border mt-2" id="desc" name="desc" type="text" value=""/>
                    </div>
                </div>
                <div class="mt-3">
                    <label for="firstname">Owner:</label>
                    <div class="col-md-6">
                        <input class="input w-full rounded-full border mt-2" id="{{ $names }}" name="owner" type="text" value="{{ $names }}" readonly/>               
                    </div>
                </div>   
                <div class="mt-3">
                    <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit">Submit</button>
                    <a href="{{ route('lists.managelist') }}" class="btn btn-default"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300">Back</button></a>
                </div>              
            </form>           
          </div>
        </div>
      </div>
    </div>
@endsection