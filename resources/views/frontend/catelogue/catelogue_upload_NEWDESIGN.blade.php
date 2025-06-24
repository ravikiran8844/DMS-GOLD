<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<div class="d-grid gap-2 d-md-flex justify-content-md-end m-2">
    <button id="download-catalogue" class="btn btn-warning text-white">Download</button>
    <a href="/shop" class="btn btn-light" type="button">Close</a>
</div>
<div id="catalog-slider-section">
    
	<!DOCTYPE html>
	<html lang="en">
		
		<head>
			<meta charset="UTF-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<title>Product Catalogue</title>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
			<link rel="preconnect" href="https://fonts.googleapis.com" />
			<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
			<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
		<link rel="stylesheet" href="{{ asset('/frontend/catelogue1/style.css') }}" /> </head>
		<body>
			<main class="container py-5">
				<header class="mb-5">
					<div> <img class="img-fluid" width="141" height="120" src="{{ asset('/frontend/catelogue1/images/logo.png') }}" alt="logo" /> </div>
					<div>
						<h5>UTENSIL</h5>
						<h1>NEW LAUNCHES</h1> 
					</div>
				</header>
				@if(count($products)>0)
				<section>
					<div class="col-12">
						<div class="grid-items">
							@foreach ($products as $product)
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">{{ substr($product[5],0,30)."..." }}</div>
									</div>
									<div class="card-img bg-white p-0 rounded-0"> 
										<img class="img-fluid" src="{{ asset('frontend/catelogue/uploads13042024/' . $product[0].'.jpg') }}" alt="" /> 
									</div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">{{ $product[0] }}</div>
											<div class="fw-semibold">{{ $product[2] }}G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>{{ $product[4] }}</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>{{ $product[3] }}</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>{{ $product[1] }}</span></div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</section>
				@else
				<section>
					<div class="col-12">
						<div class="grid-items">
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
							<div class="grid-item">
								<div class="card">
									<div class="card-header text-center">
										<div class="card-main-title">SFIDOL001-001</div>
									</div>
									<div class="card-img bg-white p-4 rounded-0"> <img class="img-fluid" src="{{ asset('/frontend/catelogue1/images/SFIDOL001-001.jpg') }}" alt="" /> </div>
									<div class="card-body card-text">
										<div class="d-flex justify-content-between mb-3 text-gold card-title">
											<div class="fw-bold">GANESH</div>
											<div class="fw-semibold">40G</div>
										</div>
										<div class="row">
											<div class="col-6">
												<div>Height : <span>10</span></div>
											</div>
											<div class="col-6">
												<div>Width : <span>10</span></div>
											</div>
										</div>
										<div class="mt-2">Sketch Number : <span>123</span></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				@endif
			</main>
		</body>
	</html>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const catalogContainer = document.getElementById('catalog-slider-section');
		const downloadButton = document.getElementById('download-catalogue');
		
		downloadButton.addEventListener('click', function() {
			this.innerHTML = '<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div> Loading...';
			
			const catalogContainer = document.getElementById('catalog-slider-section');
			
			// Implement Lazy Loading for Images
			const images = catalogContainer.querySelectorAll('img[data-src]');
			images.forEach(img => {
				img.setAttribute('src', img.getAttribute('data-src'));
				img.onload = () => {
					img.removeAttribute('data-src');
				};
			});
			
			const timestamp = new Date().getTime(); // Get current timestamp
			const randomNumber = Math.floor(Math.random() * 1000); // Generate random number between 0 and 999
			
			// Get the HTML content to convert to PDF
			const catalogContent = catalogContainer.innerHTML;
			
			// Configure HTML2PDF
			const opt = {
				filename:     'Utensil_New_Launches_'+timestamp+'.pdf',
				image:        { type: 'jpeg', quality: 0.98 },
			};
			
			// Convert HTML to PDF
			html2pdf().from(catalogContent).set(opt).save(); 
			
			
		});
	});
</script>	