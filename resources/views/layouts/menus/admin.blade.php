@php
$payoutRequest = request_count('payout_request', true);
@endphp
<li>
	<a href="{{ route('dashboard.index') }}"><i class="fas fa-th-large"></i><span>{{ _lang('Dashboard') }}</span></a>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-gift"></i><span>{{ _lang('Packages') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('packages.index') }}">{{ _lang('All Packages') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('packages.create') }}">{{ _lang('Add New') }}</a></li>
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-user-friends"></i><span>{{ _lang('Users') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">{{ _lang('All Users') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('users.create') }}">{{ _lang('Add User') }}</a></li>
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-credit-card"></i><span>{{ _lang('Payments') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('subscription_payments.index') }}">{{ _lang('Payment History') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('subscription_payments.create') }}">{{ _lang('Add Offline Payment') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('payment_gateways.index') }}">{{ _lang('Payment Gateways') }}</a></li>		
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-network-wired"></i><span>{{ _lang('Affiliate Management') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i>{!! xss_clean($payoutRequest) !!}</span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('affiliate.settings') }}">{{ _lang('Affiliate Settings') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('affiliate.referrals') }}">{{ _lang('Referral History') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('affiliate.payout_requests') }}">{{ _lang('Payout Requests') }}{!! xss_clean($payoutRequest) !!}</a></li>		
		<li class="nav-item"><a class="nav-link" href="{{ route('affiliate_payout_methods.index') }}">{{ _lang('Payout Methods') }}</a></li>		
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="fab fa-firefox-browser"></i><span>{{ _lang('Website Management') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('pages.default_pages') }}">{{ _lang('Default Pages') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('pages.index') }}">{{ _lang('Custom Pages') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('faqs.index') }}">{{ _lang('Manage Faq') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('features.index') }}">{{ _lang('Manage Features') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('testimonials.index') }}">{{ _lang('Manage Testimonials') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}">{{ _lang('Blog Posts') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('teams.index') }}">{{ _lang('Manage Teams') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('pages.default_pages', 'header_footer') }}">{{ _lang('Header & Footer Settings') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('pages.default_pages', 'gdpr_cookie_consent') }}">{{ _lang('GDPR Cookie Consent') }}</a></li>
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="fas fa-globe"></i><span>{{ _lang('Languages') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('languages.index') }}">{{ _lang('All Language') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('languages.create') }}">{{ _lang('Add New') }}</a></li>
	</ul>
</li>

<li><a href="{{ route('business_types.index') }}"><i class="fas fa-briefcase"></i><span>{{ _lang('Business Types') }}</span></a></li>

<li><a href="{{ route('email_subscribers.index') }}"><i class="far fa-envelope"></i><span>{{ _lang('Email Subscribers') }}</span></a></li>
<li><a href="{{ route('contact_messages.index') }}"><i class="fas fa-envelope-open-text"></i><span>{{ _lang('Contact Messages') }}</span>{!! xss_clean(request_count('unread_contact_message', true, 'sidebar-notification-count contact-notification-count')) !!}</a></li>

<li><a href="{{ route('settings.update_settings') }}"><i class="fas fa-cog"></i><span>{{ _lang('System Settings') }}</span></a></li>
<li><a href="{{ route('currency.index') }}"><i class="fas fa-pound-sign"></i><span>{{ _lang('Currency Management') }}</span></a></li>
<li><a href="{{ route('notification_templates.index') }}"><i class="fas fa-envelope-open-text"></i><span>{{ _lang('Notification Templates') }}</span></a></li>
<li><a href="{{ route('database_backups.list') }}"><i class="fas fa-server"></i><span>{{ _lang('Database Backup') }}</span></a></li>