@extends('layouts.app')
@section('content')

<div class="container"> {{-- Start Container 1 --}}
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Welcome  </div>
      </div>
      <a href="#myModal" data-toggle="modal" type="file" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> Upload Image</a>
    </div>
  </div>

  <!-- Modal Upload-->
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

</div>{{-- end container 1 --}}

<div class="container" style="margin-top: 30px;"> {{-- Start Container 2 --}}
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        Gallery
      </div>
    </div>
  </div>


  @foreach($posts as $post)

    <div class="col-md-3">
      <div class="panel panel-default">
        <div class="panel-header" style="text-align: center; color: black; font-weight: 700">
          {{$post->title}}
        </div>
        <div class="panel-body">
          <div class="show-image"><a href="#{{$post->id}}" data-toggle="modal"><img src="{{asset('images/' . $post->image)}}" alt=""></a></div>
        </div>
        <div class="panel-footer">
          <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#{{$post->id}}"><i class="fa fa-comment"></i> comments</button>
        <span class="btn btn-xs btn-info">{{$post->comments()->count()}}</span>
        </div>
      </div>
    </div>

    <!-- Modal Image-->
    <div id="{{$post->id}}" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content Image-->
        <div class="modal-content">
          <div class="border" style="border: 1px solid grey">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{$post->title}}</h4>
          </div>
          <div class="modal-body">
            <div class="show-image-modal"><img src="{{asset('images/' . $post->image)}}" alt=""></div>
          </div>
          <hr>

            <div class="post-desc" style="padding: 15px; padding-top: 0px;">
              <strong>Description :</strong> 
              <p class="text-justify">{{$post->description}}</p>
            </div>
          <div class="panel-footer">
            <span class="user-info">post by : {{$post->user->name}}</span>
            <span class="user-time pull-right">{{$post->created_at->diffForHumans()}}</span>
          </div>
          </div>
          
          <div class="modal-body">
            <form action="{{route('addComment', $post->id)}}" method="post">
              {{csrf_field()}}
              <div class="form-group">
                <textarea type="text" name="content" placeholder="comment here..." class="form-control" style="resize: none;"></textarea>
              </div>
              <button type="submit" class="btn btn-sm btn-success">comment</button>
            </form>
            <hr>
            <div class="panel panel-default">
              @if($post->comments->isEmpty())
                <div class="text-center" style="color: black">
                  No Comments
                </div>

              @else
                @foreach($post->comments as $comment)
                <p style="color: black; padding: 10px;">{{$comment->content}}</p>
                <div class="panel-footer" style="color: black; ">
                  <span class="user-info">comment by : {{$comment->user->name}}</span>
                  <span class="user-time pull-right">{{$comment->created_at->diffForHumans()}}</span>
                </div>
                @endforeach
              @endif
            </div>
            <br>
          </div>        
        </div>

      </div>
    </div>

    
  @endforeach
</div> {{-- End Container 2 --}}

@endsection

<style>
  .show-image img{
    width: 100%;
    height: 30%;
  }

  .show-image-modal img{
    width: 100%;
    height: 60%;
  }

  .panel-header {
    padding: 15px;
    padding-bottom: 0px;
  }

  .post-desc{

  }

  .comment-list {
    border-radius: 5px;
    border-bottom: 1px dashed grey;
  }
</style>