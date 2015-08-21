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
        time_of_day: $('#pick-up-time')
    };

    //A list of components to pick up from the address information returned by google api.
    this.componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
};

/**
 * Initializing google places auto complete on 2 input fields
 */
PoolMateForm.prototype.initAutocomplete = function() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    debugger;
    this.controls.source.autocomplete_object = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(this.controls.source.html_selector),
        {types: ['geocode']});

    this.controls.destination.autocomplete_object = new google.maps.places.Autocomplete(this.controls.destination.html_selector, {types: ['geocode']});

    // When the user selects an address from the dropdown, call the handler
    this.controls.source.autocomplete_object.addListener('place_changed', function() { debugger; });

    // When the user selects an address from the dropdown, call the handler
    this.controls.destination.autocomplete_object.addListener('place_changed', function() { debugger; });
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


$(document).ready(function() {
    //global function
    window.poolMateAutoCompleteManager = function () {
        var pool_mate_form_intance = new PoolMateForm();

        pool_mate_form_intance.initAutocomplete();

        $(pool_mate_form_intance.controls.source.html_selector).focusin(function() {
            pool_mate_form_intance.geolocate(pool_mate_form_intance.controls.source.autocomplete_object);
        });

        $(pool_mate_form_intance.controls.destination.html_selector).focusin(function() {
            pool_mate_form_intance.geolocate(pool_mate_form_intance.controls.destination.autocomplete_object);
        });


    };

});



