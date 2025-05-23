<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionPlan;
use App\Models\Subscriber;
use App\Models\User;
use Carbon\Carbon;

class RenewCreditsTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add credits for yearly/lifetime plans';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check subscription status, block the ones that missed payments.
     *
     * @return int
     */
    public function handle()
    {
        # Get all active subscriptions
        $subscriptions = Subscriber::where('status', 'Active')->get();
        
        foreach($subscriptions as $row) {

            # Check if yearly or lifetime plans
            if ($row->frequency == 'yearly' || $row->frequency == 'lifetime') {

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->active_until);

                $result = Carbon::createFromFormat('Y-m-d H:i:s', $date)->isPast();

                if (!$result) {            

                    $today = Carbon::now();
                    $subscription_day = $date->day;
                    $current_day = $today->day;
                    $days_in_month = $today->daysInMonth;

                    if ($subscription_day == $current_day) {
                        $user = User::where('id', $row->user_id)->firstOrFail();
                        $plan = SubscriptionPlan::where('id', $row->plan_id)->firstOrFail();
                        if ($user) {
                            $user->tokens = $plan->token_credits;
                            $user->characters = $plan->characters;
                            $user->minutes = $plan->minutes;
                            $user->images = $plan->image_credits;
                            $user->save();
                        }
                    } elseif ($subscription_day > $days_in_month) {
                        $user = User::where('id', $row->user_id)->firstOrFail();
                        $plan = SubscriptionPlan::where('id', $row->plan_id)->firstOrFail();
                        if ($user) {
                            $user->tokens = $plan->token_credits;
                            $user->characters = $plan->characters;
                            $user->minutes = $plan->minutes;
                            $user->images = $plan->image_credits;
                            $user->save();
                        }
                    }
                    
                }
            }

            if ($row->gateway == 'Manual') {

                $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->active_until);

                $result = Carbon::createFromFormat('Y-m-d H:i:s', $date)->isPast();

                if (!$result) {            

                    $today = Carbon::now();
                    $subscription_day = $date->day;
                    $current_day = $today->day;
                    $days_in_month = $today->daysInMonth;

                    if ($subscription_day == $current_day) {
                        $user = User::where('id', $row->user_id)->firstOrFail();
                        $plan = SubscriptionPlan::where('id', $row->plan_id)->firstOrFail();

                        if ($user) {
                            $user->tokens = $plan->token_credits;
                            $user->characters = $plan->characters;
                            $user->minutes = $plan->minutes;
                            $user->images = $plan->image_credits;
                            $user->save();
                        }
                    } elseif ($subscription_day > $days_in_month) {
                        $user = User::where('id', $row->user_id)->firstOrFail();
                        $plan = SubscriptionPlan::where('id', $row->plan_id)->firstOrFail();
                        if ($user) {
                            $user->tokens = $plan->token_credits;
                            $user->characters = $plan->characters;
                            $user->minutes = $plan->minutes;
                            $user->images = $plan->image_credits;
                            $user->save();
                        }
                    }
                    
                }

             }
        }
    }
}
