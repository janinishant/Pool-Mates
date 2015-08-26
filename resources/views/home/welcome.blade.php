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
                    <select multiple class="form-control" id="pick-up-time" name="pick-up-time" required>
                        <option>00:00</option>
                        <option>00:30</option>
                        <option>01:00</option>
                        <option>01:30</option>
                        <option>02:00</option>
                        <option>02:30</option>
                        <option>03:00</option>
                        <option>04:00</option>
                        <option>04:30</option>
                        <option>05:00</option>
                        <option>05:30</option>
                        <option>06:00</option>
                        <option>06:30</option>
                        <option>07:00</option>
                        <option>07:30</option>
                        <option>08:00</option>
                        <option>08:30</option>
                        <option>09:00</option>
                        <option>09:30</option>
                        <option>10:00</option>
                        <option>10:30</option>
                        <option>11:00</option>
                        <option>11:30</option>
                        <option>12:00</option>
                        <option>12:30</option>
                        <option>13:00</option>
                        <option>13:30</option>
                        <option>14:00</option>
                        <option>14:30</option>
                        <option>15:00</option>
                        <option>15:30</option>
                        <option>16:00</option>
                        <option>16:30</option>
                        <option>17:00</option>
                        <option>17:30</option>
                        <option>18:00</option>
                        <option>18:30</option>
                        <option>19:00</option>
                        <option>19:30</option>
                        <option>20:00</option>
                        <option>20:30</option>
                        <option>21:00</option>
                        <option>21:30</option>
                        <option>22:00</option>
                        <option>22:30</option>
                        <option>23:00</option>
                        <option>23:30</option>
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