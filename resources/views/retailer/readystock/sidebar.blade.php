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
            $usedWeights = App\Models\Product::where('qty', '>', 0)->pluck('weight')->toArray();

            $weights = App\Models\Weight::where(function ($query) use ($usedWeights) {
                foreach ($usedWeights as $productWeight) {
                    $query->orWhere(function ($q) use ($productWeight) {
                        $q->where('weight_range_from', '<=', $productWeight)->where(
                            'weight_range_to',
                            '>=',
                            $productWeight,
                        );
                    });
                }
            })->get();
            $currentProjectId = $project_id;
            $products = App\Models\Product::where('Project', $currentProjectId)
                ->where('qty', '>', 0)
                ->select('Item', DB::raw('MIN(id) as id'))
                ->groupBy('Item')
                ->get();
            $procategorys = App\Models\Product::where('Project', $currentProjectId)
                ->where('qty', '>', 0)
                ->select('Procatgory', DB::raw('MIN(id) as id'))
                ->groupBy('Procatgory')
                ->get();
        @endphp
        <input type="hidden" name="product" id="product" value="">
        <input type="hidden" name="hdweightfrom" id="hdweightfrom" value="">
        <input type="hidden" name="hdweightto" id="hdweightto" value="">
        <input type="hidden" name="procategory" id="procategory" value="">
        <input type="hidden" name="weights" id="weights" value="{{ $weights->toJson() }}">
        <input type="hidden" name="productFilter" id="productFilter" value="{{ $products->toJson() }}">
        <input type="hidden" name="procategoryFilter" id="procategoryFilter" value="{{ $procategorys->toJson() }}">

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
                            data-bs-target="#weightRangeFilter" aria-expanded="true" aria-controls="weightRangeFilter">
                            Weight Range
                        </button>
                    </h2>

                    <div id="weightRangeFilter" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="weight-filters-container">
                            <!-- Weight filters will be appended here -->
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

            </div>
        </div>
    </div>
</section>
