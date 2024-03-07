@extends('../layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
    <div class="intro-y box">

            

            <div class="mt-2">
                @include('layouts.partials.messages')
            </div>
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">Users</h2>
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                  
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200" id="head-options-table">        
                <div class="preview">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="whitespace-no-wrap">#</th>
                                    <th class="whitespace-no-wrap">Name</th>
                                    <th class="whitespace-no-wrap">Email</th>
                                    <th class="whitespace-no-wrap" >Username</th>
                                    <th class="whitespace-no-wrap">Roles</th>
                                    <th class="whitespace-no-wrap" colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th class="whitespace-no-wrap" scope="row">{{ $user->id }}</th>
                                        <td class="whitespace-no-wrap">{{ $user->name }}</td>
                                        <td class="whitespace-no-wrap">{{ $user->email }}</td>
                                        <td class="whitespace-no-wrap">{{ $user->username }}</td>
                                        <td class="whitespace-no-wrap">
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="whitespace-no-wrap"><a href="{{ route('users.show', $user->id) }}"
                                                class="btn btn-warning btn-sm"><div class="flex items-center justify-center text-theme-9"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Show </div></a></td>
                                        <td class="whitespace-no-wrap"><a class="flex items-center mr-3" href="{{ route('users.edit', $user->id) }}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a></td>
                                                
                                        <td class="whitespace-no-wrap">
                                          <a class="flex items-center text-theme-6" href="{{ route('users.destroy', $user->id) }}" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex">
                            {!! $users->links() !!}
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div> 
    @endsection
