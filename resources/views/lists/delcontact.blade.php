@extends('layouts.admin')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">    
<div class="modal fade " id="delContact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <form action="lists.php" method="POST">
      <input type="hidden" name="t" value="delcontact">
      <input type="hidden" name="num_id" id="num_id">
      <input type="hidden" name="id" name="id">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header modal-delete">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Delete Contact</h4>
              </div>
              <div class="modal-body">
                  Do you want to delete this contact? It will be removed from all lists and the database. Note that this action is irreversible.
              </div>
              <div class="modal-footer">
                  <button data-dismiss="modal" class="btn btn-primary" type="button">Close</button>
                  <button class="btn btn-danger" type="submit">Delete</button>
              </div>
          </div>
      </div>
    </form>
   </div>
 </div>
</div>
@endsection