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
                        <span>Dashboard</span>
                    </a>
                </li>

                @if (Auth::check() and Auth::user()->user_type == 'Owner')
                    <li class="nav-dropdown {{ Request::is('customer-list') || Request::is('membership') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-accounts zmdi-hc-fw"></i>
                            <span>Customers</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('customer-list') ? ' active' : null }}">
                                <a href="{{ url('customer-list') }}">
                                    <span>Customer List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('membership') ? ' active' : null }}">
                                <a href="{{ url('membership') }}">
                                    <span>Membership</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-dropdown {{ Request::is('receive-items') || Request::is('inventory-list') || Request::is('update-inventory') || Request::is('summary-list')? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-label zmdi-hc-fw"></i>
                            <span>Inventories</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('inventory-list') ? ' active' : null }}">
                                <a href="{{ url('inventory-list') }}">
                                    <span>Inventory List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('summary-list') ? ' active' : null }}">
                                <a href="{{ url('summary-list') }}">
                                    <span>Summary List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('update-inventory') ? ' active' : null }}">
                                <a href="{{ url('update-inventory') }}">
                                    <span>Update Inventory</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('receive-items') ? ' active' : null }}">
                                <a href="{{ url('receive-items') }}">
                                    <span>Receive Items</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-dropdown {{ Request::is('admin/employee-list') || Request::is('admin/add-employee') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-accounts-list zmdi-hc-fw"></i>
                            <span>Employee</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('admin/employee-list') ? ' active' : null }}">
                                <a href="{{ url('admin.employee-list') }}">
                                    <span>Employee List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/add-employee') ? ' active' : null }}">
                                <a href="{{ url('admin.add-employee') }}">
                                    <span>Add Employee</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-dropdown {{ Request::is('admin/products') || Request::is('admin/add-products') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-shopping-basket zmdi-hc-fw"></i>
                            <span>Products</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('admin/products') ? ' active' : null }}">
                                <a href="{{ url('admin.products') }}">
                                    <span>Products List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/add-products') ? ' active' : null }}">
                                <a href="{{ url('admin.add-products') }}">
                                    <span>Add Products</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-dropdown {{ Request::is('admin/general-settings') || Request::is('admin/dropdown') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-settings zmdi-hc-fw"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('admin/general-settings') ? ' active' : null }}">
                                <a href="{{ url('admin.general-settings') }}">
                                    <span>General Settings</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/dropdown') ? ' active' : null }}">
                                <a href="{{ url('admin.dropdown') }}">
                                    <span>Dropdown Settings</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth::check() and Auth::user()->user_type == 'Employee')
                    <li class="{{ Request::is('employee/pos') ? ' active' : null }}">
                        <a class="has-arrow" href="{{ url('pos') }}" aria-expanded="false">
                            <i class="zmdi zmdi-menu zmdi-hc-fw"></i>
                            <span>POS Control</span>
                        </a>
                    </li>
                    <li class="nav-dropdown {{ Request::is('customer-list') || Request::is('membership') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-accounts zmdi-hc-fw"></i>
                            <span>Customers</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('customer-list') ? ' active' : null }}">
                                <a href="{{ url('customer-list') }}">
                                    <span>Customer List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('membership') ? ' active' : null }}">
                                <a href="{{ url('membership') }}">
                                    <span>Membership</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Request::is('receive-items') || Request::is('inventory-list') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-label zmdi-hc-fw"></i>
                            <span>Inventories</span>
                        </a>
                        <ul class="collapse nav-sub" aria-expanded="false">
                            <li class="{{ Request::is('inventory-list') ? ' active' : null }}">
                                <a href="{{ url('inventory-list') }}">
                                    <span>Inventory List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('summary-list') ? ' active' : null }}">
                                <a href="{{ url('summary-list') }}">
                                    <span>Summary List</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('receive-items') ? ' active' : null }}">
                                <a href="{{ url('receive-items') }}">
                                    <span>Receive Items</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-dropdown {{ Request::is('employee/sales-report') ? ' active' : null }}">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <i class="zmdi zmdi-file zmdi-hc-fw"></i>
                            <span>Reports</span>
                        </a>
                        <ul class="collapse nav-sub">
                            <li class="{{ Request::is('employee/sales-report') ? ' active' : null }}">
                                <a href="{{ url('employee.sales-report') }}">
                                    <span>Sales Report</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (Auth::check() and Auth::user()->user_type == 'Customer')
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