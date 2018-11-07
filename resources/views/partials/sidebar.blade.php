<aside class="sidebar sidebar-left">
    <div class="sidebar-content">
        <div class="aside-toolbar">
            <ul class="site-logo">
                <li>
                    <a href="{{ url('/') }}">
                        <div class="logo">
                            
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <nav class="main-menu">
            <ul class="nav metismenu">
                <li class="{{ Request::is('dashboard') ? ' active' : null }}">
                    <a class="has-arrow" href="/dashboard" aria-expanded="false">
                        <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i>
                        <span data-localize="sidebar_dashboard">Dashboard</span>
                    </a>
                </li>

                <?php
                    $json = json_encode($user_access);
                    $array = json_decode($json, true);
                    $category = array_column($array, 'module_category');
                    $mod_code = array_column($array, 'module_code');
                    $url = ''; $local='';
                ?>

                @if (Auth::check() and (Auth::user()->user_type == 'Owner' or Auth::user()->user_type == 'Employee' or Auth::user()->user_type == 'Administrator'))

                    @if(in_array('POS', $category))
                        @foreach ($user_access as $key => $access)
                            @if($access->module_code == 'POS_CTRL')
                                <?php
                                    $url = 'pos';
                                    $local = 'data-localize="sidebar_pos_control"';
                                ?>
                                <li class="{{ Request::is($url) ? ' active' : null }}">
                                    <a class="has-arrow" href="{{ url($url) }}" aria-expanded="false">
                                        <i class="{{ $access->icon }}"></i>
                                        <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif


                    @if(in_array('Customers', $category))
                        <li class="nav-dropdown {{ Request::is('customer-list') || Request::is('membership') ? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-accounts zmdi-hc-fw"></i>
                                <span data-localize="sidebar_customers">Customers</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'CUS_LST')
                                        <?php
                                            $url = 'customer-list';
                                            $local = 'data-localize="customer_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'CUS_MEM')
                                        <?php
                                            $url = 'membership';
                                            $local = 'data-localize="membership_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif


                    @if(in_array('Inventory', $category))
                        <li class="nav-dropdown {{ Request::is('receive-items') || Request::is('inventory-list') || Request::is('update-inventory') || Request::is('summary-list')? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-label zmdi-hc-fw"></i>
                                <span data-localize="sidebar_inventories">Inventories</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'INV_LST')
                                        <?php
                                            $url = 'inventory-list';
                                            $local = 'data-localize="inventory_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'SUM_LST')
                                        <?php
                                            $url = 'summary-list';
                                            $local = 'data-localize="summary_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'RCV_ITM')
                                        <?php
                                            $url = 'receive-items';
                                            $local = 'data-localize="receive_items_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'UPD_INV')
                                        <?php
                                            $url = 'update-inventory';
                                            $local = 'data-localize="update_inventory_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif


                    @if(in_array('Employee', $category))
                        <li class="nav-dropdown {{ Request::is('employee') ? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-accounts-list zmdi-hc-fw"></i>
                                <span data-localize="sidebar_employees">Employees</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'EMP_LST')
                                        <?php
                                            $url = 'employee-list';
                                            $local = 'data-localize="employee_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'EMP_REG')
                                        <?php
                                            $url = 'employee';
                                            $local = 'data-localize="registration_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif


                    @if(in_array('Product', $category))
                        <li class="nav-dropdown {{ Request::is('products') || Request::is('add-products') ? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-shopping-basket zmdi-hc-fw"></i>
                                <span data-localize="sidebar_products">Products</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'PRD_LST')
                                        <?php
                                            $url = 'products';
                                            $local = 'data-localize="product_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'PRD_REG')
                                        <?php
                                            $url = 'add-products';
                                            $local = 'data-localize="add_product_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif


                    @if(in_array('Settings', $category))
                        <li class="nav-dropdown {{ Request::is('general-settings') || Request::is('dropdown') ? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-settings zmdi-hc-fw"></i>
                                <span data-localize="sidebar_settings">Settings</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'GEN_SET')
                                        <?php
                                            $url = 'general-settings';
                                            $local = 'data-localize="genset_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'DRP_SET')
                                        <?php
                                            $url = 'dropdown';
                                            $local = 'data-localize="dropdown_title"';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span <?php echo $local; ?>>{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif

                @if (Auth::check() and Auth::user()->user_type == 'Administrator')
                    <li class="{{ Request::is('admin/module') ? ' active' : null }}">
                        <a class="has-arrow" href="{{ url('/admin/module') }}" aria-expanded="false">
                            <i class="zmdi zmdi-menu zmdi-hc-fw"></i>
                            <span>Modules</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('admin/transaction-codes') ? ' active' : null }}">
                        <a class="has-arrow" href="{{ url('/admin/transaction-codes') }}" aria-expanded="false">
                            <i class="zmdi zmdi-code zmdi-hc-fw"></i>
                            <span>Transaction Codes</span>
                        </a>
                    </li>
                @endif
                    
            </ul>
        </nav>
    </div>
</aside>