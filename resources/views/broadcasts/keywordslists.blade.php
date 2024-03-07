@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
     <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                View Keywords:
            </h2>
            <a class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-9 text-white" href="{{ route('broadcasts.keyword.create') }}">Create</a>
        </div>
        <div class="p-5" id="responsive-table">
            <div class="preview">
                  @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                  @endif
                  <div class="overflow-x-auto">
                  
                    <div class="overflow-x-auto">
                    <table class="table">
                    <thead>                  
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="whitespace-no-wrap">#</th>
                            <th class="whitespace-no-wrap">Keyword</th>
                            <th class="whitespace-no-wrap">Keywd Alias</th>
                            <th class="whitespace-no-wrap">Response</th>
                            <th class="whitespace-no-wrap">Created by</th>
                            <th class="whitespace-no-wrap">Created at</th>
                            <th class="whitespace-no-wrap" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $sno = 0;
                    @endphp
                    @foreach($keywords as $keyword)                 
                        <tr>
                            <td class="border-b dark:border-dark-5">{{ ++$sno }}</td>
                            <td class="border-b dark:border-dark-5">{{ $keyword['keywd']  }}</td>
                            <td class="border-b dark:border-dark-5">{{ $keyword['keywd_alias'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $keyword['response'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $keyword['created_by'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $keyword['created_at'] }}</td>
                            <td class="border-b dark:border-dark-5"><a href="{{ route('edit.keyword',$keyword) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-7 text-white">Edit</button></a>
                            <a href="{{ route('delete.keyword',$keyword->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-6 text-white">Delete</button></a></td>
                        </tr>
                     @endforeach
                  </tbody>
                 </table>
                 {{  $keywords->links() }}
                </div>
             </div>
          </div>
       </div>          
   </div>
</div>
@endsection