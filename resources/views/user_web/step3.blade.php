@extends('user_web.layout.master')

@section('title','Deal Hunter')

@section('content')
    <style type="text/css">
        #map {
            height: 400px;
        }

        .p-color {
            background: #2C8CF4;
            border-color: #2C8CF4;
        }

        .theme-input-1 {
            background: #FFFFFF;
            /* Components/Input/Outlined */

            border: 1px solid rgba(145, 158, 171, 0.32);
            border-radius: 8px;
            padding-left: 60px;
            padding-right: 160px;
        }

        .btn-theme-danger {
            background: #EA2227!important;
            box-shadow: 0px 10px 25px rgba(234, 34, 39, 0.12)!important;
            border-color: #EA2227!important;
        }

        .btn-theme-co {
            background: #2C8CF4!important;
            box-shadow: 0px 10px 25px rgba(44, 140, 244, 0.12)!important;
            border-radius: 56px!important;
            border-color: #2C8CF4!important;
        }

        .btn-theme-accept {
            background: #00C72E!important;
            box-shadow: 0px 10px 25px rgba(44, 140, 244, 0.12)!important;
            border-radius: 56px!important;
            border-color: #00C72E!important;
        }


    </style>
    <?php

    $apiKey = "AIzaSyDKFL5_LB--7WJZviGFYvbnoe4lcZR9ubk"; // Google maps now requires an API key.
    // Get JSON results from this request
    $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($InstantData->address).'&sensor=false&key='.$apiKey);
    $geo = json_decode($geo, true); // Convert the JSON to an array
    if (isset($geo['status']) && ($geo['status'] == 'OK')) {
        $latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
        $longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
    }
    ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-12 mb-3 col-set order-2 order-lg-1 order-md-1">
        <div class="offer-main-box gap-4 mb-3 mt-4">
            <div class="icon-group">
                {{-- <img src="{{ asset('assets/images/icons/location-marker.png') }}" height="20" alt="icon"> --}}
                <svg width="24" height="20" viewBox="0 0 24 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.8217 14.7771C12.6344 14.7771 13.3304 14.4874 13.9097 13.9082C14.4879 13.3299 14.7771 12.6344 14.7771 11.8217C14.7771 11.0089 14.4879 10.3129 13.9097 9.73366C13.3304 9.15538 12.6344 8.86624 11.8217 8.86624C11.0089 8.86624 10.3134 9.15538 9.73513 9.73366C9.15587 10.3129 8.86624 11.0089 8.86624 11.8217C8.86624 12.6344 9.15587 13.3299 9.73513 13.9082C10.3134 14.4874 11.0089 14.7771 11.8217 14.7771ZM11.8217 25.6382C14.8263 22.8798 17.0552 20.3736 18.5083 18.1196C19.9614 15.8666 20.6879 13.8658 20.6879 12.1172C20.6879 9.4327 19.8318 7.23436 18.1196 5.52219C16.4085 3.81101 14.3091 2.95541 11.8217 2.95541C9.33418 2.95541 7.23436 3.81101 5.52219 5.52219C3.81101 7.23436 2.95541 9.4327 2.95541 12.1172C2.95541 13.8658 3.68195 15.8666 5.13503 18.1196C6.58811 20.3736 8.81699 22.8798 11.8217 25.6382ZM11.8217 29C11.6246 29 11.4276 28.9631 11.2306 28.8892C11.0335 28.8153 10.8611 28.7168 10.7134 28.5936C7.11762 25.4166 4.43312 22.4676 2.65987 19.7466C0.886624 17.0247 0 14.4815 0 12.1172C0 8.42293 1.18857 5.47983 3.56571 3.2879C5.94186 1.09597 8.69384 0 11.8217 0C14.9495 0 17.7015 1.09597 20.0776 3.2879C22.4547 5.47983 23.6433 8.42293 23.6433 12.1172C23.6433 14.4815 22.7567 17.0247 20.9834 19.7466C19.2102 22.4676 16.5257 25.4166 12.9299 28.5936C12.7822 28.7168 12.6098 28.8153 12.4127 28.8892C12.2157 28.9631 12.0187 29 11.8217 29Z" fill="{{$DynamicData[0]->color ?? '#EA2227'}}"/>
                    </svg>

            </div>
            <div class="offer-content">
                <p class="mb-2">{{$InstantData->address}}</p>
                <div class="d-flex align-items-center gap-2">
                    <p class="mb-0 fw-bold">OFFER PRICE:</p>
                    <a href="javascript:void(0)" class="text-theme-dark">${{$InstantData->offer_price}}</a>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between offer-main-actions">
            <a href="{{ route('user_web_deny',$InstantData->id) }}" class="btn btn-danger action-btn btn-theme-danger gap-2"><i class="fas fa-times"></i><span>Deny</span></a>

            @if($DynamicData[0]->enable_counter_offer)
                <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" href="{{ route('user_web_deny',$InstantData->id) }}" class="btn btn-danger action-btn btn-theme-co gap-2 p-color"><i class=""><img src="{{asset('images/icons/mod.svg')}}" alt="" srcset=""></i><span>Counter Offer</span></a>
            @endif
            <a href="{{ route('user_web_accept',$InstantData->id) }}" class="btn btn-success action-btn btn-theme-accept gap-2"><i class="fas fa-check"></i><span>Accept</span></a>
        </div>
        <div class="collapse" id="collapseExample">
            <form action="{{route('instant.offer.counter', $InstantData->id)}}" method="post">
                @csrf
                <div class="card card-body px-0 mb-0">
                    <div class="theme-input-group mb-3">
                        <img style="top: 20px;" src="{{ asset('images/icons/dol.svg') }}" alt="icon" class="icon-img">
                        <input required type="text" class="form-control theme-input-1 py-3" name="code" value="{{$InstantData->counter ?? ''}}" placeholder="Counter offer">
                        <input type="submit" style="    position: absolute;
                        right: 0;
                        top: 11px;
                        right: 10px;" class="btn btn-sm btn-primary action-btn btn-theme-co gap-2 p-color" value="Enter Counter Offer"/>
                    </div>
                </div>
            </form>
          </div>
    </div>
    <div class="col-lg-6 col-md-6 col-12 mb-3 mb-col-0 col-set-right order-1 order-lg-2 order-md-2">
        <div id="map"></div>
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
