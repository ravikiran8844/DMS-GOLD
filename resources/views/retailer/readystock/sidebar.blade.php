<section class="col-lg-3 col-xxl-2 d-none d-lg-block p-lg-2">


    <div class="row g-0">
        <div class="col-12 mb-4">
            <div class="col-12 mt-3 mb-2 d-flex  justify-content-between gap-1 flex-wrap">
                <div class="filters-title">Filters</div>
                <div><button type="button" id="clear-all-btn" class="clear-all-btn"
                        onclick="clearAllSelectedInputs()">CLEAR
                        ALL</button></div>
            </div>

        </div>
        @php
            $currentProjectId = $project_id;
            $products = App\Models\Product::where('Project', $currentProjectId)
                ->select('product_variants.qty', 'products.*')
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->where('product_variants.qty', '>', 0)
                ->select('products.Item', DB::raw('MIN(products.id) as id'))
                ->groupBy('products.Item')
                ->get();
            $procategorys = App\Models\Product::where('Project', $currentProjectId)
                ->select('product_variants.qty', 'products.*')
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->where('product_variants.qty', '>', 0)
                ->select('products.Procatgory', DB::raw('MIN(products.id) as id'))
                ->groupBy('products.Procatgory')
                ->get();
            $puritys = App\Models\Product::where('Project', $currentProjectId)
                ->select('product_variants.qty', 'products.*')
                ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                ->where('product_variants.qty', '>', 0)
                ->select('product_variants.Purity', DB::raw('MIN(product_variants.id) as id'))
                ->groupBy('product_variants.Purity')
                ->get();
        @endphp
        <input type="hidden" name="product" id="product" value="">
        <input type="hidden" name="procategory" id="procategory" value="">
        <input type="hidden" name="purity" id="purity" value="">
        <input type="hidden" name="productFilter" id="productFilter" value="{{ $products->toJson() }}">
        <input type="hidden" name="procategoryFilter" id="procategoryFilter" value="{{ $procategorys->toJson() }}">
        <input type="hidden" name="purityFilter" id="purityFilter" value="{{ $puritys->toJson() }}">

        <div class="col-12 custom-accordian">
            <div class="accordion sidebarFilters">

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#product" aria-expanded="true" aria-controls="box">
                            Product
                        </button>
                    </h2>
                    <div id="product" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="product-filter">
                        </div>
                    </div>
                </div>

                <div class="accordion-item mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#proCategoryFilter" aria-expanded="true" aria-controls="proCategoryFilter">
                            Pro Category
                        </button>
                    </h2>

                    <div id="proCategoryFilter" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="procategory-filters-container">
                            <!-- Procategory filters will be appended here -->
                        </div>
                    </div>
                </div>

                <div class="accordion-item mt-3">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#purityFilter" aria-expanded="true" aria-controls="purityFilter">
                            Purity
                        </button>
                    </h2>

                    <div id="purityFilter" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="purity-filters-container">
                            <!-- Procategory filters will be appended here -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
