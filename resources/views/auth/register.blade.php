@extends('../layouts.admin')

@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
<div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
     <h2 class="font-medium text-base mr-auto">      
       Add User:
     </h2>
    </div>
    <div class="p-5" id="vertical-form">
       <div class="preview">
            @if(Session::get('success'))
            <div class="alert alert-success">
                {{session::get('success')}}
            </div>
            @endif
            <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="mt-3">
                <label for="name" >Name</label>
                <div class="col-md-6">
                <input type="text" class="input w-full rounded-full border mt-2 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <label for="username" >Username</label>
                <div class="col-md-6">
                <input type="text" class="input w-full rounded-full border mt-2 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <label for="email" >Email Address</label>
                <div class="col-md-6">
                <input type="email" class="input w-full rounded-full border mt-2 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <label for="password" >Password</label>
                <div class="col-md-6">
                <input type="password" class="input w-full rounded-full border mt-2 mt-2 @error('password') is-invalid @enderror" id="password" name="password">
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="mt-3">
                <label for="password_confirmation">Confirm Password</label>
                <div class="col-md-6">
                <input type="password" class="input w-full rounded-full border mt-2" id="password_confirmation" name="password_confirmation">
                </div>
            </div>
            <div class="mt-3">
                <input type="submit" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" value="Register">
            </div>                  
          </form>
      </div>
    </div>     
</div>  
</div>            
@endsection