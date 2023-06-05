<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">
    <title>@yield('title')</title>
    @if ($DynamicData[0]->enable_ad_pixel == 1)
    {!! $DynamicData[0]->pixel_code !!}
    @endif
    {{-- css & fonts --}}
    @include('user_web/includes/style')
    @yield('custom-style')

    @if (!empty($DynamicData[0]->color))
        <style>
            .btn-theme {
                background-color: {{$DynamicData[0]->color}};
                border-color: {{$DynamicData[0]->color}};
            }

            .btn-theme:hover,.btn-theme:focus, .btn-theme:active  {
                background-color: {{$DynamicData[0]->color}};
                border-color: {{$DynamicData[0]->color}};
            }

            .text-theme-red {
                color: {{$DynamicData[0]->color}};
            }

            .text-theme-red:hover, .text-theme-red:active {
                color: {{$DynamicData[0]->color}};
            }

            a {
                color: {{$DynamicData[0]->color}};
            }

            a:hover {
                color: {{$DynamicData[0]->color}};
            }

            .theme-input {
                /* border-color: {{$DynamicData[0]->color}}; */
            }

            .theme-input:focus,  .theme-input:active{
                border-color: {{$DynamicData[0]->color}};
            }

            .btn-theme:active, .btn-theme:focus {
                box-shadow: none!important;
                outline: none!important;
            }

            .step-navigation-item.active .step-count {
                background-color: {{$DynamicData[0]->color}};
                border-color: {{$DynamicData[0]->color}};
            }

            .offer-main-box .icon-group, .offer  .icon-group{
                /* opacity: 0.1; */
                background-color: {{$DynamicData[0]->color.'20'}}!important;
                /* opacity: 0.1; */
            }

            .btn-theme-danger {
                background-color: {{$DynamicData[0]->color}};
                border-color: {{$DynamicData[0]->color}};
            }
        </style>
    @endif
</head>
<body>
    {{-- page wrapper start --}}
    <div class="page-wrapper">
        {{-- header start --}}
        @include('user_web.includes.header')
        {{-- header end --}}
        {{-- page content start --}}
        <div class="page-content">
            {{-- content start --}}
            <div class="content">
                <div class="container">
                    @yield('content')
                </div>
            </div>
            {{-- content end --}}
        </div>
        {{-- page content end --}}
        {{-- footer start --}}
        <div class="footer">
            <div class="container">
                <div class="footer-copyright-content">
                    <p class="text-center mb-0">Copyright © 2023 {{$DynamicData[0]->company_name}}. All Rights Reserved</p>
                </div>
            </div>
        </div>
        {{-- footer end --}}
    </div>
    {{-- page wrapper end --}}
    @yield('modals')
    {{-- javascript files --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    @yield('custom-script')
</body>
</html>
