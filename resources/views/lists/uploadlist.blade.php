@extends('../layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">      
                Upload Numbers to List: {{$name}}
            </h2>
        </div>
        <div class="intro-y box p-5">
        <div class="preview">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
        </div>
        @endif
            <form method="post" action="/uploadnumbers" enctype="multipart/form-data"> 
                @csrf             
                    <input type="hidden" name="list_id" value="{{ $id }}">
                    <input type="hidden" name="name" value="{{ $name }}">                           
                    <div class="file-upload-wrapper">
                        <input type="file" id="customFile" name="csv" accept=".csv" class="file-upload" data-max-file-size="2M" />
                    </div>
                    <div class="mt-3">
                    <div class="text-right mt-5">
                        <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit">Upload</button>
                        <a href="{{ route('lists.managelist') }}" class="btn btn-default"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300">Back</button></a>
                    </div>
                </div>
            </form>
        </div>      
      </div>
   </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css">
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
<script>
    $('.file-upload').file_upload();
</script>
@endsection