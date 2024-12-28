@extends('admin.layouts')
@section('title', 'Add Blog')

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
                        <h5 class="card-header">Add Blog</h5>
                    </div>
                    
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.blogs.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="serviceDescription">Blog Title</label>
                                    <input type="text" name="title" id="title" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="serviceDescription">Blog Description</label>
                                    <textarea name="description" id="serviceDescription" class="form-control" rows="6" ></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="serviceDescription">Blog Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-info">Add</button>
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
