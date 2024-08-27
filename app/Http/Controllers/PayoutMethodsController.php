<?php

namespace App\Http\Controllers;

use App\Models\PayoutMethod;
use Illuminate\Http\Request;
use Validator;

class PayoutMethodsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        date_default_timezone_set(get_option('timezone', 'Asia/Dhaka'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $assets        = ['datatable'];
        $payoutmethods = PayoutMethod::all()->sortByDesc("id");
        return view('backend.admin.affiliate.payout_methods.list', compact('payoutmethods', 'assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $alert_col = "col-lg-10 offset-lg-1";
        $assets    = ['summernote'];
        return view('backend.admin.affiliate.payout_methods.create', compact('alert_col', 'assets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'                 => 'required',
            'image'                => 'nullable|image|max:2048',
            'status'               => 'required',
            'instructions'         => '',
            'fixed_charge'         => 'nullable|numeric',
            'charge_in_percentage' => 'nullable|numeric',
            'field_name.*'         => 'required',
            'field_type.*'         => 'required',
            'max_size.*'           => 'required|numeric',
        ], [
            'field_name.*.required' => _lang('Field name is required'),
            'field_type.*.required' => _lang('File type is required'),
            'max_size.*.required'   => _lang('Max size is required'),
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('affiliate_payout_methods.create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $form_fields = [];
        if ($request->has('field_name')) {
            for ($i = 0; $i < count($request->field_name); $i++) {
                $form_field                             = [];
                $form_field['field_label']              = $request->field_name[$i];
                $form_field['field_name']               = strtolower(str_replace(' ', '_', xss_clean($request->field_name[$i])));
                $form_field['field_type']               = $request->field_type[$i];
                $form_field['validation']               = $request->validation[$i];
                $form_field['max_size']                 = $request->max_size[$i];
                $form_fields[$form_field['field_name']] = $form_field;
            }
        }

        $image = 'default.png';
        if ($request->hasfile('image')) {
            $file  = $request->file('image');
            $image = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/media/", $image);
        }

        $payoutmethod                       = new PayoutMethod();
        $payoutmethod->name                 = $request->input('name');
        $payoutmethod->image                = $image;
        $payoutmethod->status               = $request->input('status');
        $payoutmethod->status               = $request->input('status');
        $payoutmethod->fixed_charge         = $request->input('fixed_charge');
        $payoutmethod->charge_in_percentage = $request->input('charge_in_percentage');
        $payoutmethod->parameters           = json_encode($form_fields);
        $payoutmethod->instructions         = $request->input('instructions');

        $payoutmethod->save();

        if (!$request->ajax()) {
            return redirect()->route('affiliate_payout_methods.index')->with('success', _lang('Saved Successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Saved Successfully'), 'data' => $payoutmethod, 'table' => '#affiliate_payout_methods_table']);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        $payoutmethod = PayoutMethod::find($id);
        $alert_col    = "col-lg-10 offset-lg-1";
        $assets       = ['summernote'];
        return view('backend.admin.affiliate.payout_methods.edit', compact('payoutmethod', 'id', 'alert_col', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name'                 => 'required',
            'image'                => 'nullable|image|max:2048',
            'status'               => 'required',
            'instructions'         => '',
            'fixed_charge'         => 'nullable|numeric',
            'charge_in_percentage' => 'nullable|numeric',
            'field_name.*'         => 'required',
            'field_type.*'         => 'required',
            'max_size.*'           => 'required|numeric',
        ], [
            'field_name.*.required' => _lang('Field name is required'),
            'field_type.*.required' => _lang('File type is required'),
            'max_size.*.required'   => _lang('Max size is required'),
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('affiliate_payout_methods.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $form_fields = [];
        if ($request->has('field_name')) {
            for ($i = 0; $i < count($request->field_name); $i++) {
                $form_field                             = [];
                $form_field['field_label']              = $request->field_name[$i];
                $form_field['field_name']               = strtolower(str_replace(' ', '_', xss_clean($request->field_name[$i])));
                $form_field['field_type']               = $request->field_type[$i];
                $form_field['validation']               = $request->validation[$i];
                $form_field['max_size']                 = $request->max_size[$i];
                $form_fields[$form_field['field_name']] = $form_field;
            }
        }

        if ($request->hasfile('image')) {
            $file  = $request->file('image');
            $image = time() . $file->getClientOriginalName();
            $file->move(public_path() . "/uploads/media/", $image);
        }

        $payoutmethod       = PayoutMethod::find($id);
        $payoutmethod->name = $request->input('name');
        if ($request->hasfile('image')) {
            $payoutmethod->image = $image;
        }
        $payoutmethod->status               = $request->input('status');
        $payoutmethod->fixed_charge         = $request->input('fixed_charge');
        $payoutmethod->charge_in_percentage = $request->input('charge_in_percentage');
        $payoutmethod->parameters           = json_encode($form_fields);
        $payoutmethod->instructions         = $request->input('instructions');
        $payoutmethod->save();

        if (!$request->ajax()) {
            return redirect()->route('affiliate_payout_methods.index')->with('success', _lang('Updated Successfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Updated Successfully'), 'data' => $payoutmethod, 'table' => '#affiliate_payout_methods_table']);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $payoutmethod = PayoutMethod::find($id);
        $payoutmethod->delete();
        return redirect()->route('affiliate_payout_methods.index')->with('success', _lang('Deleted Successfully'));
    }
}