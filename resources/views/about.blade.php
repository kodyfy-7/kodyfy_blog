@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">About App</div>

                <div class="card-body">
                    <p class="text-muted text-small mb-0">BlogApp offers a rewarding system for daily tasks such as reading articles and referrals. Upon accumulating the said target, each user is offered a chance for withdrawals which is submitted to the admin for verification, after which a supposed amount of money is sent to the user via etherum and the user cycle restarts.</p>
                    <br><br>
                    <h2 class="h5">Demo Accounts</h2>
                    <p class="text-muted text-small mb-0">
                        Admin account - Email address: admin@admin.com | Password: password
                    </p>
                    <p class="text-muted text-small mb-0">
                        User account - Email address: user@user.com | Password: password
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
