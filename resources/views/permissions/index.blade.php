@extends('layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
	<div class="intro-y box">
		<div class="mt-2">
            @include('layouts.partials.messages')
        </div>
		<div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
			<h2>Permissions</h2>
		</div>
		<div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
			<a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm float-left">
				<button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white">Add</button>
			</a>
		</div>
		<div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200" id="head-options-table">
			<div class="preview">
				<div class="overflow-x-auto">
					<table class="table">
						<thead>
							<tr class="bg-gray-200 text-gray-700">
								<th class="whitespace-no-wrap">Name</th>
								<th class="whitespace-no-wrap">Guard</th>
								<th class="whitespace-no-wrap" colspan="2"></th>
							</tr>
						</thead>
						<tbody>
                @foreach($permissions as $permission)
                    
							<tr>
								<td class="whitespace-no-wrap">{{ $permission->name }}</td>
								<td class="whitespace-no-wrap">{{ $permission->guard_name }}</td>
								<td class="whitespace-no-wrap">
									<a class="flex items-center mr-3" href="{{ route('permissions.edit', $permission->id) }}">
										<i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit 
									</a>
								</td>
								<td class="whitespace-no-wrap" scope="row">
									<div class="flex justify-center items-center">

										<a class="flex items-center text-theme-6" href="{{ route('permissions.destroy', $permission->id) }}">
											<i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete 
										</a>
									</div>
								</td>
							</tr>
                @endforeach
            
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
