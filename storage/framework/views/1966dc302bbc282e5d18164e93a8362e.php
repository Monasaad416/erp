<?php $__env->startSection('title'); ?>
الرئيسية
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">لوحة التحكم</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>">الرئيسية</a></li>
              <li class="breadcrumb-item active">لوحة التحكم </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    

    <?php if(Auth::user()->roles_name == 'سوبر-ادمن'): ?>
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Product::count()); ?></h3>

                <p>إجمالي عدد الاصناف </p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo e(route('products')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Unit::count()); ?></h3>

                <p>عدد الوحدات</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('units')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Category::count()); ?></h3>

                <p>عدد التصنيفات</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('categories')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Branch::whereNot('id',1)->count()); ?></h3>

                <p>عدد الفروع</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('branches')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\User::count()); ?></h3>
                <p>عدد الموظفين</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('users')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
         <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(Spatie\Permission\Models\Role::count()); ?></h3>
                <p>عدد المهام</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('roles')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Supplier::count()); ?></h3>
                <p>عدد الموردين</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('suppliers')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\SupplierInvoice::count()); ?></h3>
                <p>عدد فواتير الموردين</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('suppliers.invoices')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Customer::count()); ?></h3>
                <p>عدد العملاء</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('customers')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\CustomerInvoice::count()); ?></h3>
                <p>عدد فواتير العملاء</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('customers.invoices')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\CustomerReturn::where('branch_id',Auth::user()->branch_id)->count()); ?></h3>
                <p>عدد فواتير مردودات العملاء</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('customers.returns')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          

        <style>
        .bg-custom {
            background-color: #6962AD;
        }
        </style>

          <!-- ./col -->
          

          <!-- ./col -->

        </div>


        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->


        <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card card-dashboard-map-one d-flex justify-contenr-center align-items-center">
                
            </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php else: ?>
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Product::count()); ?></h3>

                <p>إجمالي عدد الاصناف </p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo e(route('products')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Unit::count()); ?></h3>

                <p>عدد الوحدات</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('units')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\Category::count()); ?></h3>

                <p>عدد التصنيفات</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('categories')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          



          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\CustomerInvoice::where('branch_id',Auth::user()->branch_id)->count()); ?></h3>
                <p>عدد فواتير العملاء</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('customers.invoices')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-light">
              <div class="inner">
                <h3><?php echo e(App\Models\CustomerReturn::where('branch_id',Auth::user()->branch_id)->count()); ?></h3>
                <p>عدد فواتير مردودات العملاء</p>

              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo e(route('customers.returns')); ?>" class="small-box-footer">المزيد<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>




        <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card card-dashboard-map-one d-flex justify-contenr-center align-items-center">
                
            </div>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php endif; ?>
    <!-- /.content -->
  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/dashboard/index.blade.php ENDPATH**/ ?>