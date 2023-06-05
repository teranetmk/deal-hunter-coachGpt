<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Theme -->
    <link id="theme-link" rel="stylesheet" href="{{asset('themes/md-light-red/theme.css')}}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .p-datatable {
            border: 1px solid #EBEBEB!important;
            border-radius: 15px!important;
        }
        /* .p-datatable .p-datatable-thead > tr > th {
            background: transparent!important;
        } */

        .p-paginator {
            border-radius: 15px!important;
        }
    </style>
    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>
<body class="font-sans antialiased">
<noscript>
    <strong>We're sorry but <%= htmlWebpackPlugin.options.title %> doesn't work properly without JavaScript enabled.
        Please enable it to continue.</strong>
</noscript>

<div id="map1"></div>
<div id="pano1"></div>


@inertia
{{-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKFL5_LB--7WJZviGFYvbnoe4lcZR9ubk&callback=initMap&v=weekly"
      defer
></script> --}}

{{-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKFL5_LB--7WJZviGFYvbnoe4lcZR9ubk&callback=initMap&v=weekly"
      defer
    ></script> --}}

<script>

    // Initialize and add the map
    // function initMap() {
    // }

    // window.initMap = initMap;


</script>

<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://fast.wistia.com/embed/medias/n2nr5pvma4.jsonp" async></script>
<script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
<script>

</script>

</body>
</html>
