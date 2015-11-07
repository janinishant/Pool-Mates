/**
 * Pool Mate Form on welcome page
 * @constructor
 */
var PoolMateForm = function () {
    //List of HTML element controls
    this.controls = {
        source: {
            html_selector: $('#pick-up-location').get(0),
            //Source address auto compelete manager
            autocomplete_object: {}
        },
        destination: {
            html_selector: $('#drop-off-location').get(0),
            //Destination address auto complete manager
            autocomplete_object: {}
        },
        time_of_day: $('#pick-up-time'),
        pool_mate_form: $('#pool-mate-form')
    };

    //A list of components to pick up from the address information returned by google api.
    this.componentForm = {
        //1189
        street_number: 'long_name',
        //Will hold W 29th St
        route: 'long_name',
        //Will hold something sort of Southern LA, would ideally match users on this basis first
        //before invoking gdm api
        neighborhood: 'long_name',
        //Gives sort of the city name, will hold LA for us
        locality: 'long_name',
        //will hold kind of the county name, so LA for us
        administrative_area_level_2: 'long_name',
        //Holds the state name, so CA for us.
        administrative_area_level_1: 'long_name',
        //United States
        country: 'long_name',
        //Zip Postal code 90007
        postal_code: 'short_name',
        lat: true,
        lng: true
    };
};

/**
 * Initializing google places auto complete on 2 input fields
 */
PoolMateForm.prototype.initAutocomplete = function() {
    // handling closures
    var self = this;

    // Create the source autocomplete object, restricting the search to geographical
    // location types.
    this.controls.source.autocomplete_object = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(this.controls.source.html_selector),
        {types: ['geocode']});

    // Create the destination autocomplete object, restricting the search to geographical
    // location types.
    this.controls.destination.autocomplete_object = new google.maps.places.Autocomplete(this.controls.destination.html_selector, {types: ['geocode']});

    // When the user selects an address from the dropdown, call the handler
    this.controls.source.autocomplete_object.addListener('place_changed', function() {
        self.sourceAddressChangeHandler(this);
    });

    // When the user selects an address from the dropdown, call the handler
    this.controls.destination.autocomplete_object.addListener('place_changed', function() {
        self.destinationAddressChangeHandler(this);
    });
};

/** Bias the autocomplete object to the user's geographical location,
 *  as supplied by the browser's 'navigator.geolocation' object.
 */
PoolMateForm.prototype.geolocate = function ($invoked_element) {
    var self = this;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            $invoked_element.setBounds(circle.getBounds());
        });
    }
};

/**
 * This function is responsible to handling all the events when the source address
 * for the request is changed. We set the various address component for the address
 * in data fields of the input field.
 *
 * This way when request is submitted, we can easily serialize it into our AJAX data.
 */
PoolMateForm.prototype.sourceAddressChangeHandler = function(sourceAutocompleteObject) {
    var addressComponentsObject = sourceAutocompleteObject.getPlace();
    var addressComponents = {};
    if (addressComponentsObject.hasOwnProperty('address_components')) {
        addressComponents = addressComponentsObject['address_components'];
    }

    var lat = '', lng = '';
    if (addressComponentsObject.hasOwnProperty('geometry')) {
        if (addressComponentsObject.geometry.hasOwnProperty('location')) {
            lat = addressComponentsObject.geometry.location.lat();
            lng = addressComponentsObject.geometry.location.lng();
        }
    }
    var htmlSelector = this.controls.source.html_selector;
    this.setAddressComponentsOnField(addressComponents, lat, lng, htmlSelector);
};

/**
 * This function is responsible to handling all the events when the destination address
 * for the request is changed. We set the various address component for the address
 * in data fields of the input field.
 *
 * This way when request is submitted, we can easily serialize it into our AJAX data.
 * Currently destinationAddressChangeHandler & sourceAddressChangeHandler are almost same.
 * NOTE: In future if we dont add any specific functionality will merge the two.
 */
PoolMateForm.prototype.destinationAddressChangeHandler = function(destinationAutocompleteObject) {
    var addressComponentsObject = destinationAutocompleteObject.getPlace();
    var addressComponents = {};
    if (addressComponentsObject.hasOwnProperty('address_components')) {
        addressComponents = addressComponentsObject['address_components'];
    }

    var lat = '', lng = '';
    if (addressComponentsObject.hasOwnProperty('geometry')) {
        if (addressComponentsObject.geometry.hasOwnProperty('location')) {
            lat = addressComponentsObject.geometry.location.lat();
            lng = addressComponentsObject.geometry.location.lng();
        }
    }
    var htmlSelector = this.controls.destination.html_selector;
    this.setAddressComponentsOnField(addressComponents,lat, lng, htmlSelector);
};

/**
 * This method is incharge of setting all the address compoenents defined in the constructor
 * and whose values are provided by google api, on the data attributes of the field defined in
 * the method parameter.
 *
 * $htmlField Jquery object on which to set data attributes
 */
PoolMateForm.prototype.setAddressComponentsOnField = function (addressComponentValues, lat, lng, $htmlField) {
    if (!$htmlField) {
        console.error("No html field passed");
    }
    for (var component in this.componentForm) {
        //clear any previous data fields.
        if (this.componentForm.hasOwnProperty(component)) {
            $($htmlField).data(component, '');
        }
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < addressComponentValues.length; i++) {
        var addressType = addressComponentValues[i].types[0];
        if (this.componentForm[addressType]) {
            var addressComponentValue = addressComponentValues[i][this.componentForm[addressType]];
            $($htmlField).data(addressType, addressComponentValue);
        }
    }

    $($htmlField).data('lat', lat);
    $($htmlField).data('lng', lng);
};

/**
 * Serialize address information of the source or destination while making AJAX request.
 *
 * @param $htmlField Source or destination input field.
 * @returns {{}} Key value pair of address component and its value
 */
PoolMateForm.prototype.getAddressComponentsOnField = function($htmlField) {
    var htmlElement = $($htmlField);
    var result = {};
    for (var component in this.componentForm) {
        if (this.componentForm.hasOwnProperty(component)) {
            result[component] = htmlElement.data(component);
        }
    }
    return result;
};

/**
 * Submit handler for request.
 *
 * Serialize the form.
 * - Ideally validate all the fields
 * - Get all components of source & destination addresses
 * - Get all the pick up times.
 * - Render top 10 search results.
 */
PoolMateForm.prototype.requestSubmitHandler = function (submittedForm) {
    var formParams = $(submittedForm).serialize();
    var sourceAddressComponents = this.getAddressComponentsOnField(this.controls.source.html_selector);
    var destinationAddressComponents = this.getAddressComponentsOnField(this.controls.destination.html_selector);

    var auxiliaryAddressComponents = {
        sourceAddressComponents: sourceAddressComponents,
        destinationAddressComponents: destinationAddressComponents
    };
    formParams += '&'+ $.param(auxiliaryAddressComponents);
    this.findPoolMates(formParams);
};

/**
 * Method responsible for making the AJAX request to get matches for pool request
 * @param queryData
 */
PoolMateForm.prototype.findPoolMates = function(queryData) {
    //$.ajax({
    //    url: '/api/v1/request/',
    //    data: queryData,
    //    type: 'POST',
    //    dataType: 'json',
    //    success: function(a,b,c) {
    //        debugger;
    //    },
    //    error: function(a,b,c) {
    //        $('#demo').html(a.responseText);
    //    },
    //    complete: function() {
    //        $('body').removeClass("loading");
    //    }
    //});
    makeAJAXRequestToDisplayMatchedUsers();
};

$(document).ready(function() {
    //global function, invoked by google places api
    window.poolMateAutoCompleteManager = function () {

        var pool_mate_form_intance = new PoolMateForm();

        pool_mate_form_intance.initAutocomplete();

        $(pool_mate_form_intance.controls.source.html_selector).focusin(function() {
            pool_mate_form_intance.geolocate(pool_mate_form_intance.controls.source.autocomplete_object);
        });

        $(pool_mate_form_intance.controls.destination.html_selector).focusin(function() {
            pool_mate_form_intance.geolocate(pool_mate_form_intance.controls.destination.autocomplete_object);
        });

        $(pool_mate_form_intance.controls.pool_mate_form).submit(function() {
            pool_mate_form_intance.requestSubmitHandler(this);
            return false;
        })
    };

    //AJAX call to get and display the matched users
    $("pool-mate-form").submit(function(){
        makeAJAXRequestToDisplayMatchedUsers();
    });

});

function makeAJAXRequestToDisplayMatchedUsers(){
    $.ajax({
        url: "/api/v1/request_match/13",
        dataType: "json",
        success: function(result){
            //$("#matchedResults1").html(result.request_id);
            var resulthtml = '<div class="row">\
            <div class="col-sm-6 col-sm-offset-3">';
            //var best_matches = result.best_matches;
            for(var i=0;i<result.best_matches.length;i++){
                resulthtml += '<div class="well">\
                    <div class="row">\
                        <div class="col-sm-2">\
                            <div style="width:80px; height:85px; background-color: darkgrey;"></div>\
                        </div>\
                        <div class="col-sm-10">\
                            <div class="row">\
                                <div class="col-sm-10">\
                                    <span class="font_bold"> First Last</span>\
                                </div>\
                                <div class="col-sm-2 text-right">\
                                    8:00am\
                                </div>\
                                <div class="col-sm-12">\
                                <hr>\
                                </div>\
                                <div class="col-sm-10">\
                                    '+result.best_matches[i].matched_source.full_address+'\
                                </div>\
                                <div class="col-sm-2 text-right">\
                                    '+result.best_matches[i].matched_source.gdm_walk_distance_estimate+'\
                                </div>\
                                <div class="col-sm-10">\
                                    <span class="font_pink">To: </span>'+result.best_matches[i].matched_destination.full_address+'\
                                </div>\
                                <div class="col-sm-2 text-right">\
                                    '+result.best_matches[i].matched_destination.gdm_walk_distance_estimate+'\
                                </div>\
                            </div>\
                        </div>\
                        <div class="col-sm-12"><br></div>\
                            <div class="col-sm-8">\
                                <br><span class="font_medium"> Suggested ride: Uber (You save <span class="font_bold font_pink">$15</span>)</span>\
                        </div>\
                        <div class="col-sm-4 text-right">\
                            <button type="button" class="btn btn-default msg"><span class="glyphicon glyphicon-comment"></span>&nbsp; Contact user</button>\
                        </div>\
                    </div>\
                </div>';
            }
            resulthtml += '</div>\
                </div>';
            $('#matchedResults').html(resulthtml);
            $('.msg').click(function(){
                $.ajax({
                    url: "http://twilio-env1.elasticbeanstalk.com/send-sms.php?name=Tushal&phone=+12132949671",
                    type: "GET",
                    success: function(result){
                        alert(result);
                    },
                    error: function(result,b,c) {
                        console.log(result);
                    }
                });
            });
        },
        error: function(result,b,c) {
            console.log(result);
        }
    });
}



