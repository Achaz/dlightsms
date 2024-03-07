@extends('../layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="p-5" id="vertical-form">
            <div class="preview">
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
                <form method="post" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    <div class="mt-3">
                        <label>Name</label>
                        <input value="{{ $user->name }}" type="text" class="input w-full border mt-2" name="name"
                            placeholder="Name" required>

                        @if ($errors->has('name'))
                            <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <label>Email</label>
                        <input value="{{ $user->email }}" type="email" class="input w-full border mt-2" name="email"
                            placeholder="Email address" required>
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <label>Username</label>
                        <input value="{{ $user->username }}" type="text" class="input w-full border mt-2" name="username"
                            placeholder="Username" required>
                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <label>Role</label>
                       
                        <select class="tail-select w-full" name="roles" required>
                            <option value="">Select role</option>
                           
                            @foreach ($roles as $role)
                           
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->name, $userRole) ? 'selected' : '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="button w-24 bg-theme-1 text-white">update</button>
                        <a href="{{ route('users.index') }}"><button class="button w-24 border dark:border-dark-5 text-gray-700 dark:text-gray-300 mr-1" type="button">Cancel</button></a>
                    </div>
                </form>
           </div>
        </div>
    </div>
</div>
 @endsection
