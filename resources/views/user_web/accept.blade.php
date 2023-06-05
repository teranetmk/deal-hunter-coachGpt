@extends('user_web.layout.master')

@section('title', 'Deal Hunter')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-8 col-12">
            <div class="theme-card-popup">
                <div class="icon-group icon-group-success mb-3">
                    <img src="{{ asset('assets/images/icons/success.png') }}" height="22"
                        alt="icon">
                </div>
                <h3 class="heading-h3 fw-bold mb-3">Congrats On Accepting Our Offer To
                    Sell Your Home!</h3>
                <p class="description mb-3">Next Steps! We Will Get Back To You ASAP With Details!</p>
                <div class="d-flex align-items-center justify-content-center mb-3 gap-3">
                    <div class="d-flex align-items-center gap-2">
                        {{-- <img src="{{ asset('assets/images/icons/phone.png') }}" alt="icon" class="icon-img"> --}}
                        <svg class="icon-img" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3502 11.9905C14.48 16.1192 15.4168 11.3428 18.0463 13.9704C20.5813 16.5047 22.0382 17.0124 18.8264 20.2233C18.4241 20.5466 15.868 24.4364 6.88506 15.4559C-2.09904 6.47427 1.78844 3.91556 2.11184 3.51336C5.3314 0.293585 5.8304 1.75904 8.36537 4.29331C10.9948 6.92201 6.22048 7.86195 10.3502 11.9905Z" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        <a href="tel:+920449794139" class="text-theme-light">+ (92) 044 979 4139</a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        {{-- <img src="{{ asset('assets/images/icons/email.png') }}" alt="icon" class="icon-img"> --}}
                        <svg class="icon-img" width="21" height="18" viewBox="0 0 21 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.8025 6.20108L11.8529 9.41267C11.1067 10.0047 10.0568 10.0047 9.31056 9.41267L5.32764 6.20108" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9193 17C17.6227 17.0074 19.4448 14.7863 19.4448 12.0563V5.95112C19.4448 3.22118 17.6227 1 14.9193 1H6.19245C3.48903 1 1.66699 3.22118 1.66699 5.95112V12.0563C1.66699 14.7863 3.48903 17.0074 6.19245 17H14.9193Z" stroke="{{$DynamicData[0]->color ?? '#EA2227'}}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        <a href="tel:+920449794139" class="text-theme-light">info@dealhunter090.com</a>
                    </div>
                </div>
                <a href="tel:920449794139" class="btn btn-danger btn-theme popup-btn">Call Now!</a>
                <img src="{{ asset('assets/images/icons/success-overlay.png') }}" alt="overlay" height="150" class="overlay-img">
            </div>
        </div>
    </div>
@endsection
