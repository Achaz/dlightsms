@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
  <div class="intro-y box">
    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
        <h2 class="font-medium text-base mr-auto">
            Manage Contacts Here:
        </h2>
        
    </div>
    <div class="p-5" id="head-options-table">
        <div class="preview">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="whitespace-no-wrap">#</th>
                            <th class="whitespace-no-wrap">Phone Number</th>
                            <th class="whitespace-no-wrap">First Name</th>
                            <th class="whitespace-no-wrap">Last Name</th>
                            <th class="whitespace-no-wrap">&nbsp;</th>
                            <th class="whitespace-no-wrap">&nbsp;</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ($numbers->count() == 0)
                        <tr>
                            <td colspan="5">No Contacts to display.</td>
                        </tr>
                        @endif
                        @php
                        $sno = 0;
                        @endphp
                        @foreach($numbers as $number)
                        <tr>
                            <td class="border-b dark:border-dark-5">{{ ++$sno }}</td>
                            <td class="border-b dark:border-dark-5">{{ $number->msisdn }}</td>
                            <td class="border-b dark:border-dark-5">{{ $number->field1 }}</td>
                            <td class="border-b dark:border-dark-5">{{ $number->field2 }}</td>
                            <td class="border-b dark:border-dark-5"><a data-id={{$number->id}} href="#"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-9 text-white">Edit</button></a></td>
                            <td class="border-b dark:border-dark-5"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-6 text-white" data-toggle="modal" data-target="modal-{{$number->id}}" onclick="$('#modal-{{$number->id}}').modal('show')">Delete</button></td>         
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{($pagination->links())}} {{--Pagination Links--}}
            </div>
        </div>
        
    </div>
  </div>
</div>
  <!-- Modal -->
  @foreach($numbers as $number)
  <div class="modal fade " id="modal-{{$number->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <form action="/deletecontact" method="POST">
      @csrf 
      <input type="hidden" name="num_id" value="{{ $number->id }}">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header modal-delete">
                  <h4 class="modal-title">Delete Contact</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </div>
              <div class="modal-body">
                  Do you want to delete this contact? It will be removed from all lists and the database. Note that this action is irreversible.
              </div>
              <div class="modal-footer">
                  <button data-bs-dismiss="modal" class="btn btn-primary" type="button">Close</button>
                  <button class="btn btn-danger" type="submit">Delete</button>
              </div>
          </div>
      </div>
    </form>
  </div>
  @endforeach
   <!-- end of modal -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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