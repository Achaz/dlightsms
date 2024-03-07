@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">      
              Bulk SMS Report Summary:
            </h2>
        </div>
        <div class="intro-y box p-5">            
              <form action="/smsreports" method="GET">
                  <div class="grid grid-cols-12 gap-2">      
                  <label>From:</label>
                  <input type="date" class="input w-full rounded-full border mt-2 col-span-4" name="start_date_summary">
                  <label>To:</label>
                  <input type="date" class="input w-full rounded-full border mt-2 col-span-4" name="end_date_summary">
                  <button class="button w-24 rounded-full mr-1 mb-2 bg-theme-18 text-theme-9" type="submit">Search</button>
                  </div>
              </form>
              <div class="p-5" id="responsive-table">
              <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <!--<span data-href="/export-csv" id="export" class="bi bi-link"  onclick ="exportTasks (event.target);">Export CSV</span>-->
                <a href="/export-csv" ><button id="export"  onclick ="exportTasks (event.target);" class="button w-24 rounded-full mr-1 mb-2 bg-gray-200 text-gray-600">Export CSV </button></a>
            </div>
              <table class="table">
              <thead>                  
                  <tr class="bg-gray-200 text-gray-700">
                      <th class="whitespace-no-wrap">#</th>
                      <th class="whitespace-no-wrap">List</th>
                      <th class="whitespace-no-wrap">Total SMS</th>
                      <th class="whitespace-no-wrap">Time Stamp</th>
                  </tr>
              </thead>
              <tbody>
              @php
              $sno = 0;
              @endphp
              @foreach($smsreports_summary as $smsreport_summary)                 
                  <tr>
                      <td class="border-b dark:border-dark-5">{{ ++$sno }}</td>
                      <td class="border-b dark:border-dark-5">{{ $smsreport_summary->name ?? 'name missing' }}</td>
                      <td class="border-b dark:border-dark-5">{{ $smsreport_summary->total_sms }}</td>
                      <td class="border-b dark:border-dark-5">{{ $smsreport_summary->day }}</td>
                  </tr>
                @endforeach
            </tbody>
            </table>
            {{ $smsreports_summary->links() }}
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
<script>
   function exportTasks(_this) {
      let _url = $(_this).data('href');
      window.location.href = _url;
   }
</script>
@endsection