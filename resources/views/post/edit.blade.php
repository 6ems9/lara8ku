@extends('layouts.sbadmin.main', ['title' => 'Create Post'])
@push('styles')
    <!-- Custom styles for this page -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <style>
      trix-toolbar [data-trix-button-group="file-tools"] {
        display: none;
      }
    </style>
@endpush

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Post</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Go Back</a>
        </div>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('post.update', $post->slug) }}" method="post" enctype="multipart/form-data">
                    @method('PUT') @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $post->title) }}" id="title" name="title">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $post->slug) }}" id="slug" name="slug" readonly>
                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="custom-select" id="category" name="category_id">
                            @foreach ($categories as $category)
                                @if (old('category_id', $post->category_id) == $category->id)
                                    <option value="{{ $category->id }}" selected> {{ $category->name }} </option>
                                @else
                                    <option value="{{ $category->id }}"> {{ $category->name }} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tag" class="form-label">Select Tag</label>
                        <select name="tag[]" id="tag" class="js-example-basic-multiple custom-select" multiple="multiple">
                            @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" {{ (collect(old('tag', $taging))->contains($tag->id)) ? 'selected':'' }}>{{$tag->name}}</option>
                            @endforeach
                        </select>
                        @error('tag')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Post Image</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                            value="{{ old('image') }}" id="image" name="image">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        @if ($post->image)
                            <img src="{{ asset('storage/'. $post->image) }}" id="preview-image-before-upload" alt="preview image" style="max-height: 200px;">
                        @else  
                            <img id="preview-image-before-upload" alt="preview image" style="max-height: 200px;display:none;">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Body</label>
                        <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
                        <trix-editor input="body"></trix-editor>
                        @error('body')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script>
        $('#title').change(function(e) {
            $.get('{{ url('check_slug') }}', {
                    'title': $(this).val()
                },
                function(data) {
                    $('#slug').val(data.slug);
                }
            );
        });

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        document.addEventListener("trix-file-accept", event => {
            event.preventDefault()
        });

        $(document).ready(function(e) {

            $('#image').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                    $('#preview-image-before-upload').show();
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endpush
