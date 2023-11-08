@extends('admin.layout.master')
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Create Category</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Category</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">




        <!-- /.card -->
      </div>
      <!-- /.col -->
      <div class="col-md-12">
        <div class="card">

          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">

                @if(session('success'))
                <p class="toolTip">{{session('success')}}</p>
                <!-- <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                        <span class="badge badge-pill badge-success"></span>
                                          {{session('success')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div> -->
                @endif

                @if($errors->any())
                <p class="toolTip">{{$errors->first()}}</p>
                <!-- <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" style="width:40%;padding: 0.2rem 1.25rem;">
                            <span class="badge badge-pill badge-danger"></span>
                               <h6>{{$errors->first()}}</h6>
                           
                        </div> -->
                @endif

                <!-- /.tab-pane -->


                <div class="tab-pane" id="settings">
                  <form action="{{route('admin.store_category')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf


                    <div class="form-group row">
                      <div class="col-sm-8">
                        <label for="category" class="col-form-label">Category</label>
                        <input type="text" name="category" class="form-control" required="">
                      </div>
                      <div class="col-sm-4">
                        <label for="category_image" class="col-form-label">Image</label> <br>
                        <input type="file" name="category_image">
                      </div>
                    </div>
                    <br>
                    <div class="row" id="subdetail">

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="sub_category">Sub Category</label>
                          <input type="text" class="form-control" id="sub_category" placeholder="Enter Sub Category" name="sub_category[]" required="" value="{{old('Sub sub_category')}}">
                          <span class="text-danger">{{$errors->first('sub_category')}}</span>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="sub_category_image">Image</label> <br>
                          <input type="file" name="sub_category_image[]">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <button class="btn btn-md btn-primary" style="margin-top:32px" ; id="addBtn" type="button">
                            <i class="fas fa-plus"></i>
                          </button>
                        </div>
                      </div>
                    </div>


                    <div class="form-group row">
                      <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection

@section('script')
<script>
  // Denotes total number of rows.
  var rowIdx = 0;
  $('#addBtn').on('click', function() {

    // Adding a row inside the tbody.
    $('#subdetail').append(`
                <div id="R${++rowIdx}" class="col-md-6">
                  <div class="form-group">
                    <label for="sub_category">Sub Category</label>
                    <input type="text" class="form-control" placeholder="Enter Sub Category" name="sub_category[]" required="" value="{{old('Sub sub_category')}}">
                    <span class="text-danger">{{$errors->first('sub_category')}}</span>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="sub_category_image">Image</label> <br>
                    <input type="file" name="sub_category_image[]">
                  </div>
                </div>
                  
                <div class="col-md-2">
                  <div class="form-group">
                  </div>
                </div>
         `);
  });
</script>

@endsection