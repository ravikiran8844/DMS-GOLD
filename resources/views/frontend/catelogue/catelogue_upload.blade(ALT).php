<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<div class="d-grid gap-2 d-md-flex justify-content-md-end m-2">
   
    <button id="download-catalogue" class="btn btn-warning text-white">Download</button>
     <a href="/shop" class="btn btn-light" type="button">Close</a>
</div>
<div id="catalog-slider-section">
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    span.fw-semibold {
        font-size: 12px;
    }
    span.fw-seminor {
         color:000;
         font-size: 12px;
    }
    .products-grid__item {
     margin-bottom:.3em;   
    }
</style>
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
                        <img width="95" height="95" class="img-fluid" src="{{ asset('/frontend/catelogue/images/logo.png') }}" alt="">
                    </div>
                    <div>
                        <div class="text-light fs-4 fw-semibold">Utensil</div>
                        <div class="text-light display-4 fs-4 fw-semibold">New Launches</div>
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
                                <img class="img-fluid" src="{{ asset('frontend/catelogue/uploads13042024/' . $product[0].'.jpg') }}" alt="">
                            </div>
                            <div>
                                <div class="fw-semibold">{{ substr($product[5],0,15)."..." }}</div>
								<div class="fw-semibold">{{ $product[1] }}</div>
                                <div>
                                    <span class="fw-semibold">SQ: </span><span class="fw-seminor">{{ $product[2] }}g</span>
                                    <span class="fw-semibold">W.th: </span><span class="fw-seminor">{{ $product[3] }}</span>
                                    <span class="fw-semibold">He.ht: </span><span class="fw-seminor">{{ $product[4] }}</span>
                                    <span class="fw-semibold">I.N: </span><span class="fw-seminor">{{ substr($product[0],0,15)."..." }}</span>
                                </div>
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
                        <img width="95" height="95" class="img-fluid" src="{{ asset('/frontend/catelogue/images/logo.png') }}" alt="">
                    </div>
                    <div>
                       <div class="text-light fs-4 fw-semibold">Utensil</div>
                        <div class="text-light display-4 fs-4 fw-semibold">New Launches</div>
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
</div>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const catalogContainer = document.getElementById('catalog-slider-section');
			const downloadButton = document.getElementById('download-catalogue');
			
			document.getElementById('download-catalogue').addEventListener('click', function() {
			    this.innerHTML = '<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div> Loading...';
				// var iframeContent =  document.querySelector('.mbody').contentWindow.document.body.innerHTML;
				var iframeContent = document.querySelector('#catalog-slider-section').innerHTML;
                const timestamp = new Date().getTime(); // Get current timestamp
                const randomNumber = Math.floor(Math.random() * 1000); // Generate random number between 0 and 999
                const uniqueName = `Utensil_New_Launches_${timestamp}.pdf`; // Combine timestamp and random number
                html2pdf().from(iframeContent).save(uniqueName); // Save the PDF with the unique name

			});
			
		});
	</script>