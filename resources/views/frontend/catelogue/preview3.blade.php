<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <link rel="stylesheet" href="{{ asset('/frontend/catelogue/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
</head>
<body id="previewmode">
    <main>
        <section class="header-section" style="background: linear-gradient(90deg, rgb(102, 30, 27) 0%, rgb(29, 71, 1) 35%, rgb(36, 78, 1) 100%);">
            <div class="container p-4">
                <div class="col-12 d-flex flex-wrap gap-4 justify-content-between align-items-center">
                    <div>
                        <img width="135" height="135" class="img-fluid" src="{{ asset('/frontend/catelogue/images/logo.png') }}" alt="">
                    </div>
                    <div>
                        <div class="text-light fs-3 fw-semibold">ELECTRO FORMING</div>
                        <div class="text-light display-4 fs-3 fw-semibold ">GOD IDOLS</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-section">
            <div class="container p-3">
                <div class="col-12">
                    <div class="products-grid">
                        @foreach ($products as $product)
                        <div class="products-grid__item">
                            <div class="products-grid__item-img-wrapper">
                                <img class="img-fluid"  src="{{ asset('upload/product/' . $product->product_image) }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">{{$product->product_unique_id}}
                                </div>
                                <div class="fw-semibold">{{$product->crwsubcolcode}}</div>
                                @if ($product->weight)
                                <div><span class="fw-semibold">Weight: </span>{{ $product->weight }}g</div>
                                @endif
                                @php
                                    $weight = $product->weight;
                                    $mcCharge = App\Models\Weight::where('is_active', 1)
                                        ->where('weight_range_from', '<=', $weight)
                                        ->where('weight_range_to', '>=', $weight)
                                        ->value('mc_charge');

                                    $weightString = (string) $mcCharge;
                                    $variable1 = (int) $weightString[0];
                                    $variable2 = (int) $weightString[1];

                                    $mc1 = App\Models\MakingCharge::where('mc_charge', $variable1)->value(
                                        'mc_code',
                                    );
                                    $mc2 = App\Models\MakingCharge::where('mc_charge', $variable2)->value(
                                        'mc_code',
                                    );
                                @endphp
                                <div><span class="fw-semibold">MC Tag code: </span>{{ $mc1 . $mc2 }}</div>
    
                            </div>
                        </div>
                        @endforeach                
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
