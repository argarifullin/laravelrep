@extends('layouts.layout')

@section('title', 'Markedia - Marketing Blog Template :: ' . $post->title)

@section('content')

    <div class="page-wrapper">
        <div class="blog-title-area">
            <ol class="breadcrumb hidden-xs-down">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('categories.single', ['slug' => $post->category->slug]) }}">{{ $post->category->title }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $post->title }}</li>
            </ol>

            <span class="color-yellow"><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}"
                                          title="">{{ $post->category->title }}</a></span>

            <h3>{{ $post->title }}</h3>

            <div class="blog-meta big-meta">
                <small>{{ $post->getPostDate() }}</small>
                <small><i class="fa fa-eye"></i> {{ $post->views }}</small>
            </div><!-- end meta -->




        </div><!-- end title -->

        <div class="single-post-media">
            <img src="{{ $post->getImage() }}" alt="" class="img-fluid">
        </div><!-- end media -->

        <div class="blog-content">
            {!! $post->content !!}
        </div><!-- end content -->

        <div class="blog-title-area">
            @if($post->tags->count())
                <div class="tag-cloud-single">
                    <span>Tags</span>
                    @foreach($post->tags as $tag)
                        <small><a href="{{ route('tags.single', ['slug' => $tag->slug]) }}" title="">{{ $tag->title }}</a></small>
                    @endforeach
                </div><!-- end meta -->
            @endif


        </div><!-- end title -->
        @auth
        <hr class="invis">

        <div class="custombox clearfix">
            <h4 class="small-title">Leave a Reply</h4>
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-wrapper" action="{{route('submit')}}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <textarea class="form-control" placeholder="Your comment" name="message" required></textarea>
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                    </form>
                </div>
            </div>
        </div>
        @endauth
        <hr class="invis1">

        <div class="custombox clearfix">
            <h4 class="small-title">Comments</h4>
            @if($comments->count())

                <div class="row">
                    <div class="col-lg-12">

                            <ul>
                                <div class="comments-list">
                            @foreach($comments as $comment)
                            <li>
                                <div class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading user_name"> {{$comment->username}}<small> {{$comment->getCommentDate()}} </small>
                                            <small>
                                                @auth
                                                    @if(Auth::user()->is_admin)
                                                        <a href="{{route('deletecomment',['id'=>$comment->id,'user_id' => $comment->user_id])}}">
                                                            <button type="button" class="btn btn-primary btn-sm">Delete</button>
                                                        </a>
                                                    @elseif ($comment->user_id == Auth::id())
                                                        <a href="{{route('deletecomment',['id'=>$comment->id,'user_id' => $comment->user_id])}}">
                                                            <button type="button" class="btn btn-primary btn-sm">Delete my comment</button>
                                                        </a>
                                                    @endif
                                                @endauth
                                            </small>
                                        </h4>

                                        <p>{{$comment->message}}</p>
                                    </div>

                                </div>
                            </li>

                            @endforeach
                                </div>
                            </ul>

                    </div><!-- end col -->
                </div><!-- end row -->
            @else
                <div class="row">
                    <h5>No comments yet...</h5>
                </div>
            @endif
        </div><!-- end custom-box -->




    </div><!-- end page-wrapper -->

@endsection
