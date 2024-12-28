@extends('admin.layouts')
@section('title', 'Edit Blog')

@section('css')

@endsection
@section('content')
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Bootstrap Table -->
            <div class="card mb-4">
                <div class="row">
                    <div class="col">
                        <h5 class="card-header">Edit Blog</h5>
                    </div>
                    
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.blogs.update', $blog->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="serviceDescription">Blog Title</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ $blog->title }}">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="serviceDescription">Blog Description</label>
                                    <textarea name="description" id="serviceDescription" class="form-control" rows="6" >{{ $blog->description }}</textarea>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="serviceDescription">Blog Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset($blog->image) }}" width="250px" alt="">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Update</button>
                    </form>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@section('js')
<script>


</script>
@endsection
