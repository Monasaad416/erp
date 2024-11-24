
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

  <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/fontawesome-free/css/all.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/jqvmap/jqvmap.min.css')); ?>">
<!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/dist/css/adminlte_rtl.css')); ?>">





  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">

  <!-- select2 -->
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2/css/select2.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('dashboard/assets/plugins/bs-stepper/css/bs-stepper.min.css')); ?>">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- toggle button on-off -->
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style>
    /*custom styles */

    .search_term {
        background-color : #f4f6f9;
    }


    .toggle-handle{
        background-color: #e9e1e1 !important;
    }


    .select2-container--default .select2-selection--single {
        border-color: #d0d4da;
        height: 38px;
        margin-top: 5px
    }
    #example1_wrapper {
        overflow-x: auto; /* Enable vertical scrolling when the content exceeds the height */
    }

    table thead{
      background: #f4f6f9  !important;
      color: #010607 !important;
    }

      .card-body {
        overflow-x: auto; /* Enable vertical scrolling when the content exceeds the height */
    }

    .table th, .table td {
    padding: 0.2rem;
    vertical-align: top;
    }

    .breadcrumb-item a{
        color: #17a2b8 !important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff !important;
        background-color: #17a2b8 !important;
        border-color: #17a2b8 !important;
    }

    .page-link{
        color: #17a2b8 !important;

    }

  .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 28px;
    width: auto !important;
    user-select: none;
    -webkit-user-select: none;
    height: 38px !important;
    margin-bottom: 4px;
    margin-top: 0;
}

.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #ced4da !important;
    border-radius: 4px;
}

  .select2-container {
      /* width: 90% !important; */
        border-color:#ced4da !important;
  }
  .select2-container--default.select2-container--focus .select2-selection--single, .select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color:#ced4da !important;
    /* width: 90% !important; */
    padding:10px 0;
    height:36px;
}
        .inv-fields {
            font-size:12px !important;
             font-weight:bold !important;
        }



@media(min-width:1000px){
  :dir(rtl) .modal-content {
      width: 250%;
      left: 400px !important;
      display: flex;
      flex-direction: column;
      pointer-events: auto;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 0.3rem;
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.5);
      outline: 0;
  }

    :dir(ltr) .modal-content {
      width: 250%;
      display: flex;
      flex-direction: column;
      right: 400px;
      pointer-events: auto;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 0.3rem;
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.5);
      outline: 0;
  }
}

label {
    font-weight: bolder;
    font-size: 15px;
}


 
         .fa-plus {
            font-size: 0.7rem !important;
        }

</style>





  




<?php echo $__env->yieldPushContent('css'); ?>




<?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>



  
  




    <style>
        @media print {
            #print_button {
                display: none;
            }
        }
    </style>


</head>



<?php /**PATH D:\laragon\www\pharma\resources\views/admin/layouts/head.blade.php ENDPATH**/ ?>