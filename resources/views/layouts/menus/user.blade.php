<li>
	<a href="{{ route('dashboard.index') }}"><i class="fas fa-th-large"></i><span>{{ _lang('Dashboard') }}</span></a>
</li>

<li>
	<a href="{{ route('customers.index')  }}"><i class="fas fa-user-friends"></i><span>{{ _lang('Customers') }}</span></a>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-box"></i><span>{{ _lang('Product & Services') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
        <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">{{ _lang('Product & Services') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('product_units.index') }}">{{ _lang('Product Units') }}</a></li>
	</ul>
</li>

<li>
	<a href="{{ route('vendors.index') }}"><i class="fas fa-user-friends"></i><span>{{ _lang('Vendors') }}</span></a>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-shopping-basket"></i><span>{{ _lang('Sales') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
        <li class="nav-item"><a class="nav-link" href="{{ route('invoices.index') }}">{{ _lang('Invoices') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('quotations.index') }}">{{ _lang('Quotations') }}</a></li>
		@if(package()->recurring_invoice == 1)
        <li class="nav-item"><a class="nav-link" href="{{ route('recurring_invoices.index') }}">{{ _lang('Recurring Invoices') }}</a></li>
		@endif
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-shopping-bag"></i><span>{{ _lang('Purchases') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
        <li class="nav-item"><a class="nav-link" href="{{ route('purchases.create') }}">{{ _lang('New Purchase') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('purchases.index') }}">{{ _lang('Purchase History') }}</a></li>
	</ul>
</li>

@if(package()->invoice_builder == 1)
<li>
	<a href="{{ route('invoice_templates.index') }}"><i class="fas fa-palette"></i><span>{{ _lang('Invoice Templates') }}</span></a>
</li>
@endif

<li>
	<a href="javascript: void(0);"><i class="fas fa-university"></i><span>{{ _lang('Accounting') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
        <li class="nav-item"><a class="nav-link" href="{{ route('accounts.index') }}">{{ _lang('Bank & Cash Accounts') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('transactions.index') }}">{{ _lang('Transactions') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('transaction_categories.index') }}">{{ _lang('Transaction Categories') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('transaction_methods.index') }}">{{ _lang('Transaction Methods') }}</a></li>
	</ul>
</li>

@if(package()->payroll_module == 1)
<li>
	<a href="javascript: void(0);"><i class="fas fa-money-check-alt"></i><span>{{ _lang('HR & Payroll') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('staffs.index') }}">{{ _lang('Staff Management') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('departments.index') }}">{{ _lang('Departments') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('attendance.index') }}">{{ _lang('Staff Attendance') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('salary_scales.index') }}">{{ _lang('Salary Pay Scale') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('payslips.index') }}">{{ _lang('Manage Payslip') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('payslips.make_payment') }}">{{ _lang('Make Payment') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('employee_expenses.index') }}">{{ _lang('Employee Expenses') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('holidays.index') }}">{{ _lang('Holidays') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('leaves.index') }}">{{ _lang('Leaves') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('awards.index') }}">{{ _lang('Awards') }}</a></li>
    </ul>
</li>
@endif

<li>
	<a href="javascript: void(0);"><i class="far fa-chart-bar"></i><span>{{ _lang('Reports') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.account_balances') }}">{{ _lang('Account Balances') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.account_statement') }}">{{ _lang('Account Statement') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.profit_and_loss') }}">{{ _lang('Profit & Loss Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.transactions_report') }}">{{ _lang('Transaction Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.income_by_customer') }}">{{ _lang('Income by Customer') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.purchase_by_vendor') }}">{{ _lang('Purchases by Vendor') }}</a></li>
		@if(package()->payroll_module == 1)
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.attendance_report') }}">{{ _lang('Attendance Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.payroll_report') }}">{{ _lang('Payroll Report') }}</a></li>
        @endif
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.tax_report') }}">{{ _lang('Tax Report') }}</a></li>
    </ul>
</li>

@if(request()->isOwner)
@if(get_option('affiliate_status', 0) == 1)
<li>
	<a href="javascript: void(0);"><i class="fas fa-network-wired"></i><span>{{ _lang('Affiliate') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('user_affiliate.index') }}">{{ _lang('Overview') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('user_affiliate.referrals') }}">{{ _lang('Paid Referrals') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('user_affiliate.unpaid_referrals') }}">{{ _lang('Unpaid Referrals') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('referral_payouts.index') }}">{{ _lang('Payouts') }}</a></li>	
    </ul>
</li>
@endif
<li>
	<a href="{{ route('taxes.index') }}"><i class="fas fa-percentage"></i><span>{{ _lang('Tax Settings') }}</span></a>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-building"></i><span>{{ _lang('Business Management') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('business.index') }}">{{ _lang('Manage Business') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">{{ _lang('Roles & Permission') }}</a></li>
    </ul>
</li>

<li>
	<a href="{{ route('business.settings', request()->activeBusiness->id) }}"><i class="fas fa-tools"></i><span>{{ _lang('Business Settings') }}</span></a>
</li>
@endif