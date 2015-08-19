@extends('layouts.main')
@section('content')
    <div class="main-header">
        <div class="main-header-content">
            <i class="fa fa-users fa-5x"></i>
            <p class="main-header-text">Pool Mates</p>
            <div class="facebook-login-button">
                <a class="btn btn-block btn-social btn-facebook" href="/login/facebook">
                    <i class="fa fa-facebook"></i> Sign in with Facebook
                </a></div>
            <h2><em>Discover Lyft Line Mates Around You.</em></h2>
        </div>
    </div>
    <div class="main-info">
        <div class="main-info-content">
            <div class="benefits">
                <div class="benefit">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa  fa-usd"></i> </div>
                            <div class="info">
                                <h3 class="title">Save Money</h3>
                                <p>
                                    12 pending tasks awaiting approval and review.
                                </p>
                            </div>
                        </div>
                        <div class="space"></div>
                    </div>
                </div>

                <div class="benefit">
                    <div class="box">
                        <div class="icon">
                            <div class="image"><i class="fa fa-clock-o"></i> </div>
                            <div class="info">
                                <h3 class="title">Plan Trips & Save Time</h3>
                                <p>
                                    12 pending tasks awaiting approval and review.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop