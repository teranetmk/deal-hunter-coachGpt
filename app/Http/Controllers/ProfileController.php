<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\CustomerCard;
use App\Models\PurchaseLog;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public $plansList = [
        ["id" => 1,"credits" => 100, "name" => "100 Credits" , "price" => 20],
        ["id" => 2,"credits" => 500, "name" => "500 Credits" , "price" => 100],
        ["id" => 3,"credits" => 1000, "name" => "1,000 Credits" , "price" => 200],
        ["id" => 4,"credits" => 2500, "name" => "2,500 Credits" , "price" => 500],
        ["id" => 5,"credits" => 5000, "name" => "5,000 Credits" , "price" => 1000],
        ["id" => 6,"credits" => 10000, "name" => "10,000 Credits" , "price" => 2000],
    ];
    public function creditTopup(Request $request) {
        if(empty(auth()->user()->stripe_id)) {
            return ["status" => "error", "message" => "Please attach card first.", 'credits' => auth()->user()->total_credits];
        }
        $plan = collect($this->plansList)->where('id', $request->plan);
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $plan = $plan->first();
        try {

            $res = $stripe->charges->create([
                'amount' => $plan["price"] * 100,
                'currency' => 'usd',
                "customer" => auth()->user()->stripe_id,
                'description' => 'Payment from customer email '.auth()->user()->email,
            ]);

        } catch (\Throwable $th) {
            return ["status" => "error", "message" => $th->getMessage(), 'credits' => auth()->user()->total_credits];
        }

        $card = auth()->user()->card;

        PurchaseLog::create([
            'user_id' => auth()->user()->id,
            'plan_id' => $plan["id"],
            'credits' => $plan["credits"],
            'price' => $plan["price"],
            'card' => $card->card_number,
        ]);

        $user = auth()->user();
        $user->total_credits += $plan["credits"];
        $user->update();
        return ["status" => "success", "message" => "Credits added successfully", 'credits' => auth()->user()->total_credits, "purchases" => PurchaseLog::where("user_id", auth()->user()->id)->get()];

    }
    public function addCard(Request $request) {
        $user = auth()->user();
        if(empty($user->stripe_id)) {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            $customer = $stripe->customers->create([
                'description' => 'Customer for credits',
                'email' => $user->email
            ]);

            $user->stripe_id = $customer->id;
            $user->save();
        }
        $card_token = $request->token;  // tok_***********************

        // fetch your customer ID from your DB or create a new customer

        $customer_id = auth()->user()->stripe_id;

        // Get stripe secret key from your constants file

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        // create and save card on stripe
        $card_response = $stripe->customers->createSource(
          $customer_id,
          [
            'source' => $card_token
          ]
        );
        // From the response you can store the partial card detail on your local DB also
        CustomerCard::updateOrCreate(['user_id' => auth()->user()->id],[
            'user_id' => auth()->user()->id,
            'pm_id' => 1,
            'brand' => $card_response->brand,
            'exp_month' => $card_response->exp_month,
            'exp_year' => $card_response->exp_year,
            'card_number' => $card_response->last4,
        ]);

        return ["status" => "success", "message" => "Card Added Successfully.", "card" => CustomerCard::where("user_id", auth()->user()->id)->first()];
        // return $card_response;
    }
    public function instaUpdate(Request $request) {
        $user = auth()->user();
        $user->offer = $request->offer;
        $user->update();

        // return Redirect::route('profile.insta');

        // return $user->offer;
    }



    public function credits(Request $request): Response
    {

        return Inertia::render('Profile/Credits', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'offer' => auth()->user()->offer,
            'addedCard' => CustomerCard::where("user_id", auth()->user()->id)->first(),
            'plansList' => $this->plansList,
            "purchases" => PurchaseLog::where("user_id", auth()->user()->id)->get()
        ]);
    }
    public function insta(Request $request): Response
    {
        return Inertia::render('Profile/Insta', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'offer' => auth()->user()->offer
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function upgrade_membership(Request $request) {
        $user = auth()->user();
        if(!$user->is_premium) {
            if(empty($user->stripe_id)) {
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );
                $customer = $stripe->customers->create([
                    'description' => 'Customer for credits',
                    'email' => $user->email
                ]);

                $user->stripe_id = $customer->id;
                $user->save();
            }
            $card_token = $request->token;
            $customer_id = auth()->user()->stripe_id;
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $card_response = $stripe->customers->createSource(
              $customer_id,
              [
                'source' => $card_token
              ]
            );

            CustomerCard::updateOrCreate(['user_id' => auth()->user()->id],[
                'user_id' => auth()->user()->id,
                'pm_id' => 1,
                'brand' => $card_response->brand,
                'exp_month' => $card_response->exp_month,
                'exp_year' => $card_response->exp_year,
                'card_number' => $card_response->last4,
            ]);

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );
            try {

                $res = $stripe->charges->create([
                    'amount' => 997 * 100,
                    'currency' => 'usd',
                    "customer" => auth()->user()->stripe_id,
                    'description' => 'Upgrade members for email '.auth()->user()->email,
                ]);

                $user = auth()->user();
                $user->is_premium = true;
                $user->save();
                return ["status" => "success", "message" => "Membership upgraded successfully.", "user" => auth()->user()];
            } catch (\Throwable $th) {
                return ["status" => "error", "message" => $th->getMessage(), 'credits' => auth()->user()->total_credits];
            }
        }
        return ["status" => "error", "message" => 'User is already a premium member'];
    }
}
