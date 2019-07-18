<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 1500px;
                margin: 0;
            }

            .full-height {
                height: 1500px;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .barcode-text {
                margin: -5px 0 0 0;
                color: black;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div style="margin-top: -40rem;">
                    <p>code 128 - svg</p>
                    {!! DNS1D::getBarcodeSVG("screw-000001", "C128", 1, 33,"black") !!}
                    <p class="barcode-text">screw-000001</p>
                </div>

                <div style="margin-top: 50px;">
                    <p>code 128 - svg</p>
                    {!! DNS1D::getBarcodeSVG("screw-000002", "C128", 1, 33,"black") !!}
                    <p class="barcode-text">screw-000002</p>
                </div>

                <div style="margin-top: 50px;">
                    <p>code 128 - svg</p>
                    {!! DNS1D::getBarcodeSVG("screw-000003", "C128", 1, 33,"black") !!}
                    <p class="barcode-text">screw-000003</p>
                </div>

                <div style="margin-top: 50px;">
                    <p>code 128 - svg</p>
                    {!! DNS1D::getBarcodeSVG("dogFood-000001", "C128", 1, 33,"black") !!}
                    <p class="barcode-text">dogFood-000001</p>
                </div>

                <div style="margin-top: 50px;">
                    <p>code 128 - svg</p>
                    {!! DNS1D::getBarcodeSVG("dogFood-000002", "C128", 1, 33,"black") !!}
                    <p class="barcode-text">dogFood-000002</p>
                </div>

                @for($x = 0; $x < 50; $x++)
                    @if($x == 25)
                        <br>
                    @endif
                <div style="margin-top: 50px;">
                    <p>code 128 - svg</p>
                    {!! DNS1D::getBarcodeSVG("dogFood-000003", "C128", 1, 33,"black") !!}
                    <p class="barcode-text">dogFood-000003</p>
                </div>
                @endfor


            </div>
        </div>
    </body>
</html>
