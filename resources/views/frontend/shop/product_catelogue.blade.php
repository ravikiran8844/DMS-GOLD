<?php if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<section id="catalog-slider-section" class="container-fluid d-none">
		<div class="row">
			<div class="col-12 my-2">
				<h2 class="fs-3 fw-semibold">Product Catalogues</h2>
			</div>
		</div>
		<div class="mt-2 mb-2">
    		@include('frontend.shop.product_catelogue_upload')
		</div>
		<div id="catalog-slider" class="splide mb-2" aria-label="product Catalog Slider">
			<div class="splide__track">
				<ul class="splide__list">
					<li class="splide__slide">
						<div class="card product-catalog-card">
                            <div class="shopcard">
                                <div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-0.png') }}" alt="banner"></div>
							</div>
                            <div class="mt-3 text-center">
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
								data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview1"
								data-bs-toggle="modal" data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>
					</li>
					<li class="splide__slide">
						<div class="card product-catalog-card">
							<div class="shopcard">
								<div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-2.png') }}" alt="banner"></div>
							</div>
							<div class="mt-3 text-center">
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
								data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview2" data-bs-toggle="modal"
								data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>
					</li>
					<li class="splide__slide">
						<div class="card product-catalog-card">
							<div class="shopcard">
								<div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-3.png') }}" alt="banner"></div>
							</div>
							<div class="mt-3 text-center">
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
								data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview3" data-bs-toggle="modal"
								data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>
					</li>
					<li class="splide__slide">
						<div class="card product-catalog-card">
							<div class="shopcard">
								<div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-4.png') }}" alt="banner"></div>
							</div>
							<div class="mt-3 text-center">
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
								data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview4" data-bs-toggle="modal"
								data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>
					</li>
					<li class="splide__slide">
						<div class="card product-catalog-card">
							<div class="shopcard">
								<div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-2.png') }}" alt="banner"></div>
							</div>
							<div class="mt-3 text-center">
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
								data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview2" data-bs-toggle="modal"
								data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>
					</li>
					<li class="splide__slide">
						<div class="card product-catalog-card">
							
							<div class="shopcard">
								<div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-3.png') }}" alt="banner"></div>
							</div>
							<div class="mt-3 text-center"> 
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
                                data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview3"
								data-bs-toggle="modal" data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>
					</li>
					<li class="splide__slide">
						<div class="card product-catalog-card">
							<div class="shopcard">
								<div class="shopcard-image"><img class="img-fluid w-100"
								src="{{ asset('frontend/catelogue/catalog-4.png') }}" alt="banner"></div>
							</div>
							<div class="mt-3 text-center">
							    <!-- <h6>ELECTRO FORMING<h6> -->
								<button class="btn btn-warning loadpreview"
                                data-preview-title="Catalog Preview" data-preview-url="/cateloguepreview4"
								data-bs-toggle="modal" data-bs-target="#exampleModal1">Load Preview</button>
							</div>
						</div>						
					</li>
				</ul>
			</div>
			<div class="splide__arrows"></div>
		</div>		
	</section>
	
	<div class="modal fade" fade id="exampleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title mod_title" title="Download PDF"> </h5><button id="download-pdf" class="btn btn-warning"
                    style="margin-left: 1em;"><i class="fa fa-download" aria-hidden="true"></i></button>
					<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body mdbody">
					<div class="mbody"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="overlay01"></div>
	<style>
		.overlay01 {
		position: fixed;
		top: 0;
		left: 0;
		z-index: 200;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, .7);
		opacity: 0;
		visibility: hidden;
		transition: .3s linear;
		}
		
		.modal-open .overlay01 {
		opacity: 1;
		visibility: visible;
		}
		
		.shopcard .shopcard-image {
		height: 214px;
		/* Fixed height for the image container */
		overflow: hidden;
		/* Enable scrolling */
		position: relative;
		cursor: pointer;
		}
		
		.shopcard .shopcard-image img {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		transition: transform 15s ease;
		/* Smooth transition for scroll */
		}
		
		.shopcard .shopcard-image:hover img {
		transform: translateY(-100%);
		}
	</style>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// var splide1 = new Splide('#catalog-slider').mount();
			var splide2 = new Splide('#catalog-slider', {
				type: 'slide',
				autoplay: 'pause',
				gap: '1rem',
				pagination: false,
				perPage: 4,
				breakpoints: {
					1640: {
						perPage: 4,
					},
					1340: {
						perPage: 4,
					},
					1040: {
						perPage: 3,
					},
					740: {
						perPage: 2,
					},
					640: {
						perPage: 2,
					},
					440: {
						perPage: 1,
					},
					0: {
						perPage: 1,
					},
				}
				
			}).mount();
		});
	</script>
	
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			
			// Get all elements with the class 'loadpreview'
			const buttons = document.querySelectorAll('.loadpreview');
			// Add click event listener to each button
			buttons.forEach(button => {
				button.addEventListener('click', async function(e) { // Add async keyword here
					this.innerHTML = '<div class="spinner-grow spinner-grow-sm" role="status"><span class="sr-only">Loading...</span></div> Loading...';
					// Get the preview URL from the 'data-preview-url' attribute
					const previewUrl = this.getAttribute('data-preview-url');
					
					//   document.querySelector('.mbody').src = previewUrl;    
					console.log(previewUrl);
					// Load the preview based on the URL
					try {
						var weightlength = document.querySelectorAll('.weight_filter:checked');
						var subcollectionlength = document.querySelectorAll('.subcollection_filter:checked');
						
						var otherlength = document.querySelectorAll('[name="other"]:checked');
						
						if (weightlength.length > 0 || subcollectionlength.length > 0 || otherlength.length > 0) {
							const response = await fetch(previewUrl);
							if (!response.ok) {
								throw new Error('Network response was not ok');
							}
							const res = await response.text();
							document.querySelector('.mbody').innerHTML = res;
							document.querySelector('.mod_title').innerHTML = this.getAttribute('data-preview-title');
							$('#exampleModal').modal('show');
							this.innerHTML = 'Load Preview';
							} else {
							swal("Please select the any set of filters!");
							$('#exampleModal').modal('hide');
							this.innerHTML = 'Load Preview';
						}
						// You can do further processing with the data here, like displaying it in a preview modal
						} catch (error) {
						console.error('There was a problem with your fetch operation:', error);
					}
				});
			});
			
			
			document.getElementById('download-pdf').addEventListener('click', function() {
				// var iframeContent =  document.querySelector('.mbody').contentWindow.document.body.innerHTML;
				var iframeContent = document.querySelector('.mbody').innerHTML;
				const timestamp = new Date().getTime(); // Get current timestamp
                const randomNumber = Math.floor(Math.random() * 1000); // Generate random number between 0 and 999
                const uniqueName = `ELECTRO_FORMING_${timestamp}.pdf`; // Combine timestamp and random number
                html2pdf().from(iframeContent).save(uniqueName); // Save the PDF with the unique name

			});
			
		});
	</script>
	
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const catalogContainer = document.getElementById('catalog-slider-section');
			const downloadButton = document.getElementById('download-catalogue');
			
			// Add click event listener to the button
			downloadButton.addEventListener('click', function() {
				// Toggle the visibility of the container
				catalogContainer.classList.toggle('d-none');
			});
			
		});
	</script>
<?php } ?>