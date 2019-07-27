<section class="hero-wrap hero-wrap-2" style="background-image: url('<?=base_url()."assets/";?>images/bg_2.jpeg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-2 bread">Offer a ride</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="<?=base_url();?>">Home <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>Offer a ride <i
                            class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container-fluid px-0">
        <div class="row d-flex no-gutters">
            <div class="col-md-6 order-md-last ftco-animate makereservation p-4 p-md-5 pt-5" style="background:#fff;">
                <div class="py-md-5">
                    <div class="heading-section ftco-animate mb-5">
                        <h2 class="mb-4">Offer a ride</h2>
                    </div>
                    <form action="#" id="find_ride">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="leaving_from">Leaving from</label>
                                    <input type="text" class="form-control" name="leaving_from" id="leaving_from"
                                        onchange="emptylatlng()" placeholder="Enter Leaving from">
                                    <input type="hidden" value="" name="pickup_place_id" id="pickup_place_id">
                                    <span id="err_leaving_from" class="text-danger err_span"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="destination">Destination</label>
                                    <input type="text" class="form-control" name="destination" id="destination"
                                        onchange="emptylatlng()" placeholder="Enter Destination">
                                    <input type="hidden" value="" name="drop_place_id" id="drop_place_id">
                                    <span id="err_destination" class="text-danger err_span"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="leaving_date">Leaving date</label>
                                    <input type="text" class="form-control datepicker" readonly name="leaving_date"
                                        id="leaving_date" placeholder="Enter leaving date">
                                    <span id="err_leaving_date" class="text-danger err_span"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="leaving_time">Leaving time</label>
                                    <input type="text" class="form-control" name="leaving_time" id="leaving_time"
                                        placeholder="Enter leaving time">
                                    <span id="err_leaving_time" class="text-danger err_span"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="seats">Seats</label>
                                    <div class="select-wrap one-third">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="seats" id="seats" class="form-control">
                                            <option value="">Seats</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        <span id="err_seats" class="text-danger err_span"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>"
                                        value="<?=$this->security->get_csrf_hash();?>" />
                                    <input type="hidden" name="leaving_longitude" id="leaving_longitude" value="" />
                                    <input type="hidden" name="leaving_latitude" id="leaving_latitude" value="" />
                                    <input type="hidden" name="destination_longitude" id="destination_longitude"
                                        value="" />
                                    <input type="hidden" name="destination_latitude" id="destination_latitude"
                                        value="" />
                                    <button type="submit" class="btn btn-primary py-3 px-5">Offer ride</button>
                                    <button type="reset" class="btn btn-danger py-3 px-5">Reset</button>
                                </div>
                            </div>
                            <div class="col-md-12" id="response"></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-stretch pb-5 pb-md-0" style="position:relative;overflow:hidden;">
                <div id="pickup_map"></div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtZZ49a-AIC_xYCSgwh09xKzYL6zr89p4&libraries=places&callback=init"
    async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#find_ride").submit(function(event) {
        $(".err_span").html("");
        event.preventDefault();
        var thidata = $("#find_ride").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('offer_ride/offer_ride_action') ?>",
            data: thidata,
            dataType: "json",
            success: function(response) {
                if (response.status) {
                    $("#response").html(response.message);
                    $("#find_ride").trigger("reset");
                    setTimeout(function() {
                        $("#response").html("");
                    }, 3000);
                } else {
                    $("#err_leaving_from").html(response.message.leaving_from);
                    $("#err_destination").html(response.message.destination);
                    $("#err_leaving_date").html(response.message.leaving_date);
                    $("#err_leaving_time").html(response.message.leaving_time);
                    $("#err_seats").html(response.message.seats);
                    $("#response").html(response.message.liacence_update);
                }
            }
        });
        return false;
    });
    $('#leaving_date').datepicker({
        'format': 'yyyy-mm-dd',
        'autoclose': true
    });
    $('#leaving_time').timepicker();

});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

setTimeout(function() {
    $("#pickup_map").css("overflow", "");
    $("#pickup_map").css("position", "");
    $("#pickup_map").show();
}, 1000);



function emptylatlng() {
    var data = $("#destination").val();
    if (data == '') {
        $("#destination_latitude").val('');
        $("#destination_longitude").val('');
    }
    var data1 = $("#leaving_from").val();
    if (data1 == '') {
        $("#leaving_latitude").val('');
        $("#leaving_longitude").val('');
    }
}

var map_global = {};
var directionsService, directionsDisplay;

function init() {
    map_global.map = new google.maps.Map(document.getElementById('pickup_map'), {
        center: {
            lat: 40.116421,
            lng: -88.243385
        },
        zoom: 12
    });


    directionsService = new google.maps.DirectionsService;

    directionsDisplay = new google.maps.DirectionsRenderer;

    directionsDisplay.setMap(map_global.map);


    map_global.pickup_autocomplete = initAutocomplete(
        document.getElementById('leaving_from')
    );

    map_global.pickup_autocomplete.addListener('place_changed', function() {
        var place = this.getPlace();
        fillInAddress(place, document.getElementById('pickup_place_id'));
        if (map_global.pickupmarker) {
            map_global.pickupmarker.setMap(null);
        }
        map_global.pickupmarker = setMarker(place, 'Pickup Address', 'assets/images/loc.png');
        $("#leaving_latitude").val(place.geometry.location.lat());
        $("#leaving_longitude").val(place.geometry.location.lng());
    });

    map_global.drop_autocomplete = initAutocomplete(
        document.getElementById('destination')
    );

    map_global.drop_autocomplete.addListener('place_changed', function() {
        var place = this.getPlace();
        fillInAddress(place, document.getElementById('drop_place_id'));
        if (map_global.dropmarker) {
            map_global.dropmarker.setMap(null);
        }
        map_global.dropmarker = setMarker(place, 'Drop Address', 'assets/images/loc.png');
        $("#destination_latitude").val(place.geometry.location.lat());
        $("#destination_longitude").val(place.geometry.location.lng());
    });
}


function initAutocomplete(auto_element) {
    var autocomplete = new google.maps.places.Autocomplete(
        auto_element,
        // { types: ['geocode'] }
    );
    autocomplete.setComponentRestrictions({
        'country': 'US'
    });
    return autocomplete;
    // autocomplete.setBounds(circle.getBounds());
}

function fillInAddress(place, place_id_element) {
    place_id_element.value = place.place_id;
    if (place.geometry.viewport) {
        map_global.map.fitBounds(place.geometry.viewport);
    } else {
        map_global.map.setCenter(place.geometry.location);
        map_global.map.setZoom(12); // Why 17? Because it looks good.
    }
}

function setMarker(place, title = 'Address', icon = "assets/images/loc.png") {

    var image = {
        url: icon,
        // This marker is 20 pixels wide by 32 pixels high.
        size: new google.maps.Size(100, 100),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(0, 0)
    }

    var marker = new google.maps.Marker({
        position: place.geometry.location,
        map: map_global.map,
        title: title,
        icon: image
    });

    setInfoContents(marker, place);

    return marker;
}

function setInfoContents(marker, place) {
    var infowindow = new google.maps.InfoWindow({
        content: place.adr_address
    });
    infowindow.open(map_global.map, marker);
}

function calculateAndDisplayRoute(origin, drop) {
    directionsService.route({
        origin: origin,
        destination: drop,
        travelMode: 'DRIVING'
    }, function(response, status) {
        if (status === 'OK') {
            directionsDisplay.setDirections(response);
        }
    });
}
</script>