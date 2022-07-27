@extends('admin.admin_master')
@section('admin')

 <!-- Content Wrapper. Contains page content -->

    <div class="container-full">
      <!-- Content Header (Page header) -->


      <!-- Main content -->
      <section class="content">
        <div class="row">




          <div class="col-8">

           <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Add Brand</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>Brand Eng</th>
                              <th>Brand Fr</th>
                              <th>Image</th>
                              <th>Action</th>

                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($brands as $item)

                        <tr>
                            <th>{{ $item->brand_name_eng }}</th>
                            <th>{{ $item->brand_name_fr }}</th>
                            <th><img src="{{ asset($item->brand_image) }}" style="width:70px;height:40px;" alt=""></th>
                            <th>
                              <a href="" class="btn btn-info">Edit</a>
                              <a href="" class="btn btn-danger">Delete</a>
                            </th>

                        </tr>
                        @endforeach
                      </tbody>

                    </table>
                  </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->


            <!-- /.box -->
          </div>
          <!-- /.col -->



          {{-- Add Brand Page  --}}

          <div class="col-4">

            <div class="box">
               <div class="box-header with-border">
                 <h3 class="box-title">Brand List</h3>
               </div>
               <!-- /.box-header -->
               <div class="box-body">
                   <div class="table-responsive">
                    <form method="post" action="{{ route('brand.store') }}"  enctype="multipart/form-data">
                        @csrf


                                    <div class="form-group">
                                        <h5>Brand Name English<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="brand_name_eng"   class="form-control"  >
                                            @error('brand_name_eng')
                                              <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Brand Name French<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="text" name="brand_name_fr"  class="form-control" >
                                            @error('brand_name_fr')
                                              <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <h5>Brand Image<span class="text-danger">*</span></h5>
                                        <div class="controls">
                                            <input type="file" name="brand_image" class="form-control" >
                                            @error('brand_image')
                                              <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    </div>










                           <div class="text-xs-right">
                            <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add New">
                           </div>
                       </form>
                   </div>
               </div>
               <!-- /.box-body -->
             </div>
             <!-- /.box -->


             <!-- /.box -->
           </div>
           <!-- /.col -->






        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->

    </div>




@endsection
