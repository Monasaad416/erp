<?php $__env->startSection('content'); ?>
    <div class="content-wrapper" style="min-height: 1302.4px;">
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
            <h1> <?php echo e(trans('admin.settings')); ?></h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('index')); ?>"><?php echo e(trans('admin.home')); ?></a></li>
            <li class="breadcrumb-item active"><?php echo e(trans('admin.settings')); ?></li>
            </ol>
            </div>
            </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <?php
                            $locale = Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
                        ?>
       
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->is($locale.'/settings/edit') ? 'active' : ''); ?>" id="<?php echo e(route('settings.edit')); ?>-tab"  href="<?php echo e(route('settings.edit')); ?>">إعدادات الموقع</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->is($locale.'/zatca/settings/edit') ? 'active' : ''); ?>" id="<?php echo e(route('zatca_settings.edit')); ?>-tab"  href="<?php echo e(route('zatca_settings.edit')); ?>">إعدادات الزكاة والضريبة </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo e(request()->is($locale.'/capital/settings/edit') ? 'active' : ''); ?>" id="<?php echo e(route('capital_settings.edit')); ?>-tab"  href="<?php echo e(route('capital_settings.edit')); ?>">إعدادات رأس المال</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade <?php echo e(request()->is($locale.'/settings/edit') ? 'show active' : ''); ?>" id="<?php echo e(route('settings.edit')); ?>" >
                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('settings.update-settings', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3903653520-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                </div>
                                <div class="tab-pane fade <?php echo e(request()->is($locale.'/zatca/settings/edit') ? 'show active' : ''); ?>" id="<?php echo e(route('zatca_settings.edit')); ?>">
                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('zatca-setting.create-integration-keys', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3903653520-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                </div>
                                <div class="tab-pane fade <?php echo e(request()->is($locale.'/capital/settings/edit') ? 'show active' : ''); ?>" id="<?php echo e(route('capital_settings.edit')); ?>">
                                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('capital-settings.update-settings', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3903653520-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\pharma\resources\views/admin/pages/settings/edit.blade.php ENDPATH**/ ?>