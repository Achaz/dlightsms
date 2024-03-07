@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">      
                Send Bulk SMS:
            </h2>
        </div>
        <div class="intro-y box p-5">
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form name="theform" class="cmxform form-horizontal tasi-form" id="signupForm" action="/bulksmsaction" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="t" value="bulksms"/>
            <input type="hidden" name="id" value="{{ $names }}"/>
            <div class="mt-3">
                <label >Sender ID:</label>
                <div class="col-lg-3">
                    <input class="input w-full rounded-full border mt-2" placeholder="8177" id="senderid" name="senderid" type="text" value=""/>
                </div>
            </div>
            <div class="mt-3">
                <label>Message</label>
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
                <div class="mt-2">
                    <select name="title" id="title" class="tail-select w-full">
                        <option value="">(None)--Select</option>
                        <option value="Hon">Hon</option>
                        <option value="Dear">Dear</option>
                        <option value="Hello">Hello</option>
                    </select>
                </div>
            </div>											  
            <div class="mt-3">
                <textarea class="input w-full border mt-2" name="message"  cols="21" rows="5"  ONKEYUP="wordcount(this.value, this.form);"></textarea>
            </div>                 
            <div class="mt-3">
                <label>Chars(320)max</label>
                <div class="col-lg-1">
                    <input class="input w-full rounded-full border mt-2" id="num_words" name="num_words" value="0" type="text" disabled />
                </div>
            </div>
            <div class="mt-3">
                <label>Select List:</label>
                <div class="mt-2">
                    <select name="list_id" class="tail-select w-full" >
                        <option value=0>Select List</option>
                        @foreach($lists as $list)
                        <option value="{{ $list->id }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <label>Select Network:</label>
                <div class="mt-2">
                    <select name="network" class="tail-select w-full">  
                        @foreach($networks as $network)
                        <option value={{ $network->prefix }} >{{ $network->name }}</option> 
                        @endforeach    
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-right mt-5">
                    <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit" onClick='return confirm("Your back again! Confirm before you send this message.");'>Send</button>
                    
                </div>
            </div>                        
        </form>
      </div>       
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