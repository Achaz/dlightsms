@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
     <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Lists numbers:
            </h2>
        </div>
        <div class="p-5" id="responsive-table">
            <div class="preview">

                @include('layouts.partials.errors')

        
                 <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="whitespace-no-wrap">&nbsp;</th>
                            <th class="whitespace-no-wrap">No</th>   
                            <th class="whitespace-no-wrap">#Name</th>
                            <th class="whitespace-no-wrap">#Account</th>
                            <th class="whitespace-no-wrap">#Amount</th>
                            <th class="whitespace-no-wrap">#Reward</th>
                            <th class="whitespace-no-wrap">#Token</th>
                            <th class="whitespace-no-wrap">Group</th>
                            <th class="whitespace-no-wrap">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $list)
                            <tr>
                                <td class="border-b dark:border-dark-5">
                                <input type="checkbox">
                                </td>
                                <td class="border-b dark:border-dark-5">{{ $list->msisdn }} </td>
                                <td class="border-b dark:border-dark-5">{{ $list->string_field1 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $list->string_field2 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $list->string_field3 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $list->string_field4 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $list->string_field5 }}</td>
                                <td class="border-b dark:border-dark-5">{{ $list->list_name }}</td>
                                <td class="border-b dark:border-dark-5"><a href="{{ route('delete.number',$list->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-6 text-white">Delete</button></a></td>
                            </tr>
                         @endforeach  
                        </tbody> 
                        </table>
                        {{ $lists->links() }} 
                        <a href="{{ route('lists.managelist') }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300" type="button">Back</button></a>
                    
              </div>
            </div>
          </div>
        </div>
      </div>
        
@endsection

@section('styles')
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css"/>
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


@endsection