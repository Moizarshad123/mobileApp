@extends('admin.layouts')
@section('title')
Change Password
@endsection

@section('content')
  
   <!-- Content -->

     <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Change Password</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
        
          <!-- Basic with Icons -->
          <div class="col-md-12 col-sm-12">
            <div class="card mb-4">
          
              <div class="card-body">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.updateAdminPassword') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label class=" form-label" for="basic-icon-default-message">Old Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="current_password" placeholder="Old Password">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label class=" form-label" for="basic-icon-default-message">New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password" placeholder="New Password">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label class=" form-label" for="basic-icon-default-message">Confirm New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password">
                            </div>
                        </div>
                    </div>
                  <div class="row">
                    <div class="col-sm-10">
                      <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / Content -->
@endsection
