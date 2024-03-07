@extends('layouts.admin')
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box">
        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">      
                Create SMS Templates here:
            </h2>
        </div>
        <div class="intro-y box p-5">
              @if(session('status'))
                  <div class="alert alert-success">
                      {{ session('status') }}
                  </div>
                @endif
              <form class="cmxform form-horizontal tasi-form" id="signupForm" action="/smstemplatesaction" method="post">
              @csrf
              <div class="mt-3">
                      <label>Select Account:</label>
                      <div class="mt-2">
                          <select class="tail-select w-full"  name="user_id">
                              <option value=0>Select Account</option>
                              @foreach($accounts as $account)
                                  <option value="{{$account->staff_id}}">{{$account->username}}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
                  <div class="mt-3">
                      <label>SMS Template:</label>
                      <div class="col-lg-5">
                          <textarea class="input w-full border mt-2" name="smstemp" cols="21" rows="5" ONKEYUP="wordcount(this.value, this.form);"></textarea>
                      </div>
                  </div>
                  <div class="mt-3">
                      <label for="lastname" class="control-label col-sm-2">Chars (160 max)</label>
                      <div class="col-lg-5">
                          <input class="input w-full rounded-full border mt-2" id="num_words" name="num_words" value="0" type="text" disabled />
                      </div>
                  </div>                 
                  <div class="mt-3">
                      <label>Added By:</label>
                      <div class="col-lg-5">
                          <input class="input w-full rounded-full border mt-2" id="owner" name="owner" type="text" value="{{ $names }}" disabled/>
                          &nbsp;<font class="error"></font>
                      </div>
                  </div>         
                  <div class="text-right mt-5">
                      <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-1 text-white" type="submit">Send</button>
                      <button class="button w-24 rounded-full shadow-md mr-1 mb-2 bg-theme-12 text-white" type="reset">Reset</button>
                      <button class="button w-24 rounded-full shadow-md mr-1 mb-2 text-gray-700 dark:bg-dark-5 dark:text-gray-300" type="button" onClick='window.location.href="{{ route('broadcasts.bulksms')}}"'>Cancel</button>
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