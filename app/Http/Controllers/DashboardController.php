<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\SubscriptionPayment;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index() {
		$user = auth()->user();
		$user_type = $user->user_type;
		$data = array();
		$data['assets'] = ['datatable'];

		if ($user_type == 'admin') {
			$data['total_user'] = User::where('user_type', 'user')->count();
			$data['total_owner'] = User::where('user_type', 'user')
				->where('package_id', '!=', null)
				->where('membership_type', '!=', null)
				->count();

			$data['trial_users'] = User::where('user_type', 'user')
				->where('package_id', '!=', null)
				->where('membership_type', 'trial')
				->count();

			$data['expired_users'] = User::where('user_type', 'user')
				->where('package_id', '!=', null)
				->where('membership_type', '!=', null)
				->whereDate('valid_to', '<', now())
				->count();

			$data['recentPayments'] = SubscriptionPayment::select('subscription_payments.*')
				->with('user', 'package', 'created_by')
				->orderBy("subscription_payments.id", "desc")
				->limit(10)
				->get();

			$data['newUsers'] = User::where('user_type', 'user')
				->with('package')
				->where('package_id', '!=', null)
				->where('membership_type', '!=', null)
				->orderBy("users.id", "desc")
				->limit(10)
				->get();

			return view("backend.admin.dashboard-admin", $data);
		} else if ($user_type == 'user') {
			$month = date('m');
			$year = date('Y');

			$data['current_month_income'] = Transaction::selectRaw("IFNULL(SUM((transactions.amount/currency_rate) * 1),0) as total")
				->where('dr_cr', 'cr')
				->whereMonth("trans_date", $month)
				->whereYear("trans_date", $year)
				->first();

			$data['current_month_expense'] = Transaction::selectRaw("IFNULL(SUM((transactions.amount/currency_rate) * 1),0) as total")
				->where('dr_cr', 'dr')
				->whereMonth("trans_date", $month)
				->whereYear("trans_date", $year)
				->first();

			$data['invoice'] = Invoice::selectRaw('COUNT(id) as total_invoice, SUM(grand_total) as total_amount, sum(paid) as total_paid')
				->where('is_recurring', 0)
				->where('status', '!=', 0)
				->where('status', '!=', 99)
				->first();

			$data['purchase'] = Purchase::selectRaw('COUNT(id) as total_invoice, SUM(grand_total) as total_amount, sum(paid) as total_paid')
				->where('status', '!=', 0)
				->first();

			$data['accounts'] = get_account_details();

			$data['transactions'] = Transaction::limit(10)->orderBy('id', 'desc')->get();

			if (request('isOwner') == true) {
				return view("backend.user.dashboard-user", $data);
			}
			return view("backend.user.dashboard-staff", $data);
		}

	}

	public function current_month_income_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function current_month_expense_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function due_invoice_amount_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function due_purchase_amount_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function cashflow_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function account_balance_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function income_by_category_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function expense_by_category_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function recent_transaction_widget() {
		// Use for Permission Only
		return redirect()->route('dashboard.index');
	}

	public function json_income_by_category() {
		$transactions = Transaction::selectRaw('transaction_category_id, ref_id, ref_type, ROUND(IFNULL(SUM((transactions.amount/currency_rate) * 1),0),2) as amount')
			->with('category')
			->where('dr_cr', 'cr')
			->whereRaw('YEAR(trans_date) = ?', date('Y'))
			->groupBy('transaction_category_id', 'ref_type')
			->get();
		$category = array();
		$colors = array();
		$amounts = array();

		foreach ($transactions as $transaction) {
			array_push($category, $transaction->category->name);
			array_push($colors, $transaction->category->color);
			array_push($amounts, (double) $transaction->amount);
		}

		echo json_encode(array('amounts' => $amounts, 'category' => $category, 'colors' => $colors));
	}

	public function json_expense_by_category() {
		$transactions = Transaction::selectRaw('transaction_category_id, ref_id, ref_type, ROUND(IFNULL(SUM((transactions.amount/currency_rate) * 1),0),2) as amount')
			->with('category')
			->where('dr_cr', 'dr')
			->whereRaw('YEAR(trans_date) = ?', date('Y'))
			->groupBy('transaction_category_id', 'ref_type')
			->get();

		$category = array();
		$colors = array();
		$amounts = array();

		foreach ($transactions as $transaction) {
			array_push($category, $transaction->category->name);
			array_push($colors, $transaction->category->color);
			array_push($amounts, (double) $transaction->amount);
		}

		echo json_encode(array('amounts' => $amounts, 'category' => $category, 'colors' => $colors));
	}

	public function json_cashflow() {
		$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		$transactions = Transaction::selectRaw('MONTH(trans_date) as td, dr_cr, type, ROUND(IFNULL(SUM((transactions.amount/currency_rate) * 1),0),2) as amount')
			->whereRaw('YEAR(trans_date) = ?', date('Y'))
			->groupBy('td', 'type')
			->get();

		$deposit = array();
		$withdraw = array();

		foreach ($transactions as $transaction) {
			if ($transaction->type == 'income') {
				$deposit[$transaction->td] = $transaction->amount;
			} else if ($transaction->type == 'expense') {
				$withdraw[$transaction->td] = $transaction->amount;
			}
		}

		echo json_encode(array('month' => $months, 'deposit' => $deposit, 'withdraw' => $withdraw));
	}

	public function json_package_wise_subscription() {
		if (auth()->user()->user_type != 'admin') {
			return null;
		}
		$users = User::selectRaw('package_id, COUNT(id) as subscribed')
			->with('package')
			->where('user_type', 'user')
			->where('package_id', '!=', null)
			->groupBy('package_id')
			->get();

		$package = array();
		$colors = array();
		$subscribed = array();

		$flatColors = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e",
			"#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
			"#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6",
			"#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];

		foreach ($users as $user) {
			array_push($package, $user->package->name . ' (' . ucwords($user->package->package_type) . ')');
			//array_push($colors, sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
			$index = array_rand($flatColors, 1);
			array_push($colors, $flatColors[$index]);
			unset($flatColors[$index]);
			array_push($subscribed, (double) $user->subscribed);
		}

		echo json_encode(array('package' => $package, 'subscribed' => $subscribed, 'colors' => $colors));
	}

	public function json_yearly_reveneu() {
		$months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		$subscriptionPayments = SubscriptionPayment::selectRaw('MONTH(created_at) as td, SUM(subscription_payments.amount) as amount')
			->whereRaw('YEAR(created_at) = ?', date('Y'))
			->groupBy('td')
			->get();

		$transactions = array();

		foreach ($subscriptionPayments as $subscriptionPayment) {
			$transactions[$subscriptionPayment->td] = $subscriptionPayment->amount;
		}

		echo json_encode(array('month' => $months, 'transactions' => $transactions));
	}
}
