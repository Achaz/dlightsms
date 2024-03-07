@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                    <h2 class="font-medium text-base mr-auto">      
                        Schedule Messages:
                    </h2>
                </div>
                <div class="intro-y box p-5">
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <form name="theform" class="cmxform form-horizontal tasi-form" id="signupForm" action="/schedulemessageaction" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="t" value="bulksms"/>
                    <input type="hidden" name="id" value="{{ $names }}"/>
                    <div class="mt-3">
                        <label for="firstname" class="control-label col-lg-2">Sender ID:</label>
                        <div class="col-lg-3">
                            <input class="input w-full rounded-full border mt-2" placeholder="8177" id="firstname" name="senderid" type="text" value=""/>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="date" class="control-label col-lg-2">Scheduled At:</label>
                        <div class="col-lg-3">
                            <!--<input class="form-control" id="scheduled_date" name="date" type="date" value=""/>-->
                            <input type="datetime-local" class="input w-full rounded-full border mt-2" name="scheduled_date">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="lastname" class="control-label col-lg-2">Message</label>
                        <div class="col-lg-5">
                            <select name="saved_msg" class="tail-select w-full" data-placeholder="Select Message" onchange="document.theform.message.value=this.value">
                                <option value="">Select Message</option>
                                @foreach($messages as $message)
                                <option value="{{$message->msg }}">{{ $message->msg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Title:</label>
                        <div class="col-lg-5">
                            <select name="title" id="title" class="tail-select w-full">
                                <option value="">(None)--Select</option>
                                <option value="Hon">Hon</option>
                                <option value="Dear">Dear</option>
                                <option value="Hello">Hello</option>
                            </select>
                        </div>
                    </div>											  
                    <div class="mt-3">
                        <textarea class="input w-full border mt-2" name="message"  cols="21" rows="5" ONKEYUP="wordcount(this.value, this.form);"></textarea>
                    </div>                 
                    <div class="mt-3">
                        <label for="lastname" class="control-label col-lg-2">Chars(320)max</label>
                        <div class="col-lg-1">
                            <input class="input w-full border mt-2" id="num_words" name="num_words" value="0" type="text" disabled />
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="lastname" class="control-label col-lg-2">Select List:</label>
                        <div class="col-lg-1">
                            <select name="list_id" class="tail-select w-full" cols="10">
                                <option value=0>Select List</option>
                                @foreach($lists as $list)
                                <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label>Select Network:</label>
                        <div class="col-sm-4">
                            <select name="network" class="tail-select w-full" cols="10">  
                                @foreach($networks as $network)
                                <option value={{ $network->prefix }} >{{ $network->name }}</option> 
                                @endforeach    
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-right mt-5">
                            <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit" onClick='return confirm("Your back again! Confirm before you send this message.");'>Schedule</button>
                            
                        </div>
                    </div>                        
                </form>
            </div>    
        </div>
      </div>
@endsection
@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
<script src ="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> 
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