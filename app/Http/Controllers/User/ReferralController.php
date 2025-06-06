<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\PayoutRequested;
use App\Mail\ReferralEmail;
use App\Models\Setting;
use App\Models\Referral;
use App\Models\Payout;
use App\Models\User;
use DataTables;
use DB;
use Exception;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $total_commission = Referral::select(DB::raw("sum(commission) as data"))->where('referrer_id', auth()->user()->id)->get();

        $total_referred = User::select(DB::raw("count(referred_by) as data"))->where('referred_by', auth()->user()->id)->get();

        return view('user.referrals.user_referral_index', compact('total_commission', 'total_referred'));
    }


    /**
     * Send a inviation email
     */
    public function email(Request $request)
    {   
        try {

            Mail::to(request('email'))->send(new ReferralEmail());

        } catch(Exception $e) {
            toastr()->error(__('An error occurred while sending the email: ') . $e->getMessage());
            return redirect()->back();
        }    
        
        toastr()->success(__('Email was sent successfully'));
        return redirect()->back();
    }


    /**
     * List user payout requests.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payouts(Request $request)
    {
        if ($request->ajax()) {
            $data = Payout::where('user_id', auth()->user()->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div class="dropdown">
                                            <button class="btn table-actions" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>                       
                                            </button>
                                            <div class="dropdown-menu table-actions-dropdown" role="menu" aria-labelledby="actions">                                             
                                                <a class="dropdown-item" data-toggle="modal" id="deletePayoutButton" data-target="#deletePayoutModal" href="" data-attr="'. route("user.referral.payout.cancel", $row["id"] ). '"><i class="fa fa-close"></i>'. __('Cancel') .'</a>                                              
                                            </div>
                                        </div>';
                        return $actionBtn;
                    })
                    ->addColumn('custom-status', function($row){
                        $custom_status = '<span class="cell-box payout-'.$row["status"].'">'.__(ucfirst($row["status"])).'</span>';
                        return $custom_status;
                    })
                    ->addColumn('custom-total', function($row){
                        $custom_status = config('payment.default_system_currency_symbol') . $row["total"];
                        return $custom_status;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span>'.date_format($row["created_at"], 'Y-m-d H:i:s').'</span>';
                        return $created_on;
                    })
                    ->rawColumns(['created-on', 'actions', 'custom-status', 'custom-total'])
                    ->make(true);
                    
        }

    }


    /**
     * Create payout request.
     *
     * @return \Illuminate\Http\Response
     */
    public function payoutsStore(Request $request)
    {        
        $request->validate([
            'payout' => 'required|numeric',
        ]);

        if ($request->payout > auth()->user()->balance) {
            toastr()->warning(__('Requested amount is more than your current balance'));
            return redirect()->back();
        }

        if ($request->payout < config('payment.referral.payment.threshold')) {
            toastr()->warning(__('Requested payout amount is less than minimum payout threshold'));
            return redirect()->back();
        }        

        $user = User::where('id', auth()->user()->id)->firstOrFail();   
        $user->balance = ($user->balance - $request->payout);
        $user->save();

        Payout::create([
            'request_id' => strtoupper(Str::random(15)),
            'user_id' => auth()->user()->id,
            'total' => $request->payout,
            'gateway' => request('payment_method'),
            'status' => 'processing',
        ]);       

        event(new PayoutRequested($user));

        request()->validate([
            'payment_method' => 'required',
        ]);

        $user = User::where('id', auth()->user()->id)->first();   
        $user->referral_payment_method = request('payment_method');
        $user->referral_paypal = request('paypal');
        $user->referral_bank_requisites = request('bank_requisites');
        $user->save();
     
        toastr()->success(__('Your request for payout has been created successfully'));
        return redirect()->back();
    }


    /**
     * Cancel payout request.
     *
     * @return \Illuminate\Http\Response
     */
    public function payoutsCancel(Payout $id)
    {
        if ($id->user_id != auth()->user()->id) {
            return view('user.referrals.user_referral_index');
        }

        return view('user.referrals.payouts.user_referral_payout_delete', compact('id'));
    }


    /**
     * Decline payout request.
     *
     * @return \Illuminate\Http\Response
     */
    public function payoutsDecline(Payout $id)
    {
        if ($id->status == 'completed') {
            toastr()->warning(__('Requested payout has been processed and cannot be cancelled'));
            return redirect()->back();
        }

        if ($id->status == 'declined') {
            toastr()->warning(__('Requested payout has been declined by admin and cannot be cancelled'));
            return redirect()->back();
        }

        if ($id->status == 'cancelled') {
            toastr()->warning(__('Requested payout has already been cancelled'));
            return redirect()->back();
        }

        Payout::where('id', $id->id)->update(['status' => 'cancelled']);

        $user = User::where('id', $id->user_id)->firstOrFail();   
        $user->balance = ($user->balance + $id->total);
        $user->save();

        toastr()->success(__('Selected payout request has been cancelled successfully'));
        return redirect()->back();
    }


    /**
     * Show all payment referrals.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function referrals(Request $request)
    {
        if ($request->ajax()) {
            $data = Referral::whereNotNull('order_id')->where('referrer_id', auth()->user()->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('created-on', function($row){
                        $created_on = '<span>'.date_format($row["created_at"], 'Y-m-d H:i:s').'</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-rate', function($row){
                        $created_on = '<span>'.$row["rate"].'%</span>';
                        return $created_on;
                    })
                    ->addColumn('custom-payment', function($row){
                        $custom_status = config('payment.default_system_currency_symbol') . $row["payment"];
                        return $custom_status;
                    })
                    ->addColumn('custom-commission', function($row){
                        $custom_status = config('payment.default_system_currency_symbol') . $row["commission"];
                        return $custom_status;
                    })
                    ->rawColumns(['created-on', 'custom-rate', 'custom-payment', 'custom-commission'])
                    ->make(true);
                    
        }

    }

}
