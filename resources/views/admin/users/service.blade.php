@extends('admin.layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('  admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
@endsection
@section('content')
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          

            <div class="card">
              <div class="card-header">
                <!-- <h3 class="card-title float-right  text-white"><a href="{{-- route('create-users') --}}" class="btn-success btn">Add New</a></h3> -->
                 &nbsp;&nbsp;
                <!-- <h3 class="card-title float-right  text-white"><a href="{{--route('user.export')--}}" class="btn-primary btn">Export Excel</a>
                  
                </h3> -->
              </div>

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
              
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                   <th>Type</th>
                    
                    <th>Action</th>
                    
                  </tr>
                  </thead>
                  <tbody>
                 @forelse($users as $key=> $user)
                  <tr>

                      <td>{{$key+1}}</td>
                       <td>
                        @if($user->profile_image)
                        <img src="{{ asset($user->profile_image) }}" width="50px" height="50px">
                        @else
                        <img src="{{ asset('assets/images/user-image.png') }}" width="50px" height="50px">
                        @endif
                      </td>
                      <td>{{$user->first_name }} {{ $user->last_name}} </td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->phone_number}}</td>
                      <td>{{$user->type}}</td>
                      <td>  
                        <!-- <a href="{{-- route('edit-users',['id'=>$user->id]) --}}"> <button type="button" class="btn btn-info view" 
                          data-description="{{$user->description}}"><i class="fa fa-edit" aria-hidden="true" 
                          ></i></button></a> -->
                          <button class="btn btn-danger delete" data-id="{{$user->id}}"><i class="fa fa-trash"></i></button>

                        </td>
                     

                      
                  </tr>                        
                  @empty
                                           
                @endforelse
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card --> 
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection
@section('script')
<!-- Bootstrap 4 -->
<!-- DataTables  & Plugins -->
<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
   $(document).on("click",".delete",function(){
            if (!confirm("Are you sure you want to delete this user?")){
              return false;
            }
        var id=$(this).data("id");
        $.ajax({
            url:"{{ route('admin.delete-users') }}",
            data:{id:id,"_token":"{{csrf_token()}}"},
            type:"post",
            success:function(res){
                console.log(res);
                location.reload();

            }
        })
      })
     
</script>
@endsection
