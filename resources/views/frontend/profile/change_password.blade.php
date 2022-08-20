@extends('frontend.main_master')
@section('content')

<div class="body-content">
    <div class="container">
        <div class="row">
            @include('frontend.common.user_sidebar')

            <div class="col-md-2">

            </div>

            <div class="col-md-6">
                <div class="card" >
                    <h3 class="text-center"><span class="text-danger">Change password</span><strong></h3>

                    <div class="card-body">
                        <form action="{{ route('user.password.update') }}" method="POST" >
                            @csrf
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Current Password<span></span></label>
                                <input name="oldpassword" id="current_password" type="password" class="form-control"   >
                            </div>

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">New Password<span></span></label>
                                <input name="password" id="password" type="password" class="form-control"  >
                            </div>

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Confirm Password<span></span></label>
                                <input name="password_confirmation" id="password_confirmation" type="password" class="form-control"   >
                            </div>



                            <div class="form-group">

                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>



                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


@endsection
