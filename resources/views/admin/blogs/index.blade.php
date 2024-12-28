@extends('admin.layouts')
@section('title', 'Blogs')

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
                    <div class="col-md-9">
                        <h5 class="card-header">Blogs</h5>
                    </div>
                    <div class="col-md-3">
                        <a sty href="{{ route('admin.blogs.create') }}" class="btn btn-primary addBtn">Add Blog</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                               @forelse ($blogs as $item)
                                   <tr>
                                        <td>{{ $item->id}}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description}}</td>
                                        <td><img src="{{$item->image}}" width="80px" alt=""></td>
                                        <td>
                                            <a href={{ url('admin/blogs/'.$item->id.'/edit') }} class="btn btn-sm btn-warning"><i class="fas fa-pencil"></i></a>
                                            <button title="Delete" type="button" name="delete" id="{{$item->id}}" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </td>
                                   </tr>
                               @empty
                                   
                               @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>
</div>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #343a40; color: #fff;">
                <h2 class="modal-title">Confirmation</h2>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin: 0;">Are you sure you want to delete this?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" id="ok_delete" name="ok_delete" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@section('js')
<script>
    var delete_id;
        $(document, this).on('click', '.delete', function () {
            delete_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });

        $(document).on('click', '#ok_delete', function () {
            $.ajax({
                type: "delete",
                url: '/admin/blogs/' + delete_id,  
                
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('#ok_delete').text('Deleting...');
                    $('#ok_delete').attr("disabled", true);
                },
                success: function (data) {
                    $('#ok_delete').text('Delete');
                    $('#ok_delete').attr("disabled", false);
                    $('#confirmModal').modal('hide');
                    window.location.reload();
                    //   js_success(data);
                    if (data == 0) {
                        toastr.error('Exception Here ! Delete Firstly Child Category');
                    } else {
                        toastr.success('Record Delete Successfully');
                    }



                }
            })
        });

</script>
@endsection
