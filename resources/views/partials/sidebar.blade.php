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
                        <span class="trn">Dashboard</span>
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
                                    $url = 'pos-control';
                                ?>
                                <li class="{{ Request::is($url) ? ' active' : null }}">
                                    <a class="has-arrow" href="{{ url($url) }}" aria-expanded="false">
                                        <i class="{{ $access->icon }}"></i>
                                        <span class="trn">POS Control</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif


                    @if(in_array('Customers', $category))
                        <li class="nav-dropdown {{ Request::is('customer-list') || Request::is('membership') ? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-accounts zmdi-hc-fw"></i>
                                <span class="trn">Customers</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'CUS_LST')
                                        <?php
                                            $url = 'customer-list';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">Customer List</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'CUS_MEM')
                                        <?php
                                            $url = 'membership';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">Membership</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif


                    @if(in_array('Inventory', $category))
                        <li class="nav-dropdown {{ Request::is('receive-items') || Request::is('inventory-list') || Request::is('update-inventory') || Request::is('summary-list') || Request::is('item-output')? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-label zmdi-hc-fw"></i>
                                <span class="trn">Inventories</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'INV_LST')
                                        <?php
                                            $url = 'inventory-list';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'SUM_LST')
                                        <?php
                                            $url = 'summary-list';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'RCV_ITM')
                                        <?php
                                            $url = 'receive-items';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'UPD_INV')
                                        <?php
                                            $url = 'update-inventory';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'ITM_OUT')
                                        <?php
                                            $url = 'item-output';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
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
                                <span class="trn">Employees</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'EMP_LST')
                                        <?php
                                            $url = 'employee-list';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'EMP_REG')
                                        <?php
                                            $url = 'employee';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
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
                                <span class="trn">Products</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'PRD_LST')
                                        <?php
                                            $url = 'product-list';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'PRD_REG')
                                        <?php
                                            $url = 'add-products';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
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
                                <span class="trn">Settings</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'GEN_SET')
                                        <?php
                                            $url = 'general-settings';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if($access->module_code == 'DRP_SET')
                                        <?php
                                            $url = 'dropdown';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif

                    @if(in_array('Reports', $category))
                        <li class="nav-dropdown {{ Request::is('general-settings') || Request::is('dropdown') ? ' active' : null }}">
                            <a class="has-arrow" href="#" aria-expanded="false">
                                <i class="zmdi zmdi-file zmdi-hc-fw"></i>
                                <span class="trn">Reports</span>
                            </a>
                            <ul class="collapse nav-sub" aria-expanded="false">
                                @foreach ($user_access as $key => $access)
                                    @if($access->module_code == 'SAL_RPT')
                                        <?php
                                            $url = 'sales-report';
                                        ?>
                                        <li class="{{ Request::is($url) ? ' active' : null }}">
                                            <a href="{{ url($url) }}">
                                                <span class="trn">{{ $access->module_name }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endif

                @if (Auth::check() and Auth::user()->user_type == 'Administrator')
                    <li class="nav-dropdown {{ Request::is('admin/user-master') || Request::is('admin/module') || Request::is('admin/transaction-codes') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-code zmdi-hc-fw"></i>
                            <span>Admin Panel</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('admin/user-master') ? ' active' : null }}">
                                <a href="{{ url('/admin/user-master') }}">
                                    <span>User Master</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/module') ? ' active' : null }}">
                                <a href="{{ url('/admin/module') }}">
                                    <span>Modules</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/transaction-codes') ? ' active' : null }}">
                                <a href="{{ url('/admin/transaction-codes') }}">
                                    <span>Transaction Codes</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                    
            </ul>
        </nav>
    </div>
</aside>