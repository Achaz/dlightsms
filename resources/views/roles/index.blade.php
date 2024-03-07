@extends('../layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
	<div class="intro-y box">
        <div class="mt-2">
            @include('../layouts.partials.messages')
        </div>
       
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
           <h2>Roles</h2>
        </div>
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white">Add role</button></a>
        </div>
        
        
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200" id="head-options-table">
			<div class="preview">
				<div class="overflow-x-auto">
        <table class="table">
          <tr class="bg-gray-200 text-gray-700">
             <th class="whitespace-no-wrap">No</th>
             <th class="whitespace-no-wrap">Name</th>
             <th class="whitespace-no-wrap" colspan="3">Action</th>
          </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td class="whitespace-no-wrap">{{ $role->id }}</td>
                <td class="whitespace-no-wrap">{{ $role->name }}</td>
                <td class="whitespace-no-wrap">
                    <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-9 text-white">Show</button></a>
                </td>
                <td class="whitespace-no-wrap">
                    <a  href="{{ route('roles.edit', $role->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-12 text-white">Edit</button></a>
                </td>
                <td class="whitespace-no-wrap">
                   <a  href="{{ route('roles.destroy', $role->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-6 text-white">Delete</button></a>      
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $roles->links() !!}
        </div>

        </div>
      
   
</div>
@endsection
