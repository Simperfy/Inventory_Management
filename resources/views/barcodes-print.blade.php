<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html">

  <title>Barcodes</title>

  <!-- Styles -->
  <style>
    html, body {
      /*background-color: #fff;*/
      /*color: #636b6f;*/
      /*font-family: 'Nunito', sans-serif;
      height: 1500px;
      margin: 0;*/
    }

    .barcodes-container {
      padding: 0 0;
    }

    .barcodes-wrapper {
      margin-top: 33px;
    }

    .barcode-content {
      border-style: dotted;
      display: inline-block;
      margin: 0 7px;
      padding: 0 5px;
    }

    .barcode-text {
      margin: -5px 0 0 0;
      padding-left: 40px;
      color: black;
      font-size: 12px;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>
<body>
  <div class="barcodes-container">
    @for($j=1; $j <= 10; $j++)

    @if($j % 11 == 0) <div class="page-break"></div> @endif
    <div class="barcodes-wrapper">
      @for($x=0; $x < 4; $x++)
      <div class="barcode-content">
        <div style="margin-top: 15px">
          {{--<p>code 128 - png</p>--}}
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('screw-000002', 'C128', 1, 33)}}" alt="">
          <p class="barcode-text">screw-000002</p>
        </div>
      </div>
      @endfor
    </div>

    @endfor
  </div>
</body>
</html>
