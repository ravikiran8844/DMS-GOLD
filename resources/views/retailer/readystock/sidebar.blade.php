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
            $weights = App\Models\Weight::where('is_active', 1)->whereNull('deleted_at')->get();
            $currentProjectId = $project_id;
            $products = App\Models\Product::where('Project', $currentProjectId)
                ->where('qty', '>', 0)
                ->select('Item', DB::raw('MIN(id) as id'))
                ->groupBy('Item')
                ->get();
        @endphp
        <input type="hidden" name="product" id="product" value="">
        <input type="hidden" name="hdweightfrom" id="hdweightfrom" value="">
        <input type="hidden" name="hdweightto" id="hdweightto" value="">
        <input type="hidden" name="weights" id="weights" value="{{ $weights->toJson() }}">
        <input type="hidden" name="productFilter" id="productFilter" value="{{ $products->toJson() }}">
        <div class="col-12 custom-accordian">
            <div class="accordion sidebarFilters">
                {{-- <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#weightRangeFilter" aria-expanded="true" aria-controls="weightRangeFilter">
                            Weight Range
                        </button>
                    </h2>
                    <input type="hidden" name="stock" id="stock" value="{{ json_encode($stock) }}">

                    <div id="weightRangeFilter" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="weight-filters-container">
                            <!-- Weight filters will be appended here -->
                        </div>
                    </div>
                </div> --}}

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
            </div>
        </div>
    </div>
</section>
