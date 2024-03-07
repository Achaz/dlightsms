@extends('layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
	<div class="intro-y box">
          <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                   <h2 class="font-medium text-base mr-auto">    
                       Update role
                    </h2>
            </div>
                    <div class="intro-y box p-5">
                        Edit role and manage permissions.
                    </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="intro-y box p-5">
                        <form method="POST" action="{{ route('roles.update', $role->id) }}">
                            @method('patch')
                            @csrf
                            <div class="mt-3"> 
                              <div class="col-lg-3">
                                <label>Name</label>
                                <input value="{{ $role->name }}" type="text" class="input w-full rounded-full border mt-2" name="name" placeholder="Name" required>
                              </div>
                            </div>
                            <div class="mt-3"> 
                                <div class="col-lg-3">
                                    <label>Assign Permissions</label>
                                </div>
                            </div>
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200" id="head-options-table">
		                   <div class="preview">
                              <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <th class="bg-gray-200 text-gray-700"><input type="checkbox" name="all_permission"></th>
                                    <th class="bg-gray-200 text-gray-700">Name</th>
                                    <th class="bg-gray-200 text-gray-700">Guard</th>
                                </thead>

                                @foreach ($permission as $permission)
                                    <tr>
                                        <td class="border-b dark:border-dark-5">
                                            <input type="checkbox" name="permission[{{ $permission->name }}]"
                                                value="{{ $permission->name }}" class='permission'
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                        </td>
                                        <td class="border-b dark:border-dark-5">{{ $permission->name }}</td>
                                        <td class="border-b dark:border-dark-5">{{ $permission->guard_name }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            </div>
                            </div>
                            </div>
                            <div class="text-left mt-5">
                              <button type="submit" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white">Save</button>
                              <a href="{{ route('roles.index') }}" class="btn btn-default"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300">Back</button></a>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            @endsection

            @section('scripts')
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('[name="all_permission"]').on('click', function() {

                            if ($(this).is(':checked')) {
                                $.each($('.permission'), function() {
                                    $(this).prop('checked', true);
                                });
                            } else {
                                $.each($('.permission'), function() {
                                    $(this).prop('checked', false);
                                });
                            }

                        });
                    });
                </script>
            @endsection
