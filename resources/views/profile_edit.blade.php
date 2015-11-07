@extends('layouts.main')
@section('content')
    <div class="userinfo_bg">
        <div class="container pad_top">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-8 col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6">
                    <div class="pad_top pad_bottom">
                        <div class="col-sm-12 ">
                            <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=userInfoAutoCompleteManager" async defer></script>
                            <div class="well">
                                <form name="user-info-form" id="user-info-form">
                                    <div align="center">
                                        <img src="images/profilelarge.png" id="profile_pic" width="30%" class="img-responsive">
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="first_name" required ng-minlength="2" placeholder="First Name" name="first_name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="last_name" required ng-minlength="2" placeholder="Last Name" name="last_name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="user_address" name="user_address" placeholder="Address">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" minlength="10" maxlength="10" class="form-control" id="phone_number" placeholder="Phone" name="phone_number">
                                    </div>

                                    <div class="row" id="updateCancelProfile">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <button class="btn btn-large btn-default btn-block" id="cancelEdit"><i class="glyphicon glyphicon-remove"></i> Cancel</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <button class="btn btn-large btn-primary btn-block" id="updateProfile"><i class="glyphicon glyphicon-save-file"></i> Update Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop