<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="{{ route('my_account') }}"><img src="{{ Qs::getDefaultUserImage() }}" width="38" height="38" class="rounded-circle" alt="photo"></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ ucwords(str_replace('_', ' ', Auth::user()->user_type)) }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="{{ route('my_account') }}" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>LMS Dashboard</span>
                    </a>
                </li>
                
                
                
                
                
                
                
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['general-users.index', 'general-offices.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-office"></i><span> Administrative</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Administrative">

                        {{--Timetables--}}
                            <li class="nav-item"><a href="{{ route('general-users.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['general-users.index']) ? 'active' : '' }}">Users</a></li>
                            <li class="nav-item"><a href="{{ route('general-offices.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['general-offices.index']) ? 'active' : '' }}">Offices</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['fin-general-ledgers.index','fin-chart-of-accounts.index','fin-banks-accounts.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-cash"></i> <span> Finance</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Finance">

                        {{--Timetables--}}
                            <li class="nav-item"><a href="{{ route('fin-general-ledgers.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['fin-general-ledgers.index']) ? 'active' : '' }}">General Ledger</a></li>
                            <li class="nav-item"><a href="{{ route('fin-chart-of-accounts.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['fin-chart-of-accounts.index']) ? 'active' : '' }}">Chart of Accounts</a></li>
                            <li class="nav-item"><a href="{{ route('fin-banks-accounts.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['fin-banks-accounts.index']) ? 'active' : '' }}">Bank Accounts</a></li>
                            <li class="nav-item"><a href="{{ route('fin-checkbooks.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['fin-checkbooks.index']) ? 'active' : '' }}">Checkbooks</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['hr-employees.index', 'hr-jobs.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-users"></i> <span> Human Resources</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Human Resources">

                            <li class="nav-item"><a href="{{ route('hr-employees.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['hr-employees.index']) ? 'active' : '' }}">Employees Management</a></li>
                            <li class="nav-item"><a href="{{ route('hr-jobs.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['hr-jobs.index']) ? 'active' : '' }}">Employees Designations</a></li>
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['scan_aml','upload_aml']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-collaboration"></i> <span> AML Management</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="AML Management">
                            <li class="nav-item"><a href="{{ route('scan_aml') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['scan_aml']) ? 'active' : '' }}">Scan CNIC</a></li>
                            <li class="nav-item"><a href="{{ route('upload_aml') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['upload_aml']) ? 'active' : '' }}">Upload Sheet</a></li>                    
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['kibor.all','tt.borrowers','tt.loandetails', 'ttr.edit', 'ttr.show', 'ttr.manage']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-collaboration"></i> <span> Financing Management</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Financing Management">
                        <li class="nav-item"><a href="{{ route('tt.borrowers') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['tt.borrowers']) ? 'active' : '' }}">Borrowers</a></li>
                        <li class="nav-item"><a href="{{ route('kibor.all') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['kibor.all']) ? 'active' : '' }}">Kibor</a></li>
                        <li class="nav-item"><a href="{{ route('kibor.history') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['kibor.history']) ? 'active' : '' }}">Kibor History</a></li>
                        <li class="nav-item"><a href="{{ route('tt.loandetails') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['tt.loandetails']) ? 'active' : '' }}">Financing Details</a></li>
                        
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['loan-payment-dues.index', 'loan-payment-recovereds.index','loan-bankslips.index']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-cash4"></i> <span> Repayments Management</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Repayments">

                        <li class="nav-item"><a href="{{ route('loan-bankslips.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['loan-bankslips.index']) ? 'active' : '' }}">Payment Slips</a></li>
                        <li class="nav-item"><a href="{{ route('loan-payment-dues.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['loan-payment-dues.index']) ? 'active' : '' }}">Payment Schedules</a></li>
                        <li class="nav-item"><a href="{{ route('loan-payment-recovereds.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['loan-payment-recovereds.index']) ? 'active' : '' }}">Payment Received</a></li>
                            
                        </ul>
                    </li>
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['reports.accrued', 'reports.dues','reports.duesreport', 'reports.odues', 'reports.par','reports.payments','reports.paymentsreport']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-clapboard"></i> <span> Reports</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Reports">

                            <li class="nav-item"><a href="{{ route('reports.financial') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.financial','reports.financialreport']) ? 'active' : '' }}">Financials</a></li>
                            <li class="nav-item"><a href="{{ route('reports.trial') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.trial','reports.trialreport']) ? 'active' : '' }}">Trial</a></li>
                            <li class="nav-item"><a href="{{ route('reports.dues') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.dues', 'reports.duesreport']) ? 'active' : '' }}">Due Reports</a></li>
                            <li class="nav-item"><a href="{{ route('reports.payments') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.payments', 'reports.paymentsreport']) ? 'active' : '' }}">Repayments Reports</a></li>
                            <li class="nav-item"><a href="{{ route('reports.odues') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.odues']) ? 'active' : '' }}">Over Due Reports</a></li>
                            <li class="nav-item"><a href="{{ route('reports.par') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.par']) ? 'active' : '' }}">Portfolio at Risk</a></li>
                            <li class="nav-item"><a href="{{ route('reports.accrued') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['reports.accrued']) ? 'active' : '' }}">Accrued</a></li>
                        </ul>
                    </li>
                
                
                @include('pages.'.Qs::getUserType().'.menu')

                {{--Manage Account--}}
                <li class="nav-item">
                    <a href="{{ route('my_account') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['my_account']) ? 'active' : '' }}"><i class="icon-user"></i> <span>My Account</span></a>
                </li>

            </ul>
        </div>
    </div>
</div>
