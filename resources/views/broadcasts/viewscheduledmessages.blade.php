@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
     <div class="intro-y box">
     <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                View Scheduled messages:
            </h2>
        </div>
        <div class="p-5" id="responsive-table">
            <div class="preview">
                  @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                  @endif
                  <div class="overflow-x-auto">
                  <form action="/viewscheduledmessages" method="GET">
                        
                        <div class="grid grid-cols-12 gap-2">
                            <!--<input type="date" class="form-control" name="start_date_summary">-->
                            <!--<input type="date" class="form-control" name="end_date_summary">-->
                            <label>From:</label>
                            <input type="datetime-local" class="input w-full rounded-full border mt-2 col-span-4" name="start_date_summary">
                            <label>To:</label>
                            <input type="datetime-local" class="input w-full rounded-full border mt-2 col-span-4" name="end_date_summary">
                            <button class="button w-24 rounded-full mr-1 mb-2 bg-theme-18 text-theme-9" type="submit">Search</button>
                        </div>
                    </form>
                    <div class="overflow-x-auto">
                    <table class="table">
                    <thead>                  
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="whitespace-no-wrap">#</th>
                            <th class="whitespace-no-wrap">Sender ID</th>
                            <th class="whitespace-no-wrap">Message</th>
                            <th class="whitespace-no-wrap">Scheduled at</th>
                            <th class="whitespace-no-wrap">Status</th>
                            <th class="whitespace-no-wrap">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $sno = 0;
                    @endphp
                    @foreach($scheduled_messages as $scheduled_message)                 
                        <tr>
                            <td class="border-b dark:border-dark-5">{{ ++$sno }}</td>
                            <td class="border-b dark:border-dark-5">{{ $scheduled_message['sender_id']  }}</td>
                            <td class="border-b dark:border-dark-5">{{ $scheduled_message['message'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $scheduled_message['due_datetime'] }}</td>
                            <td class="border-b dark:border-dark-5">{{ $scheduled_message['sent'] }}</td>
                            <td class="border-b dark:border-dark-5"><a href="{{ route('delete.message' , $scheduled_message['schedule_id']) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-6 text-white">Delete</button></a></td>
                        </tr>
                     @endforeach
                  </tbody>
                 </table>
                 {{  $scheduled_messages->links() }}
                </div>
             </div>
          </div>
       </div>          
   </div>
</div>
@endsection
@section('styles')
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">   
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
<script src ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
<script>
  $(document).ready(function() {
      var table = $('#example').DataTable( {
          lengthChange: false,
          buttons: [ 'excel', 'csv', ]
      } );
  
      table.buttons().container()
          .appendTo( '#example_wrapper .col-md-6:eq(0)' );
  } );
</script>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    config = {
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
    }
    flatpickr("input[type=datetime-local]", config);
</script>
@endpush
@endsection