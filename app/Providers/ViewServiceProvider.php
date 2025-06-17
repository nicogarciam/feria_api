<?php

namespace App\Providers;
use App\Models\Pay;
use App\Models\Account;





use App\Models\Membership;
use App\Models\MembershipType;
use App\Models\City;
use App\Models\Affiliate;
use App\Models\Afiliate;
use App\Models\User;

use Illuminate\Support\ServiceProvider;
use View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['pay_items.fields'], function ($view) {
            $payItems = Pay::pluck('name','id')->toArray();
            $view->with('payItems', $payItems);
        });
        View::composer(['vouchers.fields'], function ($view) {
            $membershipItems = Membership::pluck('name','id')->toArray();
            $view->with('membershipItems', $membershipItems);
        });
        View::composer(['vouchers.fields'], function ($view) {
            $membershipItems = Membership::pluck('name','id')->toArray();
            $view->with('membershipItems', $membershipItems);
        });
        View::composer(['vouchers.fields'], function ($view) {
            $membershipItems = Membership::pluck('name','id')->toArray();
            $view->with('membershipItems', $membershipItems);
        });
        View::composer(['vouchers.fields'], function ($view) {
            $membershipItems = Membership::pluck('name','id')->toArray();
            $view->with('membershipItems', $membershipItems);
        });
        View::composer(['fees.fields'], function ($view) {
            $payItems = Pay::pluck('name','id')->toArray();
            $view->with('payItems', $payItems);
        });
        View::composer(['fees.fields'], function ($view) {
            $membershipItems = Membership::pluck('name','id')->toArray();
            $view->with('membershipItems', $membershipItems);
        });
        View::composer(['fees.fields'], function ($view) {
            $accountItems = Account::pluck('name','id')->toArray();
            $view->with('accountItems', $accountItems);
        });
        View::composer(['movements.fields'], function ($view) {
            $payItems = Pay::pluck('name','id')->toArray();
            $view->with('payItems', $payItems);
        });
        View::composer(['movements.fields'], function ($view) {
            $membershipItems = Membership::pluck('name','id')->toArray();
            $view->with('membershipItems', $membershipItems);
        });
        View::composer(['movements.fields'], function ($view) {
            $accountItems = Account::pluck('name','id')->toArray();
            $view->with('accountItems', $accountItems);
        });
        View::composer(['accounts.fields'], function ($view) {
            $cityItems = City::pluck('name','id')->toArray();
            $view->with('cityItems', $cityItems);
        });
        View::composer(['pays.fields'], function ($view) {
            $userItems = User::pluck('name','id')->toArray();
            $view->with('userItems', $userItems);
        });
        View::composer(['pays.fields'], function ($view) {
            $affiliateItems = Affiliate::pluck('name','id')->toArray();
            $view->with('affiliateItems', $affiliateItems);
        });


        View::composer(['memberships.fields'], function ($view) {
            $membership_typeItems = MembershipType::pluck('description','id')->toArray();
            $view->with('membership_typeItems', $membership_typeItems);
        });
        View::composer(['memberships.fields'], function ($view) {
            $affiliateItems = Affiliate::pluck('name','id')->toArray();
            $view->with('affiliateItems', $affiliateItems);
        });


        View::composer(['entities.fields'], function ($view) {
            $cityItems = City::pluck('name','id')->toArray();
            $view->with('cityItems', $cityItems);
        });


        //
    }
}
