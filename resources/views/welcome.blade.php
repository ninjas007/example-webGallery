
@extends('layouts.app')
@section('content')

<div class="container"> {{-- Start Container 1 --}}
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Welcome, {{Auth::User()->name}}</div>
      </div>
      <a href="#myModal" data-toggle="modal" type="file" class="btn btn-primary btn-block"><i class="fa fa-upload"></i> Upload Image</a>
    </div>
  </div>
  <!-- Modal Upload-->
@include('upload')
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
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-header" style="text-align: left; color: black;">
        <div class="dropdown pull-right">
          <a class="btn btn-sm dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:black;">
            <strong>. . .</strong>
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <ul>
              <li style="list-style: none;"><a class="dropdown-item" data-toggle="modal" href="#myModal">Edit</a></li>
              <li style="list-style: none;"><a class="dropdown-item" href="{{route('deletePost', $post->id)}}">Delete</a></li>
            </ul>
          </div>
          <!-- Modal Edit-->
          @include('upload')
          {{-- End Modal Edit --}}
        </div>
      </div>
      <div class="panel-body">
        <div class="show-image"><a href="#{{$post->id}}" data-toggle="modal"><img src="{{asset('images/' . $post->image)}}" alt=""></a></div>
      </div>
      <div class="panel-footer">
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#{{$post->id}}"><i class="fa fa-comment"></i> comments</button>
        <span class="btn btn-xs btn-primary">{{$post->comments()->count()}}</span>
        <span>
          <button type="button" class="btn btn-primary btn-xs {{ $post->YouLiked()?"liked":""}}" onclick="postlike('{{$post->id}}', this)" id="btn_like"><i class="fa fa-thumbs-up"></i></button>
        <span class="btn btn-xs btn-primary" id="{{$post->id}}-count">{{$post->likes()->count()}}</span>
        {{-- <span> --}}
          {{-- <div class="btn btn-xs pull-right"> --}}
            <!-- AddToAny BEGIN -->
            {{-- <a class="a2a_dd" href="https://www.addtoany.com/share" style="color: white">Share</a> --}}
            <!-- AddToAny BEGIN -->
           <div class="a2a_kit a2a_default_style pull-right">
               <a class="a2a_button_facebook">
                   <img src="https://static.addtoany.com/buttons/custom/facebook-icon-long-shadow.png" border="0" alt="Facebook" width="20" style="border-radius: 2px">
               </a>
               <a class="a2a_button_twitter">
                   <img src="https://static.addtoany.com/buttons/custom/twitter-icon-long-shadow.png" border="0" alt="Twitter" width="20">
               </a>
               <a class="a2a_button_google_plus">
                   <img src="https://static.addtoany.com/buttons/custom/google-plus-icon-long-shadow.png" border="0" alt="Google+" width="20" style="border-radius: 2px">
               </a>
           </div>

           <script async src="https://static.addtoany.com/menu/page.js"></script>
            <!-- AddToAny END -->
            <!-- AddToAny END -->
          {{-- </div> --}}
        {{-- </span> --}}
      </div>
    </div>
  </div>

  
  <!-- Modal Image-->
  <div id="{{$post->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content Image-->
      <div class="modal-content">
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
          <span class="user-info">by : {{$post->user->name}}</span>
          <span class="user-time pull-right">{{$post->created_at->diffForHumans()}}</span>
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
          <div class="panel">
            @if($post->comments->isEmpty())
            <div class="text-center" style="color: black">
              No Comments
            </div>
            @else
            @foreach($post->comments as $comment)
            <div class="panel-body post-comment">
              <span style="color:blue;"><strong>{{$comment->user->name}}</strong></span> <br> {{$comment->content}} <br>
              <span><small>{{$comment->created_at->diffForHumans()}}</small></span>
            </div>
            <br>
            @endforeach
            @endif
          </div>
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
height: 40%;
}
.show-image-modal img{
width: 100%;
height: 50%;
}
.panel-header {
padding: 15px;
padding-bottom: 0px;
}
.panel-default{
  border-color: none;
}
.comment-list {
border-radius: 5px;
border-bottom: 1px dashed grey;
}
.post-comment {
background-color: #C1C1C1;
border-radius: 5px;
}
</style>

@section('script')
<script type="text/javascript">
  function postlike(postId, elem){
    var csrfToken = '{{csrf_token()}}';
    var likeCount = parseInt($('#'+postId+"-count").text());
    $.post("{{route('postlike')}}", {postId:postId,_token:csrfToken}, function(data) { 
      console.log(data);
    
    if (data.message==='liked') {
      $('#'+postId+"-count").text(likeCount+1);
      $(elem).html('<div class="btn btn-default btn-xs">Liked</div>');
    } else {
      $('#'+postId+"-count").text(likeCount-1);
      $(elem).html('<div class="btn btn-default btn-xs">Unliked</div>');
    }

    });
    
  }

  // function deletePost(postId)
</script>
@stop


