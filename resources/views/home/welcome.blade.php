@extends('layouts.main')
@section('content')
    <div class="container" style="height: 100px; padding-top: 50px;">
        <form name="pool-mate-form" id="pool-mate-form" class="form-horizontal well">
            <div class="form-group">
                <div class="col-sm-12 col-lg-4">
                    <label for="pick-up-location">Pick-up Location</label>
                    <p class="help-block"></p>
                    <input id="pick-up-location" class="form-control input-group-lg reg_name" type="text" name="pick-up-location" title="Enter pick-up location" placeholder="Pick-up location" required>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <label for="drop-off-location">Drop-off Location</label>
                    <p class="help-block"></p>
                    <input id="drop-off-location" class="form-control input-group-lg reg_name" type="text" name="drop-off-location" title="Enter drop-off location" placeholder="Drop-off location" required>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <label for="pick-up-time" >Pick up time</label>
                    <p class="help-block"></p>
                    <select multiple="multiple" class="form-control" id="pick-up-time" name="pick-up-time[]" required>
                        <option value="0">00:00</option>
                        <option value="1">00:30</option>
                        <option value="2">01:00</option>
                        <option value="3">01:30</option>
                        <option value="4">02:00</option>
                        <option value="5">02:30</option>
                        <option value="6">03:00</option>
                        <option value="7">04:00</option>
                        <option value="8">04:30</option>
                        <option value="9">05:00</option>
                        <option value="10">05:30</option>
                        <option value="11">06:00</option>
                        <option value="12">06:30</option>
                        <option value="13">07:00</option>
                        <option value="14">07:30</option>
                        <option value="15">08:00</option>
                        <option value="16">08:30</option>
                        <option value="17">09:00</option>
                        <option value="18">09:30</option>
                        <option value="19">10:00</option>
                        <option value="20">10:30</option>
                        <option value="21">11:00</option>
                        <option value="22">11:30</option>
                        <option value="23">12:00</option>
                        <option value="24">12:30</option>
                        <option value="25">13:00</option>
                        <option value="26">13:30</option>
                        <option value="27">14:00</option>
                        <option value="28">14:30</option>
                        <option value="29">15:00</option>
                        <option value="30">15:30</option>
                        <option value="31">16:00</option>
                        <option value="32">16:30</option>
                        <option value="33">17:00</option>
                        <option value="34">17:30</option>
                        <option value="36">18:00</option>
                        <option value="37">18:30</option>
                        <option value="38">19:00</option>
                        <option value="39">19:30</option>
                        <option value="40">20:00</option>
                        <option value="41">20:30</option>
                        <option value="42">21:00</option>
                        <option value="43">21:30</option>
                        <option value="44">22:00</option>
                        <option value="45">22:30</option>
                        <option value="46">23:00</option>
                        <option value="47">23:30</option>
                    </select>
                </div>
            </div><!--/form-group-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-8">
                    <button class="btn btn-primary btn-group-lg pm-long-button" type="submit"> <i class="fa fa-search"></i> Find Mates</button>

                </div>
            </div>

        </form>
    </div>
@stop