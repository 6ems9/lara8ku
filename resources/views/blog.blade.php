@extends('layouts.sbadmin.bootstrap', ['title' => 'Blog'])

@section('content')


    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                @if ($blogs->count())
                <!-- Featured blog post-->
                <div class="card mb-4">
                    <div class="position-absolute px-3 py-2" style="background-color:rgba(0,0,0,0.8)">
                        <a href="/blog?category={{ $blogs[0]->category->slug }}" class="text-decoration-none text-light">{{ $blogs[0]->category->name }}</a>
                    </div>
                    @if ($blogs[0]->image)
                        <div style="max-height:350px;width:100%;overflow:hidden" >
                            <img src="{{ asset('storage/'. $blogs[0]->image) }}" class="card-img-top img-fluid" alt="{{ $blogs[0]->category->name }}">  
                        </div>
                    @else
                        <img src="https://source.unsplash.com/850x350?{{ $blogs[0]->category->name }}" class="card-img-top img-fluid" alt="{{ $blogs[0]->category->name }}">
                    @endif
                    
                    <div class="card-body">
                        <div class="small text-muted d-flex justify-content-end">
                            <a href="/blog?author={{ $blogs[0]->author->username }}" class="text-decoration-none"><b>{{ $blogs[0]->author->name }}</b></a>&nbsp;-&nbsp;last updated {{ $blogs[0]->created_at->diffForHumans() }}
                        </div>
                        <h2 class="card-title"><a href="/blog/{{ $blogs[0]->slug }}" class="text-decoration-none text-light"> {{ $blogs[0]->title }} </a></h2>
                        <p>
                            @foreach ($blogs[0]->tags as $tag0)
                                <a href="/blog?tags={{$tag0->slug}}" class="text-decoration-none">{{$tag0->name}}</a>
                            @endforeach
                        </p>
                        <p class="card-text">{{ $blogs[0]->excerpt }} </p>
                    </div>
                </div>
                <!-- Nested row for non-featured blog posts-->
                <div class="row">
                    @foreach ($blogs->skip(1) as $blog)
                    <div class="col-lg-6">
                        <!-- Blog post-->
                        <div class="card mb-4">
                            <div class="position-absolute px-3 py-2" style="background-color:rgba(0,0,0,0.8)">
                                <a href="/blog?category={{ $blog->category->slug }}" class="text-decoration-none text-light">{{ $blog->category->name }}</a>
                            </div>
                            @if ($blog->image)
                                <img src="{{ asset('storage/'. $blog->image) }}" class="card-img-top" alt="{{ $blog->category->name }}">
                            @else
                                <img src="https://source.unsplash.com/600x400?{{ $blog->category->name }}" class="card-img-top" alt="{{ $blog->category->name }}">
                            @endif
                            <div class="card-body">
                                <div class="small text-muted d-flex justify-content-end">
                                    <a href="/blog?author={{ $blog->author->username }}" class="text-decoration-none"><b>{{ $blog->author->name }}</b></a>&nbsp;-&nbsp;last updated {{ $blog->created_at->diffForHumans() }}
                                </div>
                                <h3 class="card-title"><a href="/blog/{{ $blog->slug }}" class="text-decoration-none text-light"> {{ $blog->title }} </a></h3>
                                <p class="card-text">{{ $blog->excerpt }}</p>
                                <p>
                                    @foreach ($blog->tags as $tag)
                                        <a href="/blog?tags={{$tag->slug}}" class="text-decoration-none">{{$tag->name}}</a>
                                    @endforeach
                                </p>
                                <a class="btn btn-primary" href="#!">Read more →</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination-->
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        {{ $blogs->links() }}
                    </ul>
                </nav>
                @else 
                    <p class="text-center fs-4"> No Blog Found. </p>
                @endif
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <form action="/blog">
                            @if (request('author'))
                                <input type="hidden" name="author" value="{{ request('author') }}">
                            @endif
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search...." name="search" value="{{ request('search')}}">
                                <button class="btn btn-primary" type="submit">Go!</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">Web Design</a></li>
                                    <li><a href="#!">HTML</a></li>
                                    <li><a href="#!">Freebies</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">JavaScript</a></li>
                                    <li><a href="#!">CSS</a></li>
                                    <li><a href="#!">Tutorials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to
                        use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
        </div>
    </div>

@endsection
