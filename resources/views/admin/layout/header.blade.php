<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AidBy | Dashboard</title>
  <!-- <link rel="icon" href="{{-- asset('public/web/assets/images/favicon.png') --}}" /> -->
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" />

  <!-- Google Font: Source Sans Pro -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
  @yield('style')
  <style>

  .toolTip {
    padding: 20px;
    background: #ccc;
    border-radius: 10px;
    font-size: 18px;
    transition: all 0.25s;
  }

  .brand-link .brand-image {
    float: left;
    line-height: .8;
    margin-left: 0.8rem;
    margin-right: 0.5rem;
    /*margin-top: 6px;*/
    max-height: 40px;
    width: auto;
}
    /* .nav-pills .nav-link:not(.active):hover {
    color: #f0f2f5;
}

.nav_active {
  background-color: #781a1a;
  color: white;
} */
/*@font-face {
  font-family: "Serto Jerusalem";
  src: url('public/admin/font.otf');*/
  /*src: url('fonts/fira/eot/FiraSans-Regular.eot') format('embedded-opentype'),
       url('fonts/fira/woff2/FiraSans-Regular.woff2') format('woff2'),
       url('fonts/fira/woff/FiraSans-Regular.woff') format('woff'),
       url('fonts/fira/woff2/FiraSans-Regular.ttf') format('truetype');*/
/*}*/


/*body {
  font-family: 'Serto Jerusalem' !important;
}*/

.nav-link {
    display: block;
    padding: 0.5rem 0.5rem;
}
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('assets/images/login-bg.png')}}" alt="Global Procurement Guru" height="250" width="250">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('admin.dashboard')}}" class="nav-link">Home</a>
      </li>
  
    </ul>

    <!-- <ul class="navbar-nav ml-auto"> -->
      <!-- Navbar Search -->
     

      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-people"></i>
          <span class="badge badge-warning navbar-badge">Profile</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> -->
          
          <!-- <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Profile
            
          </a> -->
          <!-- <div class="dropdown-divider"></div>
          <a href="{{-- route('logout') --}}" class="dropdown-item">
            <i class="fas fa-users mr-2"></i>Logout
           
          </a>
          
      </li>
      
    </ul> -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset('assets/images/login-bg.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      
      <span class="brand-text font-weight-light">AidBy</span> 
      <br>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="" class="img-circle elevation-2" alt=""> -->
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
            

         

            <li class="nav-item {{ Request::is('dashboard') ? 'nav_active' : '' }}">
              <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                  <p>
                    DASHBOARD
                  </p>
              </a>
            </li>
            

            <li class="nav-item {{ Request::is('users') ? 'nav_active' : '' }}">
              <a href="{{ route('admin.users') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                  <p>
                    USERS 
                  </p>
              </a>


            </li>

            <li class="nav-item {{ Request::is('service-provider') ? 'nav_active' : '' }}">
              <a href="{{ route('admin.service-provider') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                  <p>
                    SERVICE PROVIDERS
                  </p>
              </a>


            </li>



            <!-- <li class="nav-item {{ Request::is('contents') ? 'nav_active' : '' }}">
              <a href="{{-- route('contents') --}}" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                  <p>
                    CONTENT MANAGEMENT
                  </p>
              </a>
            </li> -->

            <li class="nav-item has-submenu {{ Request::is('contents') ? 'nav_active' : '' }}{{ Request::is('contents') ? 'nav_active' : '' }}">
              <a class="nav-link" href="{{ route('contents') }}"><i class="nav-icon fas fa-copy"></i> 
                <p>CONTENT  </p></a>
             
            </li>

            <li class="nav-item {{ Request::is('categories') ? 'nav_active' : '' }}">
              <a href="{{ route('admin.categories') }}" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                  <p>
                    CATEGORIES
                  </p>
              </a>


            </li>

          
         <!--<li class="nav-item">-->
         <!--   <a href="" class="nav-link">-->
         <!--     <i class="nav-icon fas fa-copy"></i>-->
         <!--     <p>-->
         <!--       Notifications-->
         <!--     </p>-->
         <!--   </a>-->
         <!-- </li>-->
         
         
          <li class="nav-item">
            <a href="{{ route('admin.logout')}}" class="nav-link">
              <i class="nav-icon fas fa-trash"></i>
               <p>
               Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
    
    element.addEventListener('click', function (e) {

      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;  

        if(nextEl) {
            e.preventDefault(); 
            let mycollapse = new bootstrap.Collapse(nextEl);
            
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
}); 
  </script>