
/**
 * User Info Form on profile/edit page
 * @constructor
 */
var UserInfoForm = function () {
    //List of HTML element controls
    this.controls = {
        //first_name: $('#first_name').get(0),
        //last_name: $('#last_name').get(0),
        user_address: {
            html_selector: $('#user_address').get(0),
            //html_selector: document.getElementById("user_address"),
                //Destination address auto complete manager
                autocomplete_object: {}
        },
        //phone_number: $('#phone_number').get(0),
        //user_info_form: $('user-info-form')
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
UserInfoForm.prototype.initAutocomplete = function() {
    // handling closures
    var self = this;

    // Create the source autocomplete object, restricting the search to geographical
    // location types.
    this.controls.user_address.autocomplete_object = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(this.controls.user_address.html_selector),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, call the handler
    this.controls.user_address.autocomplete_object.addListener('place_changed', function() {
        self.sourceAddressChangeHandler(this);
    });
};

/** Bias the autocomplete object to the user's geographical location,
 *  as supplied by the browser's 'navigator.geolocation' object.
 */
UserInfoForm.prototype.geolocate = function ($invoked_element) {
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

UserInfoForm.prototype.sourceAddressChangeHandler = function(sourceAutocompleteObject) {
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
    var htmlSelector = this.controls.user_address.html_selector;
    this.setAddressComponentsOnField(addressComponents, lat, lng, htmlSelector);
};

UserInfoForm.prototype.setAddressComponentsOnField = function (addressComponentValues, lat, lng, $htmlField) {
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

UserInfoForm.prototype.getAddressComponentsOnField = function($htmlField) {
    var htmlElement = $($htmlField);
    var result = {};
    for (var component in this.componentForm) {
        if (this.componentForm.hasOwnProperty(component)) {
            result[component] = htmlElement.data(component);
        }
    }
    return result;
};


$(document).ready(function() {
    //global function, invoked by google places api
    window.userInfoAutoCompleteManager = function () {
        var user_info_form_intance = new UserInfoForm();

        user_info_form_intance.initAutocomplete();

        $(user_info_form_intance.controls.user_address.html_selector).focusin(function() {
            user_info_form_intance.geolocate(user_info_form_intance.controls.user_address.autocomplete_object);
        });

        $(user_info_form_intance.controls.user_info_form).submit(function() {
            //user_info_form_intance.requestSubmitHandler(this);
            return false;
        })
    };

    //AJAX call to ...
    $("user-info-form").submit(function(){
        //makeAJAXRequestToDisplayMatchedUsers();
        console.log("Form submitted");
    });

});