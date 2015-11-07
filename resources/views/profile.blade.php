@extends('layouts.main')
@section('content')
    <div class="userinfo_bg">
        <div class="container pad_top">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-8 col-md-5 col-md-offset-7 col-sm-6 col-sm-offset-6">
                    <div class="pad_top pad_bottom">
                        <div class="col-sm-12 ">

                            <div class="col-xs-12 col-sm-12 well">
                                <div class="form-group"> <label><h2>First Last</h2></label> </div>
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="em" class="control-label">Email</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <span id="em">sample@gmail.com</span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="ph" class="control-label">Phone</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <span id="ph">(xxx) xxx-xxxx</span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-4">
                                        <label for="addr" class="control-label">Address</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <span id="addr">1189 W 29th St</span>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <button class="btn btn-large btn-primary btn-block" id="updateProfile">Update Profile</button>
                                </div>
                            </div>
                            <div class="col-sm-12">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop