@extends('../layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
     <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Manage Lists Here:
            </h2>
        </div>
        <div class="p-5" id="responsive-table">
            <div class="preview">
                @if($status)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $status }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
              
                @if($errors->any())
                  @foreach($errors->all() as $error)
                  <div class="alert alert-danger" alert-dismissible fade show" role="alert"> 

                  {{ $error }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>      
                  
                  </div>
                  @endforeach
                @endif
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="whitespace-no-wrap">#</th>
                                <th class="whitespace-no-wrap">Name</th>
                                <th class="whitespace-no-wrap">Description</th>
                                <th class="whitespace-no-wrap">Owner</th>
                                <th class="whitespace-no-wrap">Date Created</th>
                                <th class="whitespace-no-wrap">&nbsp;</th>
                                <th class="whitespace-no-wrap">&nbsp;</th>
                                <th class="whitespace-no-wrap">&nbsp;</th>              
                                <th class="whitespace-no-wrap">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                          @php
                          $sno = 0;
                          @endphp
                          @foreach($lists as $list)
                          <tr>
                              <td class="border-b dark:border-dark-5">{{ ++$sno }}</td>
                              <td class="border-b dark:border-dark-5">{{$list->name}}</td>
                              <td class="border-b dark:border-dark-5">{{$list->description}}</td>
                              <td class="border-b dark:border-dark-5">{{$list->created_by}}</td>
                              <td class="border-b dark:border-dark-5">{{$list->t_stamp}}</td>
                              <td class="border-b dark:border-dark-5"><a href="{{ route('lists.viewnums',$list->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white">View Nos</button></a></td>
                              <td class="border-b dark:border-dark-5"><a href="{{ route('delete.list',$list->id) }}"><button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-6 text-white">Delete</button></a></td>
                              <td class="border-b dark:border-dark-5"><a href="{{ route('lists.uploadlist', ["id"=>$list->id,"name"=>$list->name]) }}"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-9 text-white">Upload</button></a></td>      
                              <td class="border-b dark:border-dark-5"><button type="button" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-12 text-white" data-toggle="model" data-target="modal2-{{$list->id}}" onclick="$('#modal2-{{$list->id}}').modal('show')">Edit</button></td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                    {{ $lists->links() }}                  
                </div>
            </div> 
          </div>
        </div>
      </div>
    </div>
   </div>
  </div>
</div>
@endsection

@section('styles')
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/> -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"/>-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css"/>
@endsection

@section('scripts')
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
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