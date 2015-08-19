/**
 * Pool Mate Form on welcome page
 * @constructor
 */
var PoolMateForm = function () {
    //List of HTML element controls
    this.controls = {
        source: $('#pick-up-location'),
        destination: $('#drop-off-location'),
        time_of_day: $('#pick-up-time')
    };

    //Source address auto compelete manager
    this.source_address_autocomplete = {};

    //Destination address auto complete manager
    this.destination_address_autocomplete = {};

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
 *
 */
PoolMateForm.prototype.initAutocomplete = function() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    this.source_address_autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(this.controls.source),
        {types: ['geocode']});

    this.destination_address_autocomplete = new google.maps.places.Autocomplete(this.controls.destination, {types: ['geocode']});

    // When the user selects an address from the dropdown, call the handler
    this.source_address_autocomplete.addListener('place_changed', fillInAddress);

    // When the user selects an address from the dropdown, call the handler
    this.destination_address_autocomplete.addListener('place_changed', fillInAddress);
};

/** Bias the autocomplete object to the user's geographical location,
 *  as supplied by the browser's 'navigator.geolocation' object.
 */
PoolMateForm.prototype.geolocate = function () {
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
            self.source_address_autocomplete.setBounds(circle.getBounds());
        });
    }
};


