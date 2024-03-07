@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">

<div class="intro-y box">
  <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
     <h2 class="font-medium text-base mr-auto">      
       Send Single Message:
     </h2>
  </div>
    <!-- BEGIN: Form Layout -->
    <div class="intro-y box p-5">
    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <form  action="/singlesmsaction" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mt-3">      
            <label for="senderid">Phone:</label>
            <input type="text" id="firstname" value="" name="phone" class="input w-full rounded-full border mt-2" placeholder="For more numbers, separate using a comma">
        </div>
        <div class="mt-3">
            <label>Select Route (for testing purposes only):</label>
            <div class="mt-2">
                <select name="route_name" id="hiding-searchbox" data-placeholder="Select Route" class="tail-select w-full">
                    @foreach($routes as $route)
                    <option value="{{ $route->route_name }}"selected>{{ $route->description }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-3">        
            <label for="senderid">Sender ID:</label>
            <input id="senderid" name="senderid" value="" name="phone" class="input w-full rounded-full border mt-2" placeholder="8177">
       </div>
        <div class="mt-3">
            <label>Message:</label>
            <div class="mt-2">
               <textarea class="input w-full border mt-2" name="message" cols="21" rows="5"  ONKEYUP="wordcount(this.value, this.form);"></textarea>
            </div>
        </div>
        <div class="text-right mt-5">
            
            <button type="submit" class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" onClick='return confirm("Confirm before you send out the SMS");'>Send</button>
        </div>
    
    </form>
   </div>
    <!-- END: Form Layout -->
</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
      function deleteMsg(id) {
        bootbox.confirm({
           message: "<b>Are you sure you want to delete the SMS template?</b>",
           className: "large",
           closeButton: false,
           buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
              label: 'No',
              className: 'btn-danger'
            }
           },
           callback: function(result) {
            if (result) {
                $.ajax({
                     url: "broadcast.php",
                     data: "t=tmpsms&info=del&msg_id= "+id,
                     success: function(x) {
                       // console.log("This was a successful test");  
                       parent.location.href="broadcast.php?t=tmpsms";
                     }
                });
               // console.log("This was a successful test");
            } else {
                console.log("Tests are failing");
            }
          }
        });
      }
</script>
<script language="javascript">
   function wordcount(smstemp, frm){
        frm.num_words.value=smstemp.length;
         if (frm.num_words.value > 160)
         {
           alert("Reduce on number of chars");
         }
   }
   </script>
@endsection