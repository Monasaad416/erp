<aside class="main-sidebar sidebar-dark-light elevation-4">
    {{-- <aside class="main-sidebar sidebar-dark-light elevation-4" style="background-color: rgb(57 85 121)"> --}}



    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

    <span class="brand-text font-weight-light"><img src=""></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="{{ url('dashboard/assets/img/avatar6.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                <p class="text-white">{{ App\Models\Branch::where('id',auth()->user()->branch_id)->first()->name_ar }}</p>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
            </div>
        </div> --}}
        @php
            $locale = Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
        @endphp

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                @can('لوحة-التحكم')
                    <li class="nav-item">
                        <a href="{{ route('index') }}" class="nav-link {{ request()->is($locale.'') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{trans('admin.dashboard')}}
                        </p>
                        </a>
                    </li>
                @endcan
                @can('قائمة-السنوات-المالية')
                    <li class="nav-item">
                        <a href="{{ route('financial_years') }}" class="nav-link {{ request()->is($locale.'financial-years') ? 'active' : '' }}">
                       <i class="fas fa-calendar-alt"></i>
                        <p>
                            السنوات المالية
                        </p>
                        </a>
                    </li>
                @endcan
                @can('قائمة-الاصول-الثابتة')
                     <li class="nav-item {{ request()->is($locale.'/assets*') ? 'menu-open' : '' }}">

                        <a href="#" class="nav-link">
                            <i class="fas fa-box"></i>
                            <p>
                                الأصول الثابتة
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('assets')}}" class="nav-link {{ request()->is($locale.'/assets') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة الأصول الثابتة
                                        {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item  {{ request()->is($locale.'/assets/depreciations*') ? 'menu-open' : '' }}">
                                <a href="{{route('assets.depreciations')}}" class="nav-link {{ request()->is($locale.'/assets/depreciations') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة إهلاكات الأصول
                                    </p>
                                </a>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item  {{ request()->is($locale.'/assets/suppliers*') ? 'menu-open' : '' }}">
                                <a href="{{route('assets_suppliers')}}" class="nav-link {{ request()->is($locale.'/assets/suppliers') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        موردين الأصول
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  {{ request()->is($locale.'/assets/sales*') ? 'menu-open' : '' }}">
                                <a href="{{route('assets_sales')}}" class="nav-link {{ request()->is($locale.'/assets/sales') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        بيع الأصول
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('قائمة-رأس-المال')
                     <li class="nav-item {{ request()->is($locale.'/capital*') ? 'menu-open' : '' }}">

                        <a href="#" class="nav-link">
                            <i class="fas fa-money-bill-wave-alt"></i>
                            <p>
                              حقوق الملكية
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('capitals')}}" class="nav-link {{ request()->is($locale.'/capital/capitals-list') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة رأس المال
                                        {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('capitals.devision')}}" class="nav-link {{ request()->is($locale.'/capital/devision') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                         حصة الفروع
                                        {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  {{ request()->is($locale.'/capital/benifits*') ? 'menu-open' : '' }}">
                                <a href="{{route('partners')}}" class="nav-link {{ request()->is($locale.'/capital/partners') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة الشركاء
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item  {{ request()->is($locale.'/capital/partners*') ? 'menu-open' : '' }}">
                                <a href="{{route('partners.withdrawals')}}" class="nav-link {{ request()->is($locale.'/capital/partners-withdrawals') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        مسحوبات الشركاء
                                    </p>
                                </a>
                            </li>
                        </ul>
                        {{-- @endcan --}}

                            {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('customers.pos')}}" class="nav-link {{ request()->is($locale.'/customers/exchange/pos') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                           إستبدال النقاط
                                        </p>
                                    </a>
                                </li>
                            </ul> --}}
                        {{-- @endcan --}}
                        </li>
                @endcan
                @can('تعديل-الاعدادت')
                    <li class="nav-item">
                        <a href="{{ route('settings.edit') }}" class="nav-link {{ request()->is('settings/update') ? 'active' : '' }}">
                            <i class="fa fa-cog nav-icon"></i>
                            <p>{{trans('admin.settings')}}</p>
                        </a>

                    </li>
{{--
                    <li class="nav-item">
                        <a href="{{ route('zatca_settings.create') }}" class="nav-link {{ request()->is('zatca_settings/create') ? 'active' : '' }}">
                            <i class="fa fa-cog nav-icon"></i>
                            <p>إعدادات الزكاة والضريبة والجمارك</p>
                        </a>

                    </li> --}}
                @endcan





                @can('قائمة-ورديات-الخزينة')

                <li class="nav-item {{ request()->is($locale.'/treasuries*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-box"></i>
                            <p>
                                الخزن
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @can('قائمة-الخزن')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('treasuries')}}" class="nav-link {{ request()->is($locale.'/treasuries') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        قائمة الخزن
                                        {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endcan

                        @can('قائمة-ورديات-الخزينة')
                        <ul class="nav nav-treeview">
                            <li class="nav-item  {{ request()->is($locale.'/trasury*') ? 'menu-open' : '' }}">
                                <a href="{{route('treasury_shifts')}}" class="nav-link {{ request()->is($locale.'/treasuries/shifts') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        {{trans('admin.deliver_users_shifts')}}
                                        {{-- <span class="badge badge-info right">{{ App\Models\Category::count() }}</span> --}}
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endcan
                        @can('قائمة-حركات-الخزن')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('treasury.transactions')}}" class="nav-link {{ request()->is($locale.'/treasuries/transactions') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        حركات نقدية الخزينة
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endcan

                    </li>
                @endcan
                @can('قائمة-البنوك')
                    <li class="nav-item {{ request()->is($locale.'/banks*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="fas fa-dollar-sign"></i>
                                <p>
                                البنوك
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('banks')}}" class="nav-link {{ request()->is($locale.'/banks') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            قائمة البنوك
                                        </p>
                                    </a>
                                </li>
                            </ul>



                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('bank.transactions')}}" class="nav-link {{ request()->is($locale.'/banks/transactions') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        حركات البنوك
                                    </p>
                                </a>
                            </li>
                        </ul>

                        {{-- @can('اضافة-حركة-بنك')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('bank.transactions.create')}}" class="nav-link {{ request()->is($locale.'/banks/transactions/create') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        إضافة حركة
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endcan --}}
                        @can('قائمة-الحسابات-البنكية')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('banks.accounts')}}" class="nav-link {{ request()->is($locale.'/banks-accounts') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        الحسابات البنكية
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endcan
                        {{-- @can('اضافة-حساب-بنكي')
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('banks.accounts.create')}}" class="nav-link {{ request()->is($locale.'/banks-accounts/create') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        إضافة حساب بنكي
                                    </p>
                                </a>
                            </li>
                        </ul>
                        @endcan --}}

                    </li>
                @endcan



                @can('المشتريات')
                    <li class="nav-item {{ request()->is($locale.'/suppliers*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-store"></i>
                            <p>
                                {{ trans('admin.purchases') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @can('قائمة-الموردين')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('suppliers')}}" class="nav-link {{ request()->is($locale.'/suppliers') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            {{trans('admin.suppliers_list')}}
                                            {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('قائمة-فواتير-الموردين')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('suppliers.invoices')}}" class="nav-link {{ request()->is($locale.'/suppliers/invoices') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            {{trans('admin.suppliers_invoices')}}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('اضافة-فاتورة-مورد')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('suppliers.create_invoice') }}" class="nav-link {{ request()->is($locale.'/suppliers/invoices/add') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            إضافة فاتورة
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('قائمة-مردودات-الموردين')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('suppliers.returns') }}" class="nav-link {{ request()->is($locale.'/suppliers/invoices/returns') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            مردودات الموردين
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                    </li>
                @endcan

                @can('المبيعات')
                    <li class="nav-item {{ request()->is($locale.'/customers*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                المبيعات
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @can('قائمة-العملاء')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('customers')}}" class="nav-link {{ request()->is($locale.'/customers') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            {{trans('admin.customers_list')}}
                                            {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        @can('قائمة-فواتير-العملاء')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('customers.invoices')}}" class="nav-link {{ request()->is($locale.'/customers/invoices') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            فواتير العملاء
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            @endcan
                             @can('اضافة-فاتورة-عميل')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('customers.create_invoice')}}" class="nav-link {{ request()->is($locale.'/customers/invoices/add') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                             إضافة فاتورة
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                            @can('قائمة-مردودات-العملاء')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('customers.returns')}}" class="nav-link {{ request()->is($locale.'/customers/returns') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                               مردودات -إشعار دائن
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('customers.create_invoice_return',['inv_num' => null])}}" class="nav-link {{ request()->is($locale.'/customers/returns/add') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                رد بند -إضافة إشعار دائن
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('customers.debit_notes',['inv_num' => null])}}" class="nav-link {{ request()->is($locale.'/customers/invoices/debit_notes') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                 إشعارات المدين
                                            </p>
                                        </a>
                                    </li>
                                   <li class="nav-item">
                                        <a href="{{route('customers.create_debit_note')}}" class="nav-link {{ request()->is($locale.'/customers/invoices/debit_notes/add') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                 إضافة إشعار مدين
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            @endcan

                            {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('customers.pos')}}" class="nav-link {{ request()->is($locale.'/customers/exchange/pos') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                           إستبدال النقاط
                                        </p>
                                    </a>
                                </li>
                            </ul> --}}

                    </li>
                @endcan

                       {{-- <li class="nav-item">
                            <a href="" class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                {{trans('admin.roles_permissions')}}

                            </p>
                            </a>

                        </li> --}}

                        {{-- <li class="nav-item">
                            <a href="{{route('stores')}}" class="nav-link {{ request()->is($locale.'/stores*') ? 'active' : '' }}">
                                <i class="fas fa-store"></i>
                                <p>
                                    {{trans('admin.stores')}}
                                </p>
                            </a>
                        </li> --}}

                        @can('قائمة-التقارير')

                             <li class="nav-item {{ request()->is($locale.'/reports*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        التقارير
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                     @can('قائمة-التقارير')
                                    <li class="nav-item">
                                        <a href="{{route('reports.shortcomings')}}" class="nav-link {{ request()->is($locale.'/reports/products-shortcomings') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>  النواقص</p>
                                        </a>
                                    </li>
                                     @endcan

                                    @can('قائمة-تقارير-حركات-الخزن')
                                    <li class="nav-item">
                                        <a href="{{route('reports.treasuries_transactions')}}" class="nav-link {{ request()->is($locale.'/reports/treasuries-transactions') ? 'active' : '' }}">
                                            <i class="nav-icon fas fa-plus text-info"></i>
                                            <p>
                                                حركات نقدية الخزينة
                                            </p>
                                        </a>
                                    </li>
                                    @endcan

                                     @can('قائمة-تقارير-البنوك')
                                    <li class="nav-item">
                                        <a href="{{route('reports.banks_transactions')}}" class="nav-link {{ request()->is($locale.'/reports/banks-transactions') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>حركات البنوك</p>
                                        </a>
                                    </li>
                                     @endcan

                                     @can('قائمة-المخزون')
                                    <li class="nav-item">
                                        <a href="{{route('reports.inventories_transactions')}}" class="nav-link {{ request()->is($locale.'/reports/inventories-transactions') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p> حركات المخزون</p>
                                        </a>
                                    </li>
                                     @endcan

                                     @can('تقاير-المشتريات')
                                    <li class="nav-item">
                                        <a href="{{route('reports.purchases')}}" class="nav-link {{ request()->is($locale.'/reports/purchases') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>المشتريات</p>
                                        </a>
                                    </li>
                                    @endcan
                                     @can('قائمة-تقارير-المبيعات')
                                    <li class="nav-item">
                                        <a href="{{route('reports.sales')}}" class="nav-link {{ request()->is($locale.'/reports/sales') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>المبيعات</p>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan


                        {{-- <li class="nav-item {{ request()->is('invoices*') ? 'menu-open active' : '' }}">
                            <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                فواتير الجرد
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{ App\Models\Page::count() }}</span>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('invoices')}}" class="nav-link {{ request()->is('invoices') ? 'active' : '' }}">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>  قائمة الفواتير</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('invoices.create')}}" class="nav-link {{ request()->is('invoices/create') ? 'active' : '' }}">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> إضافة فاتوره</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}

                        @can('الحسابات')
                            <li class="nav-item {{ request()->is($locale.'/financial*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <p>
                                        {{ trans('admin.accounting_and_accounting_restrictions') }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('قائمة-مراكز-التكلفة')
                                    <li class="nav-item">
                                        <a href="{{route('cost.centers')}}" class="nav-link {{ request()->is($locale.'/financial/cost-centers') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> مراكز التكلفة</p>
                                        </a>
                                    </li>
                                    @endcan
                                    {{-- <li class="nav-item">
                                        <a href="{{route('financial_accounts_types')}}" class="nav-link {{ request()->is($locale.'/financial/accounts-types') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> {{trans('admin.accounts_types')}}</p>
                                        </a>
                                    </li> --}}
                                    @can('قائمة-الحسابات-المالية')
                                    <li class="nav-item">
                                        <a href="{{route('financial_accounts')}}" class="nav-link {{ request()->is($locale.'/financial/accounts') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>الشجرة المحاسبية</p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('قائمة-قيود-اليومية')
                                    <li class="nav-item">
                                        <a href="{{route('journal_entries')}}" class="nav-link {{ request()->is($locale.'/financial/journal-entries') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>قيود اليومية</p>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="{{route('t_accounts')}}" class="nav-link {{ request()->is($locale.'/financial/t-accounts') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>  الاستاذ المساعد</p>
                                        </a>
                                    </li> --}}
                                    @endcan
                                   @can('قائمة-موازين-المراجعة')
                                        {{-- <li class="nav-item">
                                            <a href="{{route('end_year_account_statement')}}" class="nav-link {{ request()->is($locale.'/financial/end-year-account-statements') ? 'active' : '' }}">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>كشف حساب نهاية الفترة</p>
                                            </a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a href="{{route('trail_balance_before')}}" class="nav-link {{ request()->is($locale.'/financial/trail-balance-before-final-statements') ? 'active' : '' }}">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>ميزان المراجعة بالفرع</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('uni_trail_balance_before')}}" class="nav-link {{ request()->is($locale.'/financial/uni-trail-balance-before-final-statements') ? 'active' : '' }}">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>ميزان المراجعة الموحد</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قائمةالتسويات-الجردية')
                                    <li class="nav-item {{ request()->is($locale.'/financials/salaries/*') ? 'menu-is-opening menu-open' : '' }}">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>التسويات الجردية</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{route('treasuries_adjustment')}}" class="nav-link {{ request()->is($locale.'/financials/adjustments/treasuries') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  تسوية الخزينة </p>
                                                </a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a href="{{route('financials.adjustments.prev_years')}}" class="nav-link {{ request()->is($locale.'/financials/adjustments/prev-years') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>تسوية البنوك</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('financials.adjustments.prev_years')}}" class="nav-link {{ request()->is($locale.'/financials/adjustments/treasuries') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>تسوية مخزون</p>
                                                </a>
                                            </li>
                                           <li class="nav-item">
                                                <a href="{{route('financials.adjustments.prev_years')}}" class="nav-link {{ request()->is($locale.'/financials/adjustments/prev-years') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>تسوية العملاء</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('financials.adjustments.prev_years')}}" class="nav-link {{ request()->is($locale.'/financials/adjustments/prev-years') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>تسوية الايرادات</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('financials.adjustments.prev_years')}}" class="nav-link {{ request()->is($locale.'/financials/adjustments/prev-years') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>تسوية المصروفات</p>
                                                </a>
                                            </li> --}}
                                        </ul>
                                    </li>
                                    @endcan
                                    @can('الضرائب')
                                        <li class="nav-item">
                                            <a href="{{route('taxes')}}" class="nav-link {{ request()->is($locale.'/financial/taxes') ? 'active' : '' }}">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p> الضرائب(ربع سنوي)</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('adjust_taxes')}}" class="nav-link {{ request()->is($locale.'/financial/taxes/adjusting') ? 'active' : '' }}">
                                            <i class="nav-icon fa fa-plus text-info"></i>
                                            <p> تسوية الضرائب مع الهيأة</p>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('قوائم-الدخل')
                                    <li class="nav-item">
                                        <a href="{{route('income_list')}}" class="nav-link {{ request()->is($locale.'/financial/income-list') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> قائمة الدخل</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('closing_entry')}}" class="nav-link {{ request()->is($locale.'/financial/closing-entry') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>قيود الإقفال</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('net_profit')}}" class="nav-link {{ request()->is($locale.'/financial/net-profit') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>صافي الأرباح أو الخسائر من قائمة الدخل </p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('قوائم-المركز-المالي')
                                    <li class="nav-item">
                                        <a href="{{route('statement_of_financial_position')}}" class="nav-link {{ request()->is($locale.'/financial/statement-of-financial-position') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>قائمة المركز المالي </p>
                                        </a>
                                    </li>
                                    @endcan

                                    @can('قائمة-موازين-المراجعة')
                                    <li class="nav-item">
                                        <a href="{{route('trail_balance_after')}}" class="nav-link {{ request()->is($locale.'/financial/trail-balance-after-final-statements') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> ميزان المراجعة بعد القوائم</p>
                                        </a>
                                    </li>
                                    @endcan

                                </ul>
                            </li>
                        @endcan

                        @can('قائمة-الموظفين')
                            <li class="nav-item {{ request()->is($locale.'/users*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <p>
                                        الموظفين
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('users')}}" class="nav-link {{ request()->is($locale.'/users') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p> قائمة الموظفين</p>
                                        </a>
                                    </li>
                                    @can('قائمة-الرواتب')
                                    <li class="nav-item {{ request()->is($locale.'/users/salaries/*') ? 'menu-is-opening menu-open' : '' }}">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>الرواتب</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{route('users.salaries.current_year')}}" class="nav-link {{ request()->is($locale.'/users/salaries/current-year') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  رواتب السنة الحالية</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('users.salaries.prev_years')}}" class="nav-link {{ request()->is($locale.'/users/salaries/prev-years') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  رواتب سنوات سابقة  </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    @endcan
                                    @can('قائمة-المكافئات')
                                    <li class="nav-item">
                                        <a href="{{route('users.rewards')}}" class="nav-link {{ request()->is($locale.'/users/rewards') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>المكافئات</p>
                                        </a>
                                    </li>
                                     @endcan

                                    @can('قائمة-الخصومات')
                                    <li class="nav-item">
                                        <a href="{{route('users.deductions')}}" class="nav-link {{ request()->is($locale.'/users/deductions') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>الخصومات</p>
                                        </a>
                                    </li>
                                     @endcan

                                    @can('قائمة-السلف')
                                    <li class="nav-item">
                                        <a href="{{route('users.advance_payments')}}" class="nav-link {{ request()->is($locale.'/users/advance-payments') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>السلف</p>
                                        </a>
                                    </li>
                                     @endcan


                                     @can('قائمة-انواع-الورديات')
                                    <li class="nav-item">
                                        <a href="{{route('shifts_types')}}" class="nav-link {{ request()->is($locale.'/users/shifts-types') ? 'active' : '' }}">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                        <p>
                                          أنواع الورديات
                                            {{-- <span class="badge badge-info right">{{ App\Models\Category::count() }}</span> --}}
                                        </p>
                                        </a>
                                    </li>
                                      @endcan
                                    {{-- @can('قائمة-ورديات-الموظفين')
                                    <li class="nav-item {{ request()->is($locale.'/users/shifts/*') ? 'menu-is-opening menu-open' : '' }}">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>ورديات الموظفين</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                            <a href="{{route('users.shifts.current_year')}}" class="nav-link {{ request()->is($locale.'/users/shifts/current-year') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  ورديات السنة الحالية</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                            <a href="{{route('users.shifts.prev_years')}}" class="nav-link {{ request()->is($locale.'/users/shifts/prev-years') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  ورديات سنوات سابقة  </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    @endcan --}}
                                </ul>
                            </li>
                        @endcan



                 @can('قائمة-المخازن')
                    <li class="nav-item {{ request()->is($locale.'/stores*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="fas fa-dolly-flatbed"></i>
                            <p>
                                المخازن
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('stores')}}" class="nav-link {{ request()->is($locale.'/stores') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            قائمة المخازن
                                            {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                        </p>
                                    </a>
                                </li>
                            </ul>

                        @can('قائمة-تحويلات-المخازن')
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('stores.transactions')}}" class="nav-link {{ request()->is($locale.'/stores/transactions') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            التحويل بين المخازن
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        @endcan
                        {{-- @can('مخزون-المنتجات') --}}
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('stores.inventory')}}" class="nav-link {{ request()->is($locale.'/stores/inventory') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            المخزون
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        {{-- @endcan --}}

                        <ul class="nav nav-treeview">
                                {{-- <li class="nav-item">
                                    <a href="{{route('stores.inventory_counts')}}" class="nav-link {{ request()->is($locale.'/stores/inventory-counts') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            جرد المخزون
                                        </p>
                                    </a>
                                </li> --}}

                                @can('قائمة-جرد-المخزون')
                                    <li class="nav-item {{ request()->is($locale.'/stores/inventory-counts/*') ? 'menu-is-opening menu-open' : '' }}">

                                        <a href="#" class="nav-link ">
                                        <i class="nav-icon fa fa-plus text-info"></i>
                                            <p>جرد المخزون</p>
                                            <i class="fas fa-angle-left right"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="{{route('stores.inventory_counts')}}" class="nav-link {{ request()->is($locale.'/stores/inventory-counts/all') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>قائمة الجرد</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{route('stores.create_inventory_count')}}" class="nav-link {{ request()->is($locale.'/stores/inventory-counts/create-all') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>    إضافة جرد كلي</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{route('stores.create_selected_inventory_count')}}" class="nav-link {{ request()->is($locale.'/stores/inventory-counts/create-selected') ? 'active' : '' }}">
                                                <i class="nav-icon fa fa-plus text-danger"></i>
                                                <p>  اضافة جرد اصناف محددة  </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                        </ul>

                                {{--

                        <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('stores.inventory_settlements')}}" class="nav-link {{ request()->is($locale.'/stores/inventory-settlements') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            تسوية المخزون
                                        </p>
                                    </a>
                                </li>
                            </ul> --}}

                    </li>

                @endcan
                @can('قائمة-التصنيفات')
                    <li class="nav-item">
                        <a href="{{route('categories')}}" class="nav-link {{ request()->is($locale.'/categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                        {{trans('admin.categories')}}
                        </p>
                        </a>

                    </li>
                @endcan

                @can('قائمة-المنتجات')

                       <li class="nav-item {{ request()->is($locale.'/products*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                المنتجات
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('products')}}" class="nav-link {{ request()->is($locale.'/products') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            قائمة المنتجات
                                            {{-- <span class="badge badge-success right">{{ App\Models\Category::count() }}</span> --}}
                                        </p>
                                    </a>
                                </li>
                            </ul>


                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('products.commissions')}}" class="nav-link {{ request()->is($locale.'/products/commissions') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-plus text-info"></i>
                                        <p>
                                            منتجات العمولة
                                        </p>
                                    </a>
                                </li>
                            </ul>

                            @can('قائمة-العروض')
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('products.offers')}}" class="nav-link {{ request()->is($locale.'/products/offers') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus text-info"></i>
                                    <p>
                                        عروض المنتجات
                                    </p>
                                </a>
                            </li>
                            </ul>
                            @endcan

                    </li>
                @endcan



                @can('قائمة-المهام')
                    <li class="nav-item">
                        <a href="{{ route('roles') }}"  class="nav-link {{ request()->is($locale.'/roles') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            {{trans('admin.roles_permissions')}}
                            {{-- <span class="badge badge-info right">{{ App\Models\Category::count() }}</span> --}}
                        </p>
                        </a>
                    </li>
                @endcan
                @can('قائمة-الفروع')
                    <li class="nav-item">
                        <a href="{{route('branches')}}" class="nav-link {{ request()->is($locale.'/branches') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>
                            {{trans('admin.branches')}}
                            {{-- <span class="badge badge-info right">{{ App\Models\Category::count() }}</span> --}}
                        </p>
                        </a>
                    </li>
                @endcan
                @can('قائمة-الوحدات')
                    <li class="nav-item">
                        <a href="{{ route('units') }}" class="nav-link {{ request()->is($locale.'/units') ? 'active' : '' }}">
                        <i class="nav-icon far fa-plus-square"></i>
                        <p>
                            {{trans('admin.units')}}
                        </p>
                        </a>
                    </li>
                @endcan


                <li class="nav-item {{ request()->is('user*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            {{ trans('admin.profile') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user.edit_profile')}}" class="nav-link {{ request()->is('user/edit-profile') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus text-warning"></i>
                            <p>تعديل الملف الشخصي</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user.edit_password')}}" class="nav-link {{ request()->is('user/change-password') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-plus text-info"></i>
                            <p>تعديل كلمة السر</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link"  onclick="document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-plus text-danger"></i>
                            <p>تسجيل الخروج</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
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
