<li class="{{ Request::is('cities*') ? 'active' : '' }}">
    <a href="{{ route('cities.index') }}"><i class="fa fa-edit"></i><span>Cities</span></a>
</li>

<li class="{{ Request::is('affiliates*') ? 'active' : '' }}">
    <a href="{{ route('affiliates.index') }}"><i class="fa fa-edit"></i><span>Affiliates</span></a>
</li>

<li class="{{ Request::is('entities*') ? 'active' : '' }}">
    <a href="{{ route('entities.index') }}"><i class="fa fa-edit"></i><span>Entities</span></a>
</li>


<li class="{{ Request::is('userEntities*') ? 'active' : '' }}">
    <a href="{{ route('userEntities.index') }}"><i class="fa fa-edit"></i><span>User Entities</span></a>
</li>

<li class="{{ Request::is('pays*') ? 'active' : '' }}">
    <a href="{{ route('pays.index') }}"><i class="fa fa-edit"></i><span>Pays</span></a>
</li>

<li class="{{ Request::is('memberships*') ? 'active' : '' }}">
    <a href="{{ route('memberships.index') }}"><i class="fa fa-edit"></i><span>Memberships</span></a>
</li>

<li class="{{ Request::is('membershipTypes*') ? 'active' : '' }}">
    <a href="{{ route('membershipTypes.index') }}"><i class="fa fa-edit"></i><span>Membership Types</span></a>
</li>

<li class="{{ Request::is('families*') ? 'active' : '' }}">
    <a href="{{ route('families.index') }}"><i class="fa fa-edit"></i><span>Families</span></a>
</li>

<li class="{{ Request::is('accounts*') ? 'active' : '' }}">
    <a href="{{ route('accounts.index') }}"><i class="fa fa-edit"></i><span>Accounts</span></a>
</li>

<li class="{{ Request::is('$MODELNAMES*') ? 'active' : '' }}">
    <a href="{{ route('$MODELNAMES.index') }}"><i class="fa fa-edit"></i><span>$ M O D E L  N A M E S</span></a>
</li>

<li class="{{ Request::is('businesses*') ? 'active' : '' }}">
    <a href="{{ route('businesses.index') }}"><i class="fa fa-edit"></i><span>Businesses</span></a>
</li>

<li class="{{ Request::is('benefits*') ? 'active' : '' }}">
    <a href="{{ route('benefits.index') }}"><i class="fa fa-edit"></i><span>Benefits</span></a>
</li>

<li class="{{ Request::is('favoriteBenefits*') ? 'active' : '' }}">
    <a href="{{ route('favoriteBenefits.index') }}"><i class="fa fa-edit"></i><span>Favorite Benefits</span></a>
</li>

<li class="{{ Request::is('benefitPlaces*') ? 'active' : '' }}">
    <a href="{{ route('benefitPlaces.index') }}"><i class="fa fa-edit"></i><span>Benefit Places</span></a>
</li>

<li class="{{ Request::is('benefitSchedules*') ? 'active' : '' }}">
    <a href="{{ route('benefitSchedules.index') }}"><i class="fa fa-edit"></i><span>Benefit Schedules</span></a>
</li>

<li class="{{ Request::is('tags*') ? 'active' : '' }}">
    <a href="{{ route('tags.index') }}"><i class="fa fa-edit"></i><span>Tags</span></a>
</li>

<li class="{{ Request::is('memberTypeHists*') ? 'active' : '' }}">
    <a href="{{ route('memberTypeHists.index') }}"><i class="fa fa-edit"></i><span>Member Type Hists</span></a>
</li>

<li class="{{ Request::is('activities*') ? 'active' : '' }}">
    <a href="{{ route('activities.index') }}"><i class="fa fa-edit"></i><span>Activities</span></a>
</li>

<li class="{{ Request::is('activityGroups*') ? 'active' : '' }}">
    <a href="{{ route('activityGroups.index') }}"><i class="fa fa-edit"></i><span>Activity Groups</span></a>
</li>

<li class="{{ Request::is('activityGroupSchedules*') ? 'active' : '' }}">
    <a href="{{ route('activityGroupSchedules.index') }}"><i class="fa fa-edit"></i><span>Activity Group Schedules</span></a>
</li>

<li class="{{ Request::is('instructors*') ? 'active' : '' }}">
    <a href="{{ route('instructors.index') }}"><i class="fa fa-edit"></i><span>Instructors</span></a>
</li>

<li class="{{ Request::is('feeConfigs*') ? 'active' : '' }}">
    <a href="{{ route('feeConfigs.index') }}"><i class="fa fa-edit"></i><span>Fee Configs</span></a>
</li>

<li class="{{ Request::is('movements*') ? 'active' : '' }}">
    <a href="{{ route('movements.index') }}"><i class="fa fa-edit"></i><span>Movements</span></a>
</li>

<li class="{{ Request::is('fees*') ? 'active' : '' }}">
    <a href="{{ route('fees.index') }}"><i class="fa fa-edit"></i><span>Fees</span></a>
</li>

<li class="{{ Request::is('vouchers*') ? 'active' : '' }}">
    <a href="{{ route('vouchers.index') }}"><i class="fa fa-edit"></i><span>Vouchers</span></a>
</li>

<li class="{{ Request::is('payItems*') ? 'active' : '' }}">
    <a href="{{ route('payItems.index') }}"><i class="fa fa-edit"></i><span>Pay Items</span></a>
</li>

<li class="{{ Request::is('membershipActivityGroups*') ? 'active' : '' }}">
    <a href="{{ route('membershipActivityGroups.index') }}"><i class="fa fa-edit"></i><span>Membership Activity Groups</span></a>
</li>

<li class="{{ Request::is('activitySubscriptions*') ? 'active' : '' }}">
    <a href="{{ route('activitySubscriptions.index') }}"><i class="fa fa-edit"></i><span>Activity Subscriptions</span></a>
</li>

<li class="{{ Request::is('bookings*') ? 'active' : '' }}">
    <a href="{{ route('bookings.index') }}"><i class="fa fa-edit"></i><span>Bookings</span></a>
</li>

<li class="{{ Request::is('accommodations*') ? 'active' : '' }}">
    <a href="{{ route('accommodations.index') }}"><i class="fa fa-edit"></i><span>Accommodations</span></a>
</li>

<li class="{{ Request::is('accommodationPrices*') ? 'active' : '' }}">
    <a href="{{ route('accommodationPrices.index') }}"><i class="fa fa-edit"></i><span>Accommodation Prices</span></a>
</li>

<li class="{{ Request::is('accommodationTypes*') ? 'active' : '' }}">
    <a href="{{ route('accommodationTypes.index') }}"><i class="fa fa-edit"></i><span>Accommodation Types</span></a>
</li>

<li class="{{ Request::is('bookingCharges*') ? 'active' : '' }}">
    <a href="{{ route('bookingCharges.index') }}"><i class="fa fa-edit"></i><span>Booking Charges</span></a>
</li>

<li class="{{ Request::is('bookingStates*') ? 'active' : '' }}">
    <a href="{{ route('bookingStates.index') }}"><i class="fa fa-edit"></i><span>Booking States</span></a>
</li>

<li class="{{ Request::is('coupons*') ? 'active' : '' }}">
    <a href="{{ route('coupons.index') }}"><i class="fa fa-edit"></i><span>Coupons</span></a>
</li>

<li class="{{ Request::is('discounts*') ? 'active' : '' }}">
    <a href="{{ route('discounts.index') }}"><i class="fa fa-edit"></i><span>Discounts</span></a>
</li>

<li class="{{ Request::is('guests*') ? 'active' : '' }}">
    <a href="{{ route('guests.index') }}"><i class="fa fa-edit"></i><span>Guests</span></a>
</li>

<li class="{{ Request::is('hotels*') ? 'active' : '' }}">
    <a href="{{ route('hotels.index') }}"><i class="fa fa-edit"></i><span>Hotels</span></a>
</li>

<li class="{{ Request::is('paymentItems*') ? 'active' : '' }}">
    <a href="{{ route('paymentItems.index') }}"><i class="fa fa-edit"></i><span>Payment Items</span></a>
</li>

<li class="{{ Request::is('paymentStates*') ? 'active' : '' }}">
    <a href="{{ route('paymentStates.index') }}"><i class="fa fa-edit"></i><span>Payment States</span></a>
</li>

<li class="{{ Request::is('paymentTypes*') ? 'active' : '' }}">
    <a href="{{ route('paymentTypes.index') }}"><i class="fa fa-edit"></i><span>Payment Types</span></a>
</li>

<li class="{{ Request::is('payments*') ? 'active' : '' }}">
    <a href="{{ route('payments.index') }}"><i class="fa fa-edit"></i><span>Payments</span></a>
</li>

<li class="{{ Request::is('roomCharges*') ? 'active' : '' }}">
    <a href="{{ route('roomCharges.index') }}"><i class="fa fa-edit"></i><span>Room Charges</span></a>
</li>

<li class="{{ Request::is('seasons*') ? 'active' : '' }}">
    <a href="{{ route('seasons.index') }}"><i class="fa fa-edit"></i><span>Seasons</span></a>
</li>

<li class="{{ Request::is('bankAccounts*') ? 'active' : '' }}">
    <a href="{{ route('bankAccounts.index') }}"><i class="fa fa-edit"></i><span>Bank Accounts</span></a>
</li>

<li class="{{ Request::is('bookingDiscounts*') ? 'active' : '' }}">
    <a href="{{ route('bookingDiscounts.index') }}"><i class="fa fa-edit"></i><span>Booking Discounts</span></a>
</li>

<li class="{{ Request::is('customers*') ? 'active' : '' }}">
    <a href="{{ route('customers.index') }}"><i class="fa fa-edit"></i><span>Customers</span></a>
</li>

