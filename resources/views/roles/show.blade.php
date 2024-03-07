@extends('layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">      
                   {{ ucfirst($role->name) }} Roles
                </h2>
            </div>
            <div class="intro-y box p-5">

                <h3>Assigned permissions</h3>

                <table class="table">
                    <thead>
                        <th class="bg-gray-200 text-gray-700">Name</th>
                        <th class="bg-gray-200 text-gray-700">Guard</th>
                    </thead>

                    @foreach ($rolePermissions as $permission)
                        <tr>
                            <td class="border-b dark:border-dark-5">{{ $permission->name }}</td>
                            <td class="border-b dark:border-dark-5">{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="mt-4">
                    <a href="{{ route('roles.edit', $role->id) }}" ><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit">Edit</button></a>
                    <a href="{{ route('roles.index') }}" ><button class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300" type="button">Back</button></a>
                </div>
            </div>             
    </div>
</div>
    @endsection
