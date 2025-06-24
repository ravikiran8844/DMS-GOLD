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
        @if(count($products)>0)
                @php
        $ic = 0
        @endphp
        @foreach ($products as $product)
        @php
            $ic++
        @endphp
        @if($ic == 1)
        <section class="header-section">
            <div class="container p-4">
                <div class="col-12 d-flex flex-wrap gap-4 justify-content-between align-items-center">
                    <div>
                        <img width="135" height="135" class="img-fluid" src="{{ asset('/frontend/catelogue/images/logo.png') }}" alt="">
                    </div>
                    <div>
                        <div class="text-light fs-3 fw-semibold">ELECTRO FORMING</div>
                        <div class="text-light display-4 fs-3 fw-semibold">GOD IDOLS</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-section">
            <div class="container p-3">
                <div class="col-12">
                    <div class="products-grid">
                    @endif
                        <div class="products-grid__item">
                            <div class="products-grid__item-img-wrapper">
                                <img class="img-fluid"  src="{{ asset('upload/product/' . $product->product_image) }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">{{$product->product_unique_id}}</div>
                                <!-- <div class="fw-semibold">{{$product->crwcolcode}}</div> -->
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
                    @if($ic % 12 == 0)
                    </div>
                </div>
            </div>
        </section>
        <section class="header-section">
            <div class="container p-4">
                <div class="col-12 d-flex flex-wrap gap-4 justify-content-between align-items-center">
                    <div>
                        <img width="135" height="135" class="img-fluid" src="{{ asset('/frontend/catelogue/images/logo.png') }}" alt="">
                    </div>
                    <div>
                        <div class="text-light fs-3 fw-semibold">ELECTRO FORMING</div>
                        <div class="text-light display-4 fs-3 fw-semibold">GOD IDOLS</div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-section">
            <div class="container p-3">
                <div class="col-12">
                    <div class="products-grid">        
        @endif
        @endforeach
         @else
        <section class="content-section">
            <div class="container py-5">
                <div class="col-12">
                    <div class="products-grid">
                        <div class="products-grid__item">
                            <div class="products-grid__item-img-wrapper">
                                <img class="img-fluid" src="{{ asset('frontend/catelogue/images/productholder.png') }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">SFIDOL001-001
                                </div>
                                <div class="fw-semibold">Ganesh</div>
                                <div><span class="fw-semibold">Weight: </span>82g</div>
                                <div><span class="fw-semibold">MC Tag code: </span>HB</div>
    
                            </div>
                        </div>
                        <div class="products-grid__item">
                            <div class="products-grid__item-img-wrapper">
                                <img class="img-fluid" src="{{ asset('frontend/catelogue/images/productholder.png') }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">SFIDOL001-002
                                </div>
                                <div class="fw-semibold">Lakshmi</div>
                                <div><span class="fw-semibold">Weight: </span>40g</div>
                                <div><span class="fw-semibold">MC Tag code: </span>4*</div>
    
                            </div>
                        </div>
                        <div class="products-grid__item">
                            <div class="products-grid__item-img-wrapper">
                                <img class="img-fluid" src="{{ asset('frontend/catelogue/images/productholder.png') }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">SFIDOL001-002A
                                </div>
                                <div class="fw-semibold">Lakshmi</div>
                                <div><span class="fw-semibold">Weight: </span>40g</div>
                                <div><span class="fw-semibold">MC Tag code: </span>4*</div>
    
                            </div>
                        </div>
                        <div class="products-grid__item">
                            <div class="products-grid__item-img-wrapper">
                                <img class="img-fluid" src="{{ asset('frontend/catelogue/images/productholder.png') }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">SFIDOL001-001
                                </div>
                                <div class="fw-semibold">Ganesh</div>
                                <div><span class="fw-semibold">Weight: </span>13g</div>
                                <div><span class="fw-semibold">MC Tag code: </span>AC</div>
    
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        @endif
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>