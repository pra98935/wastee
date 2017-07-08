jQuery(document).ready(function(){



    // js for offer section
//    jQuery(".product_offer .slide").hide();
//    jQuery(".opener").click(function(){
//        jQuery(this).next(".slide").slideToggle();
//    })
//
//    //jQuery(".product_offer").hide();
//    jQuery(".no-offers-yet-login a").click(function(){
//        jQuery(".product_offer").slideDown();
//        jQuery(".no-offers-yet-login").hide();
//    });

    // js for watch box
    jQuery(".watchbox .product-menu").hide();
    jQuery(".open-product-menu").click(function(){
        alert("hohello");
        //jQuery(this).next("ul.product-menu").slideToggle();
    });

    // at detail page cancil, confirm
        jQuery(".confirm-reject-box .cencel-step-1").hide();
        jQuery(".confirm-reject-box .cencel-step-3").hide();

        jQuery(".confirm-reject-box .abort.cancel").click(function(){
            jQuery(".confirm-reject-box .confirm-step-1").hide();
            jQuery(".confirm-reject-box .cencel-step-1").slideToggle();
        })

        jQuery(".confirm-reject-box .with-reason").click(function(){
            jQuery(".confirm-reject-box .cencel-step-3").slideDown();
            jQuery(".confirm-reject-box .cencel-step-2").hide();
        })

        jQuery(".confirm-reject-box .close-panel").click(function(){
            jQuery(".confirm-reject-box .cencel-step-3").slideUp();
            jQuery(".confirm-reject-box .cencel-step-2").show();
        });

        jQuery(".confirm-reject-box .confirm-step-1").hide();
        jQuery(".confirm-reject-box .confirm").click(function(){
            jQuery(".confirm-reject-box .cencel-step-1").hide();
            jQuery(".confirm-reject-box .confirm-step-1").slideToggle();
        })
    //end    

    jQuery(window).scroll(function() {
        
   	   if(jQuery(this).scrollTop() > 100) { // this refers to window
	        jQuery('.footer-sec').show();
	    }else{
            jQuery('.footer-sec').hide();
	    }
    });

    jQuery(".notification-box").hide();
    jQuery(".avatarimg").click(function(){
        jQuery(".notification-box").slideToggle();
    });
    

    // detail page toggle
    jQuery(".report-wrapper").hide();
    jQuery(".item-date .report").click(function(){
	    jQuery(".report-wrapper").slideToggle();
	});

    // header catehory toggle
     
    jQuery(".categories").hover(function(){
        jQuery(".cat-header-sec").slideDown();
    }, function(){
		jQuery(".cat-header-sec").slideUp();
	});

    jQuery(".opener.pull").click(function(){
        jQuery(".cat-header-sec").slideUp();
    })

    // add box 
    jQuery(".add-box").hover(function(){
        jQuery(".add-box .slide").slideDown();
    }, function(){
		jQuery(".add-box .slide").slideUp();
	});

});


function ShowBtnLoader() {
    jQuery(".btn-loadable").addClass("btn-loader").attr("disabled", "disabled");
}

function HideBtnLoader() {
    jQuery(".btn-loadable").removeClass("btn-loader").removeAttr("disabled").focusout();
}

/* GOOGLE LOCATION API START */

var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    console.log('formatted_address: ', place.formatted_address);

    var input = document.getElementById('SearchLocation');
    google.maps.event.addDomListener(input, 'keydown', function (e) {
        if (e.keyCode == 13 && $('.pac-container:visible').length > 0) {
            e.preventDefault();
            //return false;
            console.log('enter key');
        }
    });
}

/**
 * New Script: Location Autocomplete START
 */
function LocationInitialize(FieldID) {
    currentLocationInitialize(FieldID); // classified form fields
};

//Google location suggest
var curLocation, currentLocation;
var component_form = {
    'street_number': 'short_name',
    'route': 'long_name',
    'locality': 'long_name',
    'administrative_area_level_1': 'long_name',
    'political': 'short_name',
    'country': 'long_name',
    'postal_code': 'short_name',
    'formatted_address': 'formatted_address'
};

// function for user current location in profile section
function currentLocationInitialize(txtId) {
    console.log('ID: ', txtId)
    

    var input = document.getElementById(txtId);

    if(input.id == 'ProductAddress'){
        
        var options = {
            //types: ['(cities)'],
            types: ['geocode'],
            //componentRestrictions: {country: "IN"}
        };
    } else {
        var options = {
            //types: ['(cities)'],
            types: ['geocode'],
            //componentRestrictions: {country: "IN"}
        };
    }
    currentLocation = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(currentLocation, 'place_changed', function () {
        currentLocationFillInPrepare(txtId);
    });

    document.addEventListener('DOMNodeInserted', function (event) {
        var target = $(event.target);
    });

    google.maps.event.addDomListener(input, 'keydown', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });
}

function currentLocationFillInPrepare(txtId) {
    var place = currentLocation.getPlace();
    if (place != undefined)
    {
        locationFillInAddress(txtId, place);
    }
}

function locationFillInAddress(txtId, place) {
    var location_unique_id = place.id;
    var location_formatted_address = place.formatted_address;
    var location_lat = place.geometry.location.lat();
    var location_lng = place.geometry.location.lng();
    var location_street_number = "";
    var location_route = "";
    var location_city = "";
    var location_state = "";
    var location_country = "";
    var location_postal_code = "";
    
    jQuery("#location_lat").val(location_lat);
    jQuery("#location_lng").val(location_lng);
    
    for (var j = 0; j < place.address_components.length; j++) {
        var att = place.address_components[j].types[0];
        var val = place.address_components[j][component_form[att]];

        // city
        if (att == 'locality') {
            location_city = val;
        }
        // state
        if (att == 'administrative_area_level_1') {
            location_state = val;
        }
        // country
        if (att == 'country') {
            location_country = val;
        }
        // zip_code
        if (att == 'postal_code') {
            location_postal_code = val;
        }
    }

    if (location_city == '')
    {
        var SearchLocation = location_state + ", " + location_country;
    }
    else
    {
        var SearchLocation = location_city + ", " + location_state + ", " + location_country;
    }
    
    if (txtId == 'SearchLocation') {

        //$('#SearchLocation').val(SearchLocation);
        $('#SearchLocation').val(location_formatted_address);
        $('#SearchLocation').trigger('input');
    } 
    else if(txtId == 'ProductAddress'){
        $('#ProductAddress').val(location_formatted_address);
        $('#ProductAddress').trigger('input');   
    }
    
    console.log('Location : ', SearchLocation);
}

if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            console.log('pos', pos);
          }, function() {
            //handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          //handleLocationError(false, infoWindow, map.getCenter());
        }