<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo e(route('index')); ?>" class="nav-link"><?php echo e(trans('admin.home')); ?></a>
        </li>
        
    </ul>

    <ul class="navbar-nav ml-auto">

        

        <?php
            $noOfNotifications = count(auth()->user()->notifications);
            $noOfUnReadNotifications = count(auth()->user()->unreadnotifications);
        ?>


    <li class="nav-item dropdown"  id="notificationIcon">
            <a class="nav-link" data-toggle="dropdown" href="#" >
                <i class="far fa-bell"></i>
                <span id="counter" class="badge badge-<?php echo e($noOfUnReadNotifications == 0 ? 'secondary' : 'warning'); ?> navbar-badge">
                <?php echo e(request()->is('notifications') ? 0 : $noOfUnReadNotifications); ?>

                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <span class="dropdown-item dropdown-header"><?php echo e($noOfNotifications); ?> إشعار</span>
                <?php if($noOfNotifications > 0): ?>
                <div class="dropdown-divider"></div>
                    <?php $__currentLoopData = Auth::user()->notifications->take(15); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($notification->data['action']): ?>
                            <a href="<?php echo e(url($notification->data['action'])); ?>" id="notification" data-id="<?php echo e($notification->id); ?>" class="dropdown-item <?php if($notification->read_at == null ): ?> text-primary <?php else: ?> text-muted <?php endif; ?>">
                                <i class="fas fa-envelope mr-2"></i><?php echo e($notification->data['title']); ?>

                                <span class="float-right text-muted text-sm"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                            </a>
                        <?php else: ?>
                        <i class="fas fa-envelope mr-2"><?php echo e($notification->data['title']); ?></i>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo e(route('notifications')); ?>" class="dropdown-item dropdown-footer">إظهار كل الاشعارات</a>
                <?php endif; ?>


            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item dropdown" title="<?php echo e(trans('admin.select_lang')); ?>">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-flag"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a class="dropdown-item" rel="alternate" hreflang="<?php echo e($localeCode); ?>" href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                    <?php echo e($properties['native']); ?>

                </a>
                <div class="dropdown-divider"></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </div>
        </li>

    </ul>
</nav>
<?php /**PATH D:\laragon\www\pharma\resources\views/admin/layouts/navbar.blade.php ENDPATH**/ ?>