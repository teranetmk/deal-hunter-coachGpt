<div class="header">
    <div class="container">
        {{-- header content start --}}
        <div class="header-content">
            {{-- logo start --}}
            <div class="logo">
                <a href="{{ route('user_web_step1') }}" class="d-block">
                    <img src="{{ asset($DynamicData[0]->logo)}}" height="30" alt="logo">
                </a>
            </div>
            {{-- logo end --}}
            <div class="header-info">
                <div class="d-flex align-items-center gap-2 me-4">
                    {{-- icon --}}
                    {{-- <img src="{{ asset('assets/images/icons/phone.png') }}" alt="icon" class="icon-img"> --}}
                    <svg style="height: 18px; width: 18px;" class="icon-img" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.0167 11.9905C15.1465 16.1192 16.0833 11.3428 18.7128 13.9704C21.2478 16.5047 22.7047 17.0124 19.4929 20.2233C19.0906 20.5466 16.5346 24.4364 7.55156 15.4559C-1.43253 6.47427 2.45494 3.91556 2.77835 3.51336C5.99791 0.293585 6.4969 1.75904 9.03187 4.29331C11.6613 6.92201 6.88698 7.86195 11.0167 11.9905Z" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <a href="tel:+920449794139" class="header-info-link">{{$DynamicData[0]->phone}}</a>
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- icon --}}
                    {{-- <img src="{{ asset('assets/images/icons/envelope.png') }}" alt="icon" class="icon-img"> --}}
                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.4692 6.20107L11.5196 9.41266C10.7734 10.0047 9.72346 10.0047 8.97724 9.41266L4.99432 6.20107" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5858 17C17.2892 17.0074 19.1113 14.7863 19.1113 12.0563V5.95112C19.1113 3.22118 17.2892 1 14.5858 1H5.85895C3.15553 1 1.3335 3.22118 1.3335 5.95112V12.0563C1.3335 14.7863 3.15553 17.0074 5.85895 17H14.5858Z" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                    <a href="mailto:info@dealhunter090.com" class="header-info-link">{{$DynamicData[0]->email}}</a>
                </div>
            </div>
        </div>
        {{-- header content end --}}
    </div>
</div>
