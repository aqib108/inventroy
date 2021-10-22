<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
<link href="{{asset('backend/img/logo/logo.png')}}" rel="icon">
  <title>RuangAdmin - Dashboard</title>
  <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('backend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('backend/css/ruang-admin.min.css')}}" rel="stylesheet">
<style>
  .hidden{
    display: none !important;
  }
   .router-link-exact-active{
     background: #d0d0d8;
   }
   #sidebarToggleTop{
     color: white;
   }
</style>
</head>

<body id="page-top" onload="dependecy()">
    <div id="app">

    
  

        <!-- Container Fluid-->
        <div class="container pt-5" id="container-wrapper">
        <router-view></router-view>
</div>
        <!---Container Fluid-->
      </div>
    
    </div>
  </div>
  </div>
  <!-- Scroll to top -->
 
  <script src="{{asset('js/app.js')}}"></script> 
  <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('backend/js/ruang-admin.min.js')}}"></script>
  <script src="{{asset('backend/vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('backend/js/demo/chart-area-demo.js')}}"></script>  
{{-- <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
            }
        }
    </script> --}}
</body>

</html>