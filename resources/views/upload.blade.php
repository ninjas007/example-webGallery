
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content Upload-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Choose Image</h4>
        </div>
        <div class="modal-body">
          <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
              <input type="file" name="image" class="btn btn-success form-control">
            </div>
            <div class="form-group">
              <input type="text" name="title" class="form-control" placeholder="Title image...">
            </div>
            <div class="form-group">
              <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Input Text.." style="resize: none"></textarea>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Save</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div> {{-- End Modal upload --}}