@if(Session::has('success') || isset($success))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(Session::has('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@elseif(Session::has('info'))
    <div class="alert alert-info">{{ Session::get('info') }}</div>
@endif

@if($errors->count() > 0)

@php
    $error_list = '';
    foreach ($errors->all() as $error) {
        $error_list .= $error.'<br>';
    }
@endphp
    @php
        $message = $error_list;
        $type = 'danger';
    @endphp
    <div class="alert alert-{{ $type }}">{!! $message !!}</div>
@endif 