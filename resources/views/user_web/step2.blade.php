@extends('user_web.layout.master')

@section('title','Deal Hunter')

@section('content')
    <style type="text/css">
        #map {
            height: 400px;
        }
        .blur {
            font-size: 20px;
            color: transparent;
            text-shadow: 0 0 6px #000;
        }

        .hover:hover {
            font-size: 20px;
            color: transparent;
            text-shadow: 0 0 6px #000;
        }

    </style>
<div class="steps-navigation">
    <div class="step-navigation-item active">
        <div class="step-count mb-1">
            <p class="mb-0">01</p>
        </div>
        <p class="mb-0 step-name">Confirm Area</p>
    </div>
    <div class="divider"></div>
    <div class="step-navigation-item active">
        <div class="step-count mb-1">
            <p class="mb-0">02</p>
        </div>
        <p class="mb-0 step-name">Personal Info</p>
    </div>
    <div class="divider"></div>
    <div class="step-navigation-item">
        <div class="step-count mb-1">
            <p class="mb-0">03</p>
        </div>
        <p class="mb-0 step-name">Instant Offer</p>
    </div>
</div>
<div class="row align-items-center">
    <?php

        $apiKey = "AIzaSyDKFL5_LB--7WJZviGFYvbnoe4lcZR9ubk"; // Google maps now requires an API key.
        // Get JSON results from this request
        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($OfferData->address).'&sensor=false&key='.$apiKey);
        $geo = json_decode($geo, true); // Convert the JSON to an array
        // dd($geo);
        if (isset($geo['status']) && ($geo['status'] == 'OK')) {
            $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
            $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
        }
    ?>
        <div class="col-lg-6 col-md-6 col-12 mb-3 col-set order-2 order-lg-1 order-md-1">
            <form action="{{route('instant.offer.getOffer')}}" method="post">
            @csrf
                <input type="hidden" name="instant_id" value="{{$id}}">
            <h1 class="heading-h2 mb-4 fw-bold mobile-center">Enter Info Below To Receive Instant Offer Now!</h1>
            <div class="theme-input-group mb-3">
                {{-- <img src="{{ asset('assets/images/icons/user.png') }}" alt="icon" class="icon-img"> --}}
                <svg class="icon-img" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.76006 9.16251C7.55556 9.16251 6.57005 8.77926 5.80354 8.01275C5.03704 7.24625 4.65378 6.26074 4.65378 5.05623C4.65378 3.85172 5.03704 2.86622 5.80354 2.09971C6.57005 1.3332 7.55556 0.949951 8.76006 0.949951C9.96457 0.949951 10.9501 1.3332 11.7166 2.09971C12.4831 2.86622 12.8663 3.85172 12.8663 5.05623C12.8663 6.26074 12.4831 7.24625 11.7166 8.01275C10.9501 8.77926 9.96457 9.16251 8.76006 9.16251ZM0 17.95V15.3767C0 14.6832 0.173376 14.09 0.520129 13.5973C0.866881 13.1045 1.31401 12.7304 1.86151 12.4749C3.08427 11.9274 4.25684 11.5168 5.37923 11.243C6.50161 10.9693 7.62856 10.8324 8.76006 10.8324C9.89157 10.8324 11.014 10.9738 12.1272 11.2567C13.2405 11.5396 14.4085 11.9457 15.6312 12.4749C16.197 12.7304 16.6532 13.1045 17 13.5973C17.3468 14.09 17.5201 14.6832 17.5201 15.3767V17.95H0ZM1.64251 16.3074H15.8776V15.3767C15.8776 15.0847 15.7909 14.8064 15.6176 14.5417C15.4442 14.2771 15.2297 14.0809 14.9742 13.9532C13.8062 13.3874 12.7386 12.9996 11.7713 12.7897C10.8041 12.5798 9.80032 12.4749 8.76006 12.4749C7.71981 12.4749 6.70692 12.5798 5.72142 12.7897C4.73591 12.9996 3.66828 13.3874 2.51852 13.9532C2.26302 14.0809 2.05314 14.2771 1.88889 14.5417C1.72464 14.8064 1.64251 15.0847 1.64251 15.3767V16.3074ZM8.76006 7.52C9.47182 7.52 10.0604 7.28731 10.5258 6.82193C10.9911 6.35655 11.2238 5.76799 11.2238 5.05623C11.2238 4.34448 10.9911 3.75591 10.5258 3.29053C10.0604 2.82515 9.47182 2.59246 8.76006 2.59246C8.04831 2.59246 7.45974 2.82515 6.99436 3.29053C6.52899 3.75591 6.2963 4.34448 6.2963 5.05623C6.2963 5.76799 6.52899 6.35655 6.99436 6.82193C7.45974 7.28731 8.04831 7.52 8.76006 7.52Z" fill="{{$DynamicData[0]->color ?? '#EA2227'}}"/>
                    </svg>

                <input type="text" class="form-control theme-input" placeholder="Name" name="user_name" required>
            </div>
            <div class="theme-input-group mb-3">
                {{-- <img src="{{ asset('assets/images/icons/email.png') }}" alt="icon" class="icon-img"> --}}
                <svg class="icon-img" width="20" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.3476 8.96368L10.375 8.98167L10.4024 8.96368L18.2938 3.7879V14.5437H2.45625V3.7879L10.3476 8.96368ZM1.38652 15.6135C1.67652 15.9035 2.01712 16.05 2.40625 16.05H18.3438C18.7329 16.05 19.0735 15.9035 19.3635 15.6135C19.6535 15.3235 19.8 14.9829 19.8 14.5938V2.40625C19.8 2.01712 19.6535 1.67652 19.3635 1.38652C19.0735 1.09652 18.7329 0.95 18.3438 0.95H2.40625C2.01712 0.95 1.67652 1.09652 1.38652 1.38652C1.09652 1.67652 0.95 2.01712 0.95 2.40625V14.5938C0.95 14.9829 1.09652 15.3235 1.38652 15.6135ZM10.375 7.456L2.69194 2.45625H18.0811L10.375 7.456Z" fill="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="0.1"/>
                    </svg>

                <input type="text" class="form-control theme-input" placeholder="Email Address" name="user_email" required>
            </div>
            <div class="theme-input-group mb-4">
                {{-- <img src="{{ asset('assets/images/icons/phone.png') }}" alt="icon" class="icon-img"> --}}
                <svg class="icon-img" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.066 10.9408C13.7759 14.6496 14.6175 10.359 16.9796 12.7194C19.2568 14.996 20.5656 15.4521 17.6804 18.3365C17.319 18.6269 15.0228 22.1212 6.95318 14.0538C-1.11743 5.98542 2.37478 3.68688 2.6653 3.32558C5.5575 0.43318 6.00576 1.74963 8.28298 4.02622C10.6451 6.38764 6.35618 7.23201 10.066 10.9408Z" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                <input type="text" class="form-control theme-input" placeholder="Phone Number" name="user_phone" required>
            </div>
            <div class="form-action mobile-center">
                <button type="submit"  class="btn btn-danger btn-theme">Yes! I Want Instant Offer Now!</button>
            </div>
            </form>
        </div>

    <div class="col-lg-6 col-md-6 col-12 mb-3 mb-col-0  order-1 order-lg-2 order-md-2">

        <div class="img-group">
            <div id="map"></div>
{{--            <img src="{{ asset('assets/images/step2-img.png') }}" class="img-fluid step2-img" alt="img">--}}
            <div class="offer-box">
                <div class="offer gap-2">
                    <div class="icon-group">
                        {{-- <img src="{{ asset('assets/images/icons/location-marker.png') }}" height="17" alt="icon"> --}}
                        <svg width="19" height="17" viewBox="0 0 19 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.3758 11.7197C10.0204 11.7197 10.5724 11.49 11.0318 11.0306C11.4904 10.572 11.7197 10.0204 11.7197 9.3758C11.7197 8.73121 11.4904 8.17921 11.0318 7.7198C10.5724 7.26116 10.0204 7.03185 9.3758 7.03185C8.73121 7.03185 8.1796 7.26116 7.72097 7.7198C7.26155 8.17921 7.03185 8.73121 7.03185 9.3758C7.03185 10.0204 7.26155 10.572 7.72097 11.0306C8.1796 11.49 8.73121 11.7197 9.3758 11.7197ZM9.3758 20.3338C11.7588 18.1461 13.5265 16.1584 14.679 14.3708C15.8314 12.5839 16.4076 10.997 16.4076 9.61019C16.4076 7.4811 15.7287 5.7376 14.3708 4.37967C13.0136 3.02252 11.3486 2.34395 9.3758 2.34395C7.40297 2.34395 5.7376 3.02252 4.37967 4.37967C3.02252 5.7376 2.34395 7.4811 2.34395 9.61019C2.34395 10.997 2.92017 12.5839 4.07261 14.3708C5.22505 16.1584 6.99278 18.1461 9.3758 20.3338ZM9.3758 23C9.21953 23 9.06327 22.9707 8.90701 22.9121C8.75074 22.8535 8.61401 22.7754 8.49682 22.6777C5.64501 20.158 3.51592 17.8191 2.10955 15.6611C0.703185 13.5023 0 11.4854 0 9.61019C0 6.68025 0.942658 4.34607 2.82797 2.60764C4.71251 0.869214 6.89512 0 9.3758 0C11.8565 0 14.0391 0.869214 15.9236 2.60764C17.8089 4.34607 18.7516 6.68025 18.7516 9.61019C18.7516 11.4854 18.0484 13.5023 16.642 15.6611C15.2357 17.8191 13.1066 20.158 10.2548 22.6777C10.1376 22.7754 10.0008 22.8535 9.84459 22.9121C9.68832 22.9707 9.53206 23 9.3758 23Z" fill="{{$DynamicData[0]->color ?? '#EA2227'}}"/>
                            </svg>

                    </div>
                    <div class="offer-content">
                        <p class="mb-2">{{$OfferData->address}}</p>
                        <div class="d-flex align-items-center gap-2" >
                            <p class="mb-0 fw-bold">OFFER PRICE:</p>
                            <a href="javascript:void(0)" class="btn btn-danger btn-theme blur hover" >$250,000</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-script')
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script type="text/javascript">
        function initMap() {
            const myLatLng = { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 5,
                center: myLatLng,

            });
            var locations = [
                ['Location',<?php echo $latitude; ?>,<?php echo $longitude; ?>],

            ];
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({

                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),

                    map: map

                });
                google.maps.event.addListener(marker, 'click', (function(marker, i) {

                    return function() {

                        infowindow.setContent(locations[i][0]);

                        infowindow.open(map, marker);

                    }

                })(marker, i));
            }

        }
        window.initMap = initMap;
    </script>

    <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key=AIzaSyDKFL5_LB--7WJZviGFYvbnoe4lcZR9ubk&callback=initMap" ></script>
@endsection

