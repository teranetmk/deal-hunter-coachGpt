<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>home</title>
        <meta name="description" content="">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
		<link rel="shortcut icon" type="image/x-icon" href="#">
        <!-- Place favicon.ico in the root directory -->

		<!-- CSS here -->
        {{-- <link rel="stylesheet" href="assets/css/style.css"> --}}

        <style>
            /*   Theme default css */
@font-face {
  font-family: Graphik;
  src: url(../fonts/GraphikBold.otf);
  font-weight: 700;
  font-style: normal;
}
@font-face {
  font-family: Graphik;
  src: url(../fonts/GraphikRegular.otf);
  font-weight: 400;
  font-style: normal;
}


/* ======font family=========

*/



.template_body {
  font-weight: 400;
  font-size: 16px;
  margin: 0;
  padding: 0;
  font-family: Graphik;
  color: #000;
}


button {
  cursor: pointer;
}

a:focus,
button:focus {
  text-decoration: none;
  outline: none; }

a:focus,
a:hover {
  color: inherit;
  text-decoration: none; }

a,
button {
  color: inherit;
  outline: medium none;
  text-decoration: none;
}

button:focus, input:focus, input:focus, textarea, textarea:focus {
  outline: 0; }


h1,
h2,
h3,
h4,
h5,
h6 {
  margin-top: 0px;
  font-weight: 700;
 }

h1 a,
h2 a,
h3 a,
h4 a,
h5 a,
h6 a {
  color: inherit; }

h1 {
  font-size: 40px; }

h2 {
  font-size: 36px;
  }

h3 {
  font-size: 28px; }

h4 {
  font-size: 22px; }

h5 {
  font-size: 18px; }

h6 {
  font-size: 16px; }

ul {
  margin: 0px;
  padding: 0px; }

li {
  list-style: none; }

.thm_btn{}

/* default-css END
================================== */




/*============ Area Start =============*/
.container {background: #F8DE70;max-width: 650px;width: 100%;margin: auto;}

section {display: flex;align-items: center;justify-content: center;height: 100%;padding: 20px;}
.row {display: flex;}
.col-7 {width: 56%;}

.col-5 {
    width: 44%;
}
.text_top {text-align: center;position: relative;}

.text_top p {
    font-size: 53px;
    font-weight: 700;
    background: #EE2F56;
    color: #fff;
    padding: 15px 0px;
    margin: 0;
}

.text_top h3 {
    max-width: 296px;
    margin: 18px auto 17px;
    text-transform: uppercase;
}

.text_top h3 span {
    margin-bottom: 16px;
    display: block;
}

.text_top img {
    position: absolute;
    right: -30px;
    top: 98px;
    width: 85px;
}
.sec_img {text-align: right;}

.sec_img img {height: 100%;width: 100%;}
.info {padding: 20px 0;text-align: center;text-transform: uppercase;}

.info h2 {
    margin: 6px 0;
}

.info p {
    margin: 0;
    font-size: 15px;
}
/*============ Area End =============*/



/*============ Mobile Device  =============*/



        </style>
    </head>
    <body class="template_body">



    <main>
        @php
            $ph = new \App\Http\Controllers\Controller;
            $phone_unformated = $phone;
            $phone = $ph->getPhone($phone);
        @endphp


        <!--------- Section START ---------->
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-7">
                        <div class="text_top">
                            <img src="{{asset('postcard/arrow.png')}}"  alt="">
                            <h3>
                                <span>Hey {NAME}!</span>
                                I would like to
                                make an offer on
                                your property
                            </h3>
                            <p>$250,000</p>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="sec_img" style="height: 263px; width: 283px;">
                            <img src="{{asset('postcard/Asset2.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="info">
                    <p>You Can Accept, Deny, Or Counter My Offer                    </p>
                    <h2>{{$domain}} <br> {{$phone_unformated}}                  </h2>
                    <p>Enter Code: ****-****</p>
                </div>
            </div>
        </section>
        <!--------- Section End ---------->

    </main>

    </body>
</html>
