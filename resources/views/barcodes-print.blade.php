<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Barcodes</title>

  <!-- Styles -->
  <style>
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
    @php
    $totalItems = count($itemBarcodes); // assuming both $itemBarcodes and $itemQuantity are the same size of array
    $totalCounter = 0;
    $itemsPerRow = 3;
    @endphp

    @for($i=0; $i < $totalItems; $i++)

      @for($x=0; $x < $itemQuantity[$i]; $x++)
        @if($totalCounter > 0)
          @if($itemsPerRow === 3 && ($totalCounter % 27) === 0)
          <div class="page-break"></div>
          @endif
        @endif

      @php $totalCounter++; @endphp

      @if($totalCounter == 1)<div class="barcodes-wrapper">@endif
      <div class="barcode-content">
        <div style="margin-top: 15px">
          <!-- <p>code 128 - png</p> -->
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($itemBarcodes[$i], 'C128', 1, 33)}}" alt="">
          <p class="barcode-text">{{ $itemBarcodes[$i]}}</p>
        </div>
      </div>

      @if(($totalCounter % $itemsPerRow) == 0)
        </div>
        <div class="barcodes-wrapper">
      @endif
      @endfor

    @endfor
        </div>

  </div>
</body>
</html>