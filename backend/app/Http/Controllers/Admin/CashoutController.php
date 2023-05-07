<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affliate;
use App\Models\Affliate_transaction;
use App\Models\Affliate_withdraw;
use App\Models\Cashout_request;
use App\Models\Publisher;
use App\Models\Publisher_payment_method;
use App\Models\Publisher_transaction;
use App\Models\Site_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CashoutController extends Controller
{
    public function ManageCashout()
    {
        $publishers = Publisher::get();
        return view('admin.cashout.Manage_Cashout', compact('publishers'));
    }

    public function ShowCashout(Request $request)
    {
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Cashout_request::select('*')->with('publisher');
        //search
        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
        $category->each->append('date');
        $category->each->append('statustext');
        $category->each->append('payperiod');
        // $category->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_site_category,
            'recordsFiltered' => $total_site_category,
            'data' => $category,
        );
        return response()->json($data);
    }

    public function ShowCashoutAffliate(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search = $request->search['value'];
        $sort_by = $request->order[0]['column'];
        $sort_direction = $request->order[0]['dir'];
        $category_query = Affliate_withdraw::select('*')->with('affliate');
        //search
        $total_site_category = $category_query->count();
        $category = $category_query->limit($length)->offset($start)->orderby('id', 'desc')->get();
        $category->each->append('action');
        $category->each->append('date');
        $category->each->append('payperiod');
        // $category->each->append('sponsor');

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_site_category,
            'recordsFiltered' => $total_site_category,
            'data' => $category,
        );
        return response()->json($data);
    }

    public function InsertCashout(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $this->validate($request, [
            'balance' => 'required',
            'affliate_id' => 'required',
            'payment_terms' => 'required',
            'to_date' => 'required',
            'amount' => 'required',
            'from_date' => 'required',
            'note' => 'required'
        ]);
        $publisher = Publisher_payment_method::where('publisher_id', $request->affliate_id)
            ->where('is_primary', '1')
            ->first();
        if (!isset($publisher)) {
            $response = [
                'status' => false,
                'message' => 'Please add a payment method',
                'data' => []
            ];
            return response()->json($response);
        }
        if ($request->amount > $request->balance) {
            $response = [
                'status' => false,
                'message' => 'Exceeding Balance Amount',
                'data' => []
            ];
            return response()->json($response);
        }

        $qry = Cashout_request::where('status', '!=', "Completed")->where('status', '!=', 'Rejected')->sum('amount');
        Publisher::where('id', $request->affliate_id)->decrement('balance', $request->amount);

        $data = array(
            'affliate_id' => $request->affliate_id,
            'from_date' => $request->from_date,
            'payterm' => $request->payment_terms,
            'to_date' => $request->to_date,
            'amount' => $request->amount,
            'note' => $request->note,
            'status' => 'Pending',
            'payment_details' => $publisher->payment_details,
            'method' => $publisher->payment_type,
        );
        if (Cashout_request::create($data)) {
            $data = array(
                'amount' => -1 * $request->amount,
                'offer_process_id' => '0',
                'publisher_id' => $request->affliate_id
            );
            Publisher_transaction::create($data);
            $response = [
                'status' => true,
                'message' => 'Cashout Created Successfully',
                'data' => []
            ];
        }
        return response()->json($response);
        // return redirect()->back()->with('success', 'Cashout is Successful!');
    }

    public function EditCashout(Request $request)
    {
        $data = Cashout_request::where('id', $request->id)->with('publisher')->first();
        return response()->json($data);
    }

    public function EditCashoutAffliate(Request $request)
    {
        // return $request;
        $data = Affliate_withdraw::where('id', $request->id)->with('affliate')->first();
        return response()->json($data);
    }

    public function ManageCashoutAffliate()
    {
        $Affliate = Affliate::get();
        return view('admin.cashout.Manage_Cashout_Affliate', compact('Affliate'));
    }

    public function UpdateCashout(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        $this->validate($request, [
            'id' => 'required',
            'old_amount' => 'required',
            'publisher_id' => 'required',
            'amount1' => 'required',
            'status' => 'required',
            //'upload_pdf' => 'required|mimes:pdf'
        ]);
        if ($request->file('upload_pdf')) {
            $this->validate($request, [
                'id' => 'required',
                'old_amount' => 'required',
                'publisher_id' => 'required',
                'amount1' => 'required',
                'status' => 'required',
                'upload_pdf' => 'required|mimes:pdf'
            ]);
        }
        $pub = Publisher::where('id', $request->publisher_id)->first();
        $old_amount = $request->old_amount;
        $net_amount = $request->amount1 - $request->old_amount;
        $qry = Cashout_request::where('id', $request->id)->first();
        if ($qry->status == 'Cancelled') {
            if ($request->status != 'Cancelled') {
                if ($request->amount1 <= $pub->balance) {

                    $qry->status = $request->status;
                    $qry->save();

                    // $data = array(
                    //     'amount' => -1 * $request->amount1,
                    //     'offer_process_id' => '0',
                    //     'publisher_id' => $request->publisher_id
                    // );
                    // if (Publisher_transaction::create($data)) {
                    //     Publisher::where('id', $request->publisher_id)->decrement('balance', $request->amount1);

                    // }

                    $response = [
                        'status' => true,
                        'message' => 'Cashout is Successful!',
                        'data' => []
                    ];
                    return response()->json($response);

                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Exceeding Balance Amount',
                        'data' => []
                    ];
                    return response()->json($response);
                }
            }
        } else {
            if ($request->status == 'Cancelled') {

                $qry->status = 'Cancelled';
                $qry->save();
                $response = [
                    'status' => true,
                    'message' => 'Cashout is Successful!',
                    'data' => []
                ];
                return response()->json($response);


                // $data = array(
                //     'amount' => -1 * $request->amount1,
                //     'offer_process_id' => '0',
                //     'publisher_id' => $request->publisher_id
                // );
                // if (Publisher_transaction::create($data)) {
                //     Publisher::where('id', $request->publisher_id)->increment('balance', $request->amount1);


                // }
            } else {
                if ($request->amount1 != $request->old_amount) {

                    if ($net_amount > 0) {

                        if ($pub->balance >= $net_amount) {

                            $qry->status = $request->status;
                            $qry->save();
                            $response = [
                                'status' => true,
                                'message' => 'Cashout is Successful!',
                                'data' => []
                            ];
                            return response()->json($response);


                            // $data = array(
                            //     'amount' => -1 * $net_amount,
                            //     'offer_process_id' => '0',
                            //     'publisher_id' => $request->publisher_id
                            // );
                            // if (Publisher_transaction::create($data)) {
                            //     Publisher::where('id', $request->publisher_id)->decrement('balance', $net_amount);


                            // }
                        } else {
                            $response = [
                                'status' => false,
                                'message' => 'Exceeding Balance Amount',
                                'data' => []
                            ];
                            return response()->json($response);
                        }
                    } else {
                        $qry->status = $request->status;
                        $qry->save();
                        $response = [
                            'status' => true,
                            'message' => 'Cashout is Successful!',
                            'data' => []
                        ];
                        return response()->json($response);

                        // $data = array(
                        //     'amount' => -1 * $net_amount,
                        //     'offer_process_id' => '0',
                        //     'publisher_id' => $request->publisher_id
                        // );
                        // if (Publisher_transaction::create($data)) {
                        //     Publisher::where('id', $request->publisher_id)->decrement('balance', $net_amount);

                        // }
                    }
                } else {
                }
            }
        }


        if ($request->file('upload_pdf')) {

            $file = $request->file('upload_pdf');

            $originalfilename = Str::slug($file->getClientOriginalName());

            $filename = time() . '_' . $originalfilename;
            $extension = $file->getClientOriginalExtension();
            $location = 'uploads';
            $file->move(public_path($location), $filename.'.'.$extension);

            $data = array(
                'status' => $request->status,
                'amount' => $request->amount1,
                'doc' =>$filename.'.'.$extension,
            );
        } else {
            $data = array(
                'status' => $request->status,
                'amount' => $request->amount1,
            );
        }


        if (Cashout_request::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Cashout is Successful!',
                'data' => []
            ];
            return response()->json($response);
            //  return redirect()->back()->with('success', 'Cashout is Successful!');
        }

        return response()->json($response);
    }

    public function DeleteCashout(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Cashout_request::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Cashout Deleted Successful!',
                'data' => []
            ];
            return response()->json($response);
            // return redirect()->back()->with('success', 'Cashout Deleted Successful!');
        }
        return response()->json($response);
    }

    public function InstantWithdraw(Request $request)
    {
        $publisher = Affliate::where('balance', '>', 0)->get();

        foreach ($publisher as $pub) {

            $data = array(
                'affliate_id' => $pub->id,
                'from_date' => date('Y-m-d'),
                'amount' => $pub->balance,
                'note' => '...',
                'method' => $pub->payment_method,
                'status' => 'Pending',
                'payment_details' => $pub->payment_description,
                'payterm' => 'Instant Withdraw'
            );

            Affliate_withdraw::create($data);

            Affliate::where('id', $pub->id)->decrement('balance', $pub->balance);

            $data = array(
                'amount' =>
                    -1 * $pub->balance,
                'offer_process_id' => '0',
                'affliate_id' => $pub->id
            );
            Affliate_transaction::create($data);
        }

        $response = [
            'status' => true,
            'message' => 'Cashout Updated Successfully',
            'data' => []
        ];
        return response()->json($response);
        // return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }

    public function DeleteCashoutAffliate(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if (Affliate_withdraw::where('id', $request->id)->delete()) {
            $response = [
                'status' => true,
                'message' => 'Cashout Deleted Successful!',
                'data' => []
            ];
            return response()->json($response);
            //  return redirect()->back()->with('success', 'Cashout Deleted Successful!');
        }
        return response()->json($response);
    }


    public function InsertCashoutAffliate(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];
        if ($request->amount > $request->balance) {
            $response = [
                'status' => false,
                'message' => 'Exceeding Balance Amount',
                'data' => []
            ];

            return response()->json($response);
        }

        $qry = Affliate_withdraw::where('status', '!=', "Completed")->where('status', '!=', 'Rejected')->sum('amount');
        Affliate::where('id', $request->affliate_id)->decrement('balance', $request->amount);
        $affliate = Affliate::where('id', $request->affliate_id)->first();
        $data = array(
            'affliate_id' => $request->affliate_id,
            'from_date' => $request->from_date,
            'payterm' => $request->payment_terms,
            'to_date' => $request->to_date,
            'amount' => $request->amount,
            'method' => $affliate->payment_method,
            'note' => $request->note,
            'status' => 'Pending',
        );

        if (Affliate_withdraw::create($data)) {
            $data = array(
                'amount' => -1 * $request->amount,
                'affliate_id' => $request->affliate_id,
                'offer_process_id' => '0'
            );
            Affliate_transaction::create($data);

            $response = [
                'status' => true,
                'message' => 'Cashout is Successful!',
                'data' => []
            ];
            return response()->json($response);


            // return redirect()->back()->with('success', 'Cashout is Successful!');
        }

        return response()->json($response);
    }

    public function UpdateCashoutAffliate(Request $request)
    {
        if (!$request->ajax()) {
            return abort(404);
        }

        $response = [
            'status' => false,
            'message' => 'Somthing went wrong, please try again',
            'data' => []
        ];

        $pub = Affliate::where('id', $request->affliate_id)->first();

        $old_amount = $request->old_amount;
        $net_amount = $request->amount1 - $request->old_amount;


        $qry = Affliate_withdraw::where('id', $request->id)->first();


        if ($qry->status == 'Cancelled') {
            if ($request->status != 'Cancelled') {
                if ($request->amount1 <= $pub->balance) {
                    $data = array(
                        'amount' => -1 * $request->amount1,
                        'offer_process_id' => '0',
                        'affliate_id' => $request->affliate_id
                    );
                    if (Affliate_transaction::create($data)) {
                        Affliate::where('id', $request->affliate_id)->decrement('balance', $request->amount1);

                        $response = [
                            'status' => true,
                            'message' => 'Cashout is Successful!',
                            'data' => []
                        ];
                        return response()->json($response);


                        // return redirect()->back()->with('success', 'Cashout is Successful!');
                    }
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Exceeding Balance Amount',
                        'data' => []
                    ];
                    return response()->json($response);
                }
            }
        } else {
            if ($request->status == 'Cancelled') {
                $data = array(
                    'amount' => $request->amount1,
                    'offer_process_id' => '0',
                    'affliate_id' => $request->affliate_id
                );
                if (Affliate_transaction::create($data)) {
                    Affliate::where('id', $request->affliate_id)->increment('balance', $request->amount1);
                    $response = [
                        'status' => true,
                        'message' => 'Cashout is Successful!',
                        'data' => []
                    ];
                    return response()->json($response);

                    //  return redirect()->back()->with('success', 'Cashout is Successful!');
                }
            } else {
                if ($request->amount1 != $request->old_amount) {

                    if ($net_amount > 0) {

                        if ($pub->balance >= $net_amount) {
                            $data = array(
                                'amount' => -1 * $net_amount,
                                'offer_process_id' => '0',
                                'affliate_id' => $request->affliate_id
                            );
                            if (Affliate_transaction::create($data)) {
                                Affliate::where('id', $request->affliate_id)->decrement('balance', $net_amount);
                                $response = [
                                    'status' => true,
                                    'message' => 'Cashout is Successful!',
                                    'data' => []
                                ];
                                return response()->json($response);
                                // return redirect()->back()->with('success', 'Cashout is Successful!');
                            }
                        } else {
                            $response = [
                                'status' => false,
                                'message' => 'Exceeding Balance Amount',
                                'data' => []
                            ];
                            return response()->json($response);
                        }
                    } else {
                        $data = array(
                            'amount' => -1 * $net_amount,
                            'offer_process_id' => '0',
                            'affliate_id' => $request->affliate_id
                        );
                        if (Affliate_transaction::create($data)) {
                            Affliate::where('id', $request->affliate_id)->decrement('balance', $net_amount);
                            $response = [
                                'status' => true,
                                'message' => 'Cashout is Successful!',
                                'data' => []
                            ];
                            return response()->json($response);
                            //  return redirect()->back()->with('success', 'Cashout is Successful!');
                        }
                    }
                } else {
                }
            }
        }
        $data = array(
            'status' => $request->status,
            'amount' => $request->amount1,
        );
        if (Affliate_withdraw::where('id', $request->id)->update($data)) {
            $response = [
                'status' => true,
                'message' => 'Cashout is Successful!',
                'data' => []
            ];
            return response()->json($response);
            //  return redirect()->back()->with('success', 'Cashout is Successful!');
        }

        return response()->json($response);
    }


    public function CronPayoutNet45(Request $request)
    {

        $site = Site_setting::first();

        // $publisher = Publisher::where('publishers.role', 'publisher')->where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net45')->get();

        $publisher = Publisher::where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net45')->get();

        foreach ($publisher as $pub) {
            if ($pub->balance >= $site->minimum_withdraw_amount) {

                $data = array(
                    'affliate_id' => $pub->publisher_id,
                    'from_date' => date('Y-m-d'),
                    'amount' => $pub->balance,
                    'note' => '...',
                    'method' => $pub->payment_type,
                    'status' => 'Pending',
                    'payment_details' => $pub->payment_details,
                    'payterm' => 'net45'
                );

                Cashout_request::create($data);

                Publisher::where('id', $pub->publisher_id)->decrement('balance', $pub->balance);

                $data = array(
                    'amount' => -1 * $pub->balance,
                    'offer_process_id' => '0',
                    'publisher_id' => $pub->publisher_id
                );
                Publisher_transaction::create($data);
            }
        }
        return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }

    public function CronPayoutNetWeekly(Request $request)
    {

        $site = Site_setting::first();

        // $publisher = Publisher::where('publishers.role', 'publisher')->where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'netweekly')->get();
        $publisher = Publisher::where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'netweekly')->get();

        foreach ($publisher as $pub) {
            if ($pub->balance >= $site->minimum_withdraw_amount) {

                $data = array(
                    'affliate_id' => $pub->publisher_id,
                    'from_date' => date('Y-m-d'),
                    'to_date' => date('Y-m-d'),
                    'amount' => $pub->balance,
                    'note' => '...',
                    'method' => $pub->payment_type,
                    'status' => 'Pending',
                    'payment_details' => $pub->payment_details,
                    'payterm' => 'netweekly'
                );

                Cashout_request::create($data);

                Publisher::where('id', $pub->publisher_id)->decrement('balance', $pub->balance);
                $data = array(
                    'amount' => -1 * $pub->balance,
                    'offer_process_id' => '0',
                    'publisher_id' => $pub->publisher_id
                );
                Publisher_transaction::create($data);
            }
        }
        return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }

    public function CronPayoutNet30(Request $request)
    {

        $site = Site_setting::first();


        // $publisher = Publisher::where('publishers.role', 'publisher')->where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net30')->get();
        $publisher = Publisher::where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net30')->get();

        foreach ($publisher as $pub) {
            if ($pub->balance >= $site->minimum_withdraw_amount) {

                $data = array(
                    'affliate_id' => $pub->publisher_id,
                    'from_date' => date('Y-m-d'),
                    'to_date' => date('Y-m-d'),
                    'amount' => $pub->balance,
                    'note' => '...',
                    'method' => $pub->payment_type,
                    'status' => 'Pending',
                    'payment_details' => $pub->payment_details,
                    'payterm' => 'net30'
                );

                Cashout_request::create($data);

                Publisher::where('id', $pub->publisher_id)->decrement('balance', $pub->balance);
                $data = array(
                    'amount' => -1 * $pub->balance,
                    'offer_process_id' => '0',
                    'publisher_id' => $pub->publisher_id
                );
                Publisher_transaction::create($data);
            }
        }
        return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }


    public function CronPayoutNet15(Request $request)
    {

        $site = Site_setting::first();

        // $publisher = Publisher::where('publishers.role', 'publisher')->where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net15')->get();
        $publisher = Publisher::where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net15')->get();

        foreach ($publisher as $pub) {
            if ($pub->balance >= $site->minimum_withdraw_amount) {

                $data = array(
                    'affliate_id' => $pub->publisher_id,
                    'from_date' => date('Y-m-d'),
                    'to_date' => date('Y-m-d'),
                    'amount' => $pub->balance,
                    'note' => '...',
                    'method' => $pub->payment_type,
                    'status' => 'Pending',
                    'payment_details' => $pub->payment_details,
                    'payterm' => 'net15'
                );

                Cashout_request::create($data);
                Cashout_request::create($data);

                Publisher::where('id', $pub->publisher_id)->decrement('balance', $pub->balance);

                $data = array(
                    'amount' => -1 * $pub->balance,
                    'offer_process_id' => '0',
                    'publisher_id' => $pub->publisher_id
                );
                Publisher_transaction::create($data);
            }
        }
        return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }


    public function CronPayoutNet7(Request $request)
    {

        $site = Site_setting::first();

        //  $publisher = Publisher::where('publishers.role', 'publisher')->where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net7')->get();
        $publisher = Publisher::where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'net7')->get();

        foreach ($publisher as $pub) {
            if ($pub->balance >= $site->minimum_withdraw_amount) {

                $data = array(
                    'affliate_id' => $pub->publisher_id,
                    'from_date' => date('Y-m-d'),
                    'to_date' => date('Y-m-d'),
                    'amount' => $pub->balance,
                    'note' => '...',
                    'method' => $pub->payment_type,
                    'status' => 0,
                    'payment_details' => $pub->payment_details,
                    'payterm' => 'net7'
                );

                Cashout_request::create($data);
                // Cashout_request::create($data);

                Publisher::where('id', $pub->publisher_id)->decrement('balance', $pub->balance);
                $data = array(
                    'amount' => -1 * $pub->balance,
                    'offer_process_id' => '0',
                    'publisher_id' => $pub->publisher_id
                );
                Publisher_transaction::create($data);
            }
        }
        return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }

    public function CronPayoutOnRequested(Request $request)
    {

        $site = Site_setting::first();

        // $publisher = Publisher::where('publishers.role', 'publisher')->where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'On Requested')->get();
        $publisher = Publisher::where('balance', '>=', $site->minimum_withdraw_amount)->join('publisher_payment_method', 'publishers.id', '=', 'publisher_payment_method.publisher_id')->where('publisher_payment_method.is_primary', 1)->where('publishers.payment_terms', 'On Requested')->get();


        foreach ($publisher as $pub) {
            if ($pub->balance >= $site->minimum_withdraw_amount) {

                $data = array(
                    'affliate_id' => $pub->publisher_id,
                    'from_date' => date('Y-m-d'),
                    'amount' => $pub->balance,
                    'note' => '...',
                    'method' => $pub->payment_type,
                    'status' => 'Pending',
                    'payment_details' => $pub->payment_details,
                    'payterm' => 'On Requested'
                );

                Cashout_request::create($data);

                Cashout_request::create($data);

                Publisher::where('id', $pub->publisher_id)->decrement('balance', $pub->balance);
                $data = array(
                    'amount' => -1 * $pub->balance,
                    'offer_process_id' => '0',
                    'publisher_id' => $pub->publisher_id
                );
                Publisher_transaction::create($data);
            }
        }
        return redirect()->back()->with('success', 'Cashout Updated Successfully');
    }
}
