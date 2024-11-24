<aside class="main-sidebar sidebar-dark-light elevation-4">
    



    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

    <span class="brand-text font-weight-light"><img src=""></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="<?php echo e(url('dashboard/assets/img/avatar6.png')); ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo e(auth()->user()->name); ?></a>
                <p class="text-white"><?php echo e(App\Models\Branch::where('id',auth()->user()->branch_id)->first()->name_ar); ?></p>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        
        <?php
            $locale = Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
        ?>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('لوحة-التحكم')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('index')); ?>" class="nav-link <?php echo e(request()->is($locale.'') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            <?php echo e(trans('admin.dashboard')); ?>

                        </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-السنوات-المالية')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('financial_years')); ?>" class="nav-link <?php echo e(request()->is($locale.'financial-years') ? 'active' : ''); ?>">
                       <i class="fas fa-calendar-alt"></i>
                        <p>
                            السنوات المالية
                        </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الاصول-الثابتة')): ?>
                     <li class="nav-item <?php echo e(request()->is($locale.'/assets*') ? 'menu-open' : ''); ?>">

                        <a href="#" class="nav-link">
                            <i class="fas fa-box"></i>
                            <p>
                                الأصول الثابتة
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('assets')); ?>" class="nav-link <?php echo e(request()->is($locale.'/assets') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة الأصول الثابتة
                                        
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item  <?php echo e(request()->is($locale.'/assets/depreciations*') ? 'menu-open' : ''); ?>">
                                <a href="<?php echo e(route('assets.depreciations')); ?>" class="nav-link <?php echo e(request()->is($locale.'/assets/depreciations') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة إهلاكات الأصول
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item  <?php echo e(request()->is($locale.'/assets/suppliers*') ? 'menu-open' : ''); ?>">
                                <a href="<?php echo e(route('assets_suppliers')); ?>" class="nav-link <?php echo e(request()->is($locale.'/assets/suppliers') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        موردين الأصول
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  <?php echo e(request()->is($locale.'/assets/sales*') ? 'menu-open' : ''); ?>">
                                <a href="<?php echo e(route('assets_sales')); ?>" class="nav-link <?php echo e(request()->is($locale.'/assets/sales') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        بيع الأصول
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-رأس-المال')): ?>
                     <li class="nav-item <?php echo e(request()->is($locale.'/capital*') ? 'menu-open' : ''); ?>">

                        <a href="#" class="nav-link">
                            <i class="fas fa-money-bill-wave-alt"></i>
                            <p>
                              حقوق الملكية
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('capitals')); ?>" class="nav-link <?php echo e(request()->is($locale.'/capital/capitals-list') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة رأس المال
                                        
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('capitals.devision')); ?>" class="nav-link <?php echo e(request()->is($locale.'/capital/devision') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                         حصة الفروع
                                        
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  <?php echo e(request()->is($locale.'/capital/benifits*') ? 'menu-open' : ''); ?>">
                                <a href="<?php echo e(route('partners')); ?>" class="nav-link <?php echo e(request()->is($locale.'/capital/partners') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة الشركاء
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  <?php echo e(request()->is($locale.'/capital/partners*') ? 'menu-open' : ''); ?>">
                                <a href="<?php echo e(route('partners.withdrawals')); ?>" class="nav-link <?php echo e(request()->is($locale.'/capital/partners-withdrawals') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        مسحوبات الشركاء
                                    </p>
                                </a>
                            </li>
                        </ul>
                        

                            
                        
                        </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تعديل-الاعدادت')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('settings.edit')); ?>" class="nav-link <?php echo e(request()->is('settings/update') ? 'active' : ''); ?>">
                            <i class="fa fa-cog nav-icon"></i>
                            <p><?php echo e(trans('admin.settings')); ?></p>
                        </a>

                    </li>

                <?php endif; ?>





                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-ورديات-الخزينة')): ?>

                <li class="nav-item <?php echo e(request()->is($locale.'/treasuries*') ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link">
                            <i class="fas fa-box"></i>
                            <p>
                                الخزن
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الخزن')): ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('treasuries')); ?>" class="nav-link <?php echo e(request()->is($locale.'/treasuries') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة الخزن
                                        
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-ورديات-الخزينة')): ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  <?php echo e(request()->is($locale.'/trasury*') ? 'menu-open' : ''); ?>">
                                <a href="<?php echo e(route('treasury_shifts')); ?>" class="nav-link <?php echo e(request()->is($locale.'/treasuries/shifts') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        <?php echo e(trans('admin.deliver_users_shifts')); ?>

                                        
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-حركات-الخزن')): ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('treasury.transactions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/treasuries/transactions') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        حركات نقدية الخزينة
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>

                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-البنوك')): ?>
                    <li class="nav-item <?php echo e(request()->is($locale.'/banks*') ? 'menu-open' : ''); ?>">
                            <a href="#" class="nav-link">
                                <i class="fas fa-dollar-sign"></i>
                                <p>
                                البنوك
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('banks')); ?>" class="nav-link <?php echo e(request()->is($locale.'/banks') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            قائمة البنوك
                                        </p>
                                    </a>
                                </li>
                            </ul>



                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('bank.transactions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/banks/transactions') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        حركات البنوك
                                    </p>
                                </a>
                            </li>
                        </ul>

                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الحسابات-البنكية')): ?>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('banks.accounts')); ?>" class="nav-link <?php echo e(request()->is($locale.'/banks-accounts') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        الحسابات البنكية
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>
                        

                    </li>
                <?php endif; ?>



                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('المشتريات')): ?>
                    <li class="nav-item <?php echo e(request()->is($locale.'/suppliers*') ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link">
                            <i class="fas fa-store"></i>
                            <p>
                                <?php echo e(trans('admin.purchases')); ?>

                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الموردين')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('suppliers')); ?>" class="nav-link <?php echo e(request()->is($locale.'/suppliers') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            <?php echo e(trans('admin.suppliers_list')); ?>

                                            
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-فواتير-الموردين')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('suppliers.invoices')); ?>" class="nav-link <?php echo e(request()->is($locale.'/suppliers/invoices') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            <?php echo e(trans('admin.suppliers_invoices')); ?>

                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-فاتورة-مورد')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('suppliers.create_invoice')); ?>" class="nav-link <?php echo e(request()->is($locale.'/suppliers/invoices/add') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            إضافة فاتورة
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-مردودات-الموردين')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('suppliers.returns')); ?>" class="nav-link <?php echo e(request()->is($locale.'/suppliers/invoices/returns') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            مردودات الموردين
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('المبيعات')): ?>
                    <li class="nav-item <?php echo e(request()->is($locale.'/customers*') ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                المبيعات
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-العملاء')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('customers')); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            <?php echo e(trans('admin.customers_list')); ?>

                                            
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-فواتير-العملاء')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('customers.invoices')); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers/invoices') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            فواتير العملاء
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            <?php endif; ?>
                             <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('اضافة-فاتورة-عميل')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('customers.create_invoice')); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers/invoices/add') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                             إضافة فاتورة
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-مردودات-العملاء')): ?>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.returns')); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers/returns') ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                               مردودات -إشعار دائن
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.create_invoice_return',['inv_num' => null])); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers/returns/add') ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                رد بند -إضافة إشعار دائن
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('customers.debit_notes',['inv_num' => null])); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers/invoices/debit_notes') ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                 إشعارات المدين
                                            </p>
                                        </a>
                                    </li>
                                   <li class="nav-item">
                                        <a href="<?php echo e(route('customers.create_debit_note')); ?>" class="nav-link <?php echo e(request()->is($locale.'/customers/invoices/debit_notes/add') ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                 إضافة إشعار مدين
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            <?php endif; ?>

                            

                    </li>
                <?php endif; ?>

                       

                        

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-التقارير')): ?>

                             <li class="nav-item <?php echo e(request()->is($locale.'/reports*') ? 'menu-open' : ''); ?>">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        التقارير
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-التقارير')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('reports.shortcomings')); ?>" class="nav-link <?php echo e(request()->is($locale.'/reports/products-shortcomings') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>  النواقص</p>
                                        </a>
                                    </li>
                                     <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-تقارير-حركات-الخزن')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('reports.treasuries_transactions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/reports/treasuries-transactions') ? 'active' : ''); ?>">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                حركات نقدية الخزينة
                                            </p>
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-تقارير-البنوك')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('reports.banks_transactions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/reports/banks-transactions') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>حركات البنوك</p>
                                        </a>
                                    </li>
                                     <?php endif; ?>

                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-المخزون')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('reports.inventories_transactions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/reports/inventories-transactions') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p> حركات المخزون</p>
                                        </a>
                                    </li>
                                     <?php endif; ?>

                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('تقاير-المشتريات')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('reports.purchases')); ?>" class="nav-link <?php echo e(request()->is($locale.'/reports/purchases') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>المشتريات</p>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-تقارير-المبيعات')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('reports.sales')); ?>" class="nav-link <?php echo e(request()->is($locale.'/reports/sales') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>المبيعات</p>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>


                        

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('الحسابات')): ?>
                            <li class="nav-item <?php echo e(request()->is($locale.'/financial*') ? 'menu-open' : ''); ?>">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <p>
                                        <?php echo e(trans('admin.accounting_and_accounting_restrictions')); ?>

                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-مراكز-التكلفة')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('cost.centers')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/cost-centers') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> مراكز التكلفة</p>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الحسابات-المالية')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('financial_accounts')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/accounts') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>الشجرة المحاسبية</p>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-قيود-اليومية')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('journal_entries')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/journal-entries') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>قيود اليومية</p>
                                        </a>
                                    </li>
                                    
                                    <?php endif; ?>
                                   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-موازين-المراجعة')): ?>
                                        
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('trail_balance_before')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/trail-balance-before-final-statements') ? 'active' : ''); ?>">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>ميزان المراجعة بالفرع</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('uni_trail_balance_before')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/uni-trail-balance-before-final-statements') ? 'active' : ''); ?>">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>ميزان المراجعة الموحد</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمةالتسويات-الجردية')): ?>
                                    <li class="nav-item <?php echo e(request()->is($locale.'/financials/salaries/*') ? 'menu-is-opening menu-open' : ''); ?>">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>التسويات الجردية</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('treasuries_adjustment')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financials/adjustments/treasuries') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  تسوية الخزينة </p>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('الضرائب')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('taxes')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/taxes') ? 'active' : ''); ?>">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p> الضرائب(ربع سنوي)</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('adjust_taxes')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/taxes/adjusting') ? 'active' : ''); ?>">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p> تسوية الضرائب مع الهيأة</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قوائم-الدخل')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('income_list')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/income-list') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> قائمة الدخل</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('closing_entry')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/closing-entry') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>قيود الإقفال</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('net_profit')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/net-profit') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>صافي الأرباح أو الخسائر من قائمة الدخل </p>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قوائم-المركز-المالي')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('statement_of_financial_position')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/statement-of-financial-position') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>قائمة المركز المالي </p>
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-موازين-المراجعة')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('trail_balance_after')); ?>" class="nav-link <?php echo e(request()->is($locale.'/financial/trail-balance-after-final-statements') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> ميزان المراجعة بعد القوائم</p>
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الموظفين')): ?>
                            <li class="nav-item <?php echo e(request()->is($locale.'/users*') ? 'menu-open' : ''); ?>">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>
                                        الموظفين
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> قائمة الموظفين</p>
                                        </a>
                                    </li>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الرواتب')): ?>
                                    <li class="nav-item <?php echo e(request()->is($locale.'/users/salaries/*') ? 'menu-is-opening menu-open' : ''); ?>">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>الرواتب</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('users.salaries.current_year')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users/salaries/current-year') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  رواتب السنة الحالية</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('users.salaries.prev_years')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users/salaries/prev-years') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  رواتب سنوات سابقة  </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-المكافئات')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users.rewards')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users/rewards') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>المكافئات</p>
                                        </a>
                                    </li>
                                     <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الخصومات')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users.deductions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users/deductions') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>الخصومات</p>
                                        </a>
                                    </li>
                                     <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-السلف')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('users.advance_payments')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users/advance-payments') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>السلف</p>
                                        </a>
                                    </li>
                                     <?php endif; ?>


                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-انواع-الورديات')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('shifts_types')); ?>" class="nav-link <?php echo e(request()->is($locale.'/users/shifts-types') ? 'active' : ''); ?>">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>
                                          أنواع الورديات
                                            
                                        </p>
                                        </a>
                                    </li>
                                      <?php endif; ?>
                                    
                                </ul>
                            </li>
                        <?php endif; ?>



                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-المخازن')): ?>
                    <li class="nav-item <?php echo e(request()->is($locale.'/stores*') ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link">
                            <i class="fas fa-dolly-flatbed"></i>
                            <p>
                                المخازن
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('stores')); ?>" class="nav-link <?php echo e(request()->is($locale.'/stores') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            قائمة المخازن
                                            
                                        </p>
                                    </a>
                                </li>
                            </ul>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-تحويلات-المخازن')): ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('stores.transactions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/stores/transactions') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            التحويل بين المخازن
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        <?php endif; ?>
                        
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('stores.inventory')); ?>" class="nav-link <?php echo e(request()->is($locale.'/stores/inventory') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            المخزون
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        

                        <ul class="nav nav-treeview">
                                

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-جرد-المخزون')): ?>
                                    <li class="nav-item <?php echo e(request()->is($locale.'/stores/inventory-counts/*') ? 'menu-is-opening menu-open' : ''); ?>">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>جرد المخزون</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stores.inventory_counts')); ?>" class="nav-link <?php echo e(request()->is($locale.'/stores/inventory-counts/all') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>قائمة الجرد</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stores.create_inventory_count')); ?>" class="nav-link <?php echo e(request()->is($locale.'/stores/inventory-counts/create-all') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>    إضافة جرد كلي</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stores.create_selected_inventory_count')); ?>" class="nav-link <?php echo e(request()->is($locale.'/stores/inventory-counts/create-selected') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  اضافة جرد اصناف محددة  </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                        </ul>

                                

                    </li>

                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-التصنيفات')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('categories')); ?>" class="nav-link <?php echo e(request()->is($locale.'/categories*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                        <?php echo e(trans('admin.categories')); ?>

                        </p>
                        </a>

                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-المنتجات')): ?>

                       <li class="nav-item <?php echo e(request()->is($locale.'/products*') ? 'menu-open' : ''); ?>">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                المنتجات
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('products')); ?>" class="nav-link <?php echo e(request()->is($locale.'/products') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            قائمة المنتجات
                                            
                                        </p>
                                    </a>
                                </li>
                            </ul>


                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('products.commissions')); ?>" class="nav-link <?php echo e(request()->is($locale.'/products/commissions') ? 'active' : ''); ?>">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            منتجات العمولة
                                        </p>
                                    </a>
                                </li>
                            </ul>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-العروض')): ?>
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo e(route('products.offers')); ?>" class="nav-link <?php echo e(request()->is($locale.'/products/offers') ? 'active' : ''); ?>">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        عروض المنتجات
                                    </p>
                                </a>
                            </li>
                            </ul>
                            <?php endif; ?>

                    </li>
                <?php endif; ?>



                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-المهام')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('roles')); ?>"  class="nav-link <?php echo e(request()->is($locale.'/roles') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            <?php echo e(trans('admin.roles_permissions')); ?>

                            
                        </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الفروع')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('branches')); ?>" class="nav-link <?php echo e(request()->is($locale.'/branches') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            <?php echo e(trans('admin.branches')); ?>

                            
                        </p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('قائمة-الوحدات')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('units')); ?>" class="nav-link <?php echo e(request()->is($locale.'/units') ? 'active' : ''); ?>">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            <?php echo e(trans('admin.units')); ?>

                        </p>
                        </a>
                    </li>
                <?php endif; ?>


                <li class="nav-item <?php echo e(request()->is('user*') ? 'menu-open' : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            <?php echo e(trans('admin.profile')); ?>

                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('user.edit_profile')); ?>" class="nav-link <?php echo e(request()->is('user/edit-profile') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-plus text-warning"></i>
                            <p>تعديل الملف الشخصي</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('user.edit_password')); ?>" class="nav-link <?php echo e(request()->is('user/change-password') ? 'active' : ''); ?>">
                            <i class="nav-icon fas fa-plus text-info"></i>
                            <p>تعديل كلمة السر</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"  onclick="document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-plus text-danger"></i>
                            <p>تسجيل الخروج</p>
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH D:\laragon\www\pharma\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>