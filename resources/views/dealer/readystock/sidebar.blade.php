<section class="col-lg-3 col-xxl-2 d-none d-lg-block p-lg-2">
    <div class="mt-3 mt-lg-0 d-none d-lg-block">
        <div class="shop-page-breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-0">
                    @if ($breadcrumUrl != null && $breadcrum != null)
                        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ $breadcrumUrl }}">{{ $breadcrum }}</a>
                        </li>
                    @else
                        <li><b>Search results for: {{ $search }}</b></li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

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
            $colors = App\Models\Color::where('is_active', 1)->whereNull('deleted_at')->get();
            $platings = App\Models\Plating::where('is_active', 1)->whereNull('deleted_at')->get();
            $classifications = App\Models\Classification::where('is_active', 1)->get();
            $currentProjectId = $project_id;
            $collections = App\Models\Collection::where('is_active', 1)
                ->where('collection_name', 'GOD')
                ->whereNull('deleted_at')
                ->get();
            $others = App\Models\Collection::where('is_active', 1)
                ->where('collection_name', '!=', 'GOD')
                ->where('project_id', App\Enums\Projects::ELECTROFORMING)
                ->whereNull('deleted_at')
                ->get();
            $jewelcategories = App\Models\Category::where('is_active', 1)
                ->where('project_id', App\Enums\Projects::CASTING)
                ->whereNull('deleted_at')
                ->get();
            $utensilcategories = App\Models\Category::where('is_active', 1)
                ->where('project_id', App\Enums\Projects::UTENSIL)
                ->whereNull('deleted_at')
                ->get();

            $validProjects = [
                App\Enums\Projects::SOLIDIDOL,
                App\Enums\Projects::ELECTROFORMING,
                App\Enums\Projects::CASTING,
                App\Enums\Projects::UTENSIL,
                App\Enums\Projects::INIDIANIA,
            ];

            if (in_array($currentProjectId, $validProjects)) {
                $boxes = App\Models\Style::where('is_active', 1)
                    ->where('project_id', $currentProjectId)
                    ->whereNull('deleted_at')
                    ->whereHas('products', function ($query) {
                        $query->where('qty', '>', 0);
                    })
                    ->get();
            }
            $purities = App\Models\SilverPurity::with([
                'products' => function ($query) use ($currentProjectId) {
                    $query->where('qty', '>', 0)->where('project_id', $currentProjectId);
                },
            ])
                ->whereHas('products', function ($query) use ($currentProjectId) {
                    $query->where('qty', '>', 0)->where('project_id', $currentProjectId);
                })
                ->get();
        @endphp
        <input type="hidden" name="subcol" id="subcol" value="">
        <input type="hidden" name="col" id="col" value="">
        <input type="hidden" name="class" id="class" value="">
        <input type="hidden" name="jewcat" id="jewcat" value="">
        <input type="hidden" name="box" id="box" value="">
        <input type="hidden" name="purity" id="purity" value="">
        <input type="hidden" name="hdweightfrom" id="hdweightfrom" value="">
        <input type="hidden" name="hdweightto" id="hdweightto" value="">
        <input type="hidden" name="weights" id="weights" value="{{ $weights->toJson() }}">
        <input type="hidden" name="classification" id="classification" value="{{ $classifications->toJson() }}">
        <input type="hidden" name="utensilcategoryFilter" id="utensilcategoryFilter"
            value="{{ $utensilcategories->toJson() }}">
        <input type="hidden" name="otherFilter" id="otherFilter" value="{{ $others->toJson() }}">
        <input type="hidden" name="categoryFilter" id="categoryFilter" value="{{ $jewelcategories->toJson() }}">
        <input type="hidden" name="boxFilter" id="boxFilter" value="{{ $boxes->toJson() }}">
        <input type="hidden" name="purityFilter" id="purityFilter" value="{{ $purities->toJson() }}">
        <div class="col-12 custom-accordian">
            <div class="accordion sidebarFilters">
                @if ($currentProjectId == App\Enums\Projects::SOLIDIDOL)
                    <div class="accordion-item mb-4">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#classificationFilter" aria-expanded="true"
                                aria-controls="classificationFilter">
                                Classification
                            </button>
                        </h2>

                        <div id="classificationFilter" class="accordion-collapse collapse show">
                            <div class="accordion-body">
                                @foreach ($classifications as $classification)
                                    <div class="form-check">
                                        <input class="form-check-input classification classification_name_filter"
                                            type="checkbox" id="classification{{ $classification->id }}"
                                            name="classification" value="{{ $classification->classification_name }}"
                                            onclick="getclassificationproduct({{ $classification->id }})">
                                        <label class="form-check-label" for="classification{{ $classification->id }}">
                                            {{ $classification->classification_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#weightRangeFilter" aria-expanded="true"
                            aria-controls="weightRangeFilter">
                            Weight Range
                        </button>
                    </h2>
                    <input type="hidden" name="stock" id="stock" value="{{ json_encode($stock) }}">

                    <div id="weightRangeFilter" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="weight-filters-container">
                            <!-- Weight filters will be appended here -->
                        </div>
                    </div>

                </div>
                @if ($currentProjectId == App\Enums\Projects::ELECTROFORMING || $currentProjectId == App\Enums\Projects::SOLIDIDOL)
                    <div id="sidebarFilters">

                    </div>
                @endif
                @if ($currentProjectId == App\Enums\Projects::ELECTROFORMING)

                    <div class="accordion-item mt-4">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#others" aria-expanded="true" aria-controls="others">
                                Others
                            </button>
                        </h2>

                        <div id="others" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                @foreach ($others as $other)
                                    <div class="form-check">
                                        <input class="form-check-input others" type="checkbox"
                                            id="{{ $other->collection_name }}" name="other"
                                            data-id={{ $other->id }} value="{{ $other->collection_name }}"
                                            onclick="getCollectionWiseProducts({{ $other->id }})">
                                        <label class="form-check-label" for="{{ $other->collection_name }}">
                                            {{ $other->collection_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if ($currentProjectId == App\Enums\Projects::CASTING)
                    <div class="accordion-item mt-4">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#jewelcategory" aria-expanded="true" aria-controls="jewelcategory">
                                Jewellery
                            </button>
                        </h2>
                        <div id="jewelcategory" class="accordion-collapse collapse show">
                            <div class="accordion-body" id="jewel-category-filter">
                            </div>
                        </div>
                    </div>
                @endif
                @if ($currentProjectId == App\Enums\Projects::UTENSIL)
                    <div class="accordion-item mt-4">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#utensilcategory" aria-expanded="true"
                                aria-controls="utensilcategory">
                                Category
                            </button>
                        </h2>
                        <div id="utensilcategory" class="accordion-collapse collapse show">
                            <div class="accordion-body" id="utensil-category-filter">
                            </div>
                        </div>
                    </div>
                @endif
                @if ($currentProjectId != App\Enums\Projects::UTENSIL && $currentProjectId != App\Enums\Projects::INIDIANIA)
                    <div class="accordion-item mt-4">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#box" aria-expanded="true" aria-controls="box">
                                Box/Style
                            </button>
                        </h2>
                        <div id="box" class="accordion-collapse collapse show">
                            <div class="accordion-body" id="box-filter">
                            </div>
                        </div>
                    </div>
                @endif
                <div class="accordion-item mt-4">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#purity" aria-expanded="true" aria-controls="box">
                            Puirty
                        </button>
                    </h2>
                    <div id="purity" class="accordion-collapse collapse show">
                        <div class="accordion-body" id="purity-filter">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('dealer/lib/js/jquery.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log(document.getElementById("categoryFilter").value);
    });
    let subcollectionsjson = JSON.parse($("#subCollectionData").val());
    // Sorting function to sort the arrays based on the "item_name" property
    function sortByItemName(a, b) {
        if (a.item_name < b.item_name) return -1;
        if (a.item_name > b.item_name) return 1;
        return 0;
    }

    function addKeyValueToObjects(data, newKey, item) {
        return data.map(obj => ({
            ...obj,
            [newKey]: obj[item]
        }));
    }

    let newSubCollectionData = addKeyValueToObjects(subcollectionsjson, 'item_name', 'sub_collection_name');

    newSubCollectionData.sort(sortByItemName);

    let filtersData = [{
        "name": "GOD",
        "data": newSubCollectionData,
        "filterName": "subcollection"
    }, ];

    let MainFiltersContainer = document.getElementById("sidebarFilters");

    filtersData.forEach(each => {
        let mainFilterItem = document.createElement("div");
        let mainFilterPopUp = document.createElement("div");
        mainFilterItem.innerHTML = `
      <div class="accordion-item my-3">
        <h6 class="accordion-header">
          <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMainFilter-${each.filterName}" aria-expanded="true"
            aria-controls="sidebarMainFilter-${each.filterName}">
            ${each.name}
          </button>
        </h6>
        <div id="sidebarMainFilter-${each.filterName}" class="accordion-collapse collapse show">
          <div class="accordion-body">
            <div>
              <div>
                <input class="form-control mb-3" type="search" id="sidebarSearch-${each.filterName}"
                  placeholder="Search ${each.name}...">
              </div>
              <div>
              <button type="button" onclick="clearCheckboxes()" class="clear-all-btn sidebar-clear-btn  mb-3">CLEAR
                ALL</button>
              </div>
              <div id="sidebarLabels-${each.filterName}"></div>
            </div>
            <div>
              <button class="btn open-popup" data-popup="${each.filterName}">Show All</button>
            </div>
          </div>
        </div>
      </div>`;

        mainFilterPopUp.innerHTML = `
       <div class="popup rk-filter" id="popup-${each.filterName}" style="display: none;">
       <div class="d-flex align-items-center gap-3 mb-2"
          style="padding: 10px;border-bottom: 1px solid #eaeaec;position: sticky;background: #fff;top: 0px;">
          <div>
            <input type="text" class="form-control" id="search-popup-${each.filterName}" placeholder="Search...">
          </div>
          <div id="sorting-buttons-${each.filterName}"></div>
          <button class="btn close-popup" style=" position: absolute; right: 0px; top: 0px; ">
            <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <title>close-circle-outline</title>
              <path
                d="M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22C17.53,22 22,17.53 22,12C22,6.47 17.53,2 12,2M14.59,8L12,10.59L9.41,8L8,9.41L10.59,12L8,14.59L9.41,16L12,13.41L14.59,16L16,14.59L13.41,12L16,9.41L14.59,8Z">
              </path>
            </svg>
          </button>
        </div>
        <div class="filter-apply-btn">
        <button class="btn close-popup btn-warning">Apply</button>
        </div>
        <div class="filter-elements" id="filter-elements-${each.filterName}">
        </div>
        
      </div>`;

        MainFiltersContainer.appendChild(mainFilterItem);
        MainFiltersContainer.appendChild(mainFilterPopUp);
        // Generate input elements for each filter
        generateInputElements(each.filterName, each.data);
        generatePopupInputElements(each.filterName, each.data);
        generatePopupSortingButtons(each.filterName, each.data);

    });

    // Function to generate input elements based on data for each filter
    function generateInputElements(filterName, data) {
        let filterContainer = document.getElementById(`sidebarLabels-${filterName}`);
        data.forEach((item, index) => {
            let div = document.createElement("div");
            div.classList.add("form-check");
            let input = document.createElement("input");
            input.type = "checkbox";
            input.classList.add("form-check-input");
            input.classList.add("subcollection_filter");
            input.id =
                `${item.item_name.replace(/\s+/g, '_').toLowerCase()}-${filterName}-sidebar`; // Replace spaces with underscores
            input.value = item.item_name;
            let label = document.createElement("label");
            label.classList.add("form-check-label");
            label.setAttribute("for", input.id);
            label.innerText = item.item_name;
            input.setAttribute("onclick", "getsubcollectionproduct(" + item.id + ")"); // Add onclick attribute
            input.setAttribute("data-id", item.id);
            div.appendChild(input);
            div.appendChild(label);
            filterContainer.appendChild(div);

            if (index >= 10) {
                div.style.display = "none";
            }

        });
    }

    // Add event listeners for popup close buttons
    document.querySelectorAll(".close-popup").forEach(button => {
        button.addEventListener("click", function() {
            let popupId = this.parentNode.parentNode.id;
            document.getElementById(popupId).style.display = "none";
        });
    });

    // Add event listener to the open popup buttons
    document.querySelectorAll(".open-popup").forEach(button => {
        button.addEventListener("click", function() {
            let popupId = `popup-${this.getAttribute("data-popup")}`;
            document.getElementById(popupId).style.display = "block";
        });
    });

    // Add event listeners for search input in the popup
    document.querySelectorAll("[id^='sidebarSearch']").forEach(input => {
        input.addEventListener("input", function() {
            let filterName = this.id.split("-")[1];
            filterBySearch(filterName);
        });
    });

    function filterBySearch(filterName) {
        // console.log(`sidebarSearch-${filterName}`);
        let searchInput = document.getElementById(`sidebarSearch-${filterName}`).value.toLowerCase();
        let elements = document.querySelectorAll(`#sidebarLabels-${filterName} > div`);
        let displayedCount = 0; // Counter for displayed elements

        elements.forEach(function(element) {
            let label = element.querySelector("label").innerText.toLowerCase();
            if (label.includes(searchInput)) {
                if (displayedCount < 10) {
                    element.style.display = "flex";
                    displayedCount++;
                } else {
                    element.style.display = "none";
                }
            } else {
                element.style.display = "none";
            }
        });
    }

    // Function to generate input elements for popup filters
    function generatePopupInputElements(filterName, data) {
        let popupContainer = document.getElementById(`filter-elements-${filterName}`);
        popupContainer.innerHTML = ''; // Clear existing elements

        data.forEach(item => {
            let div = document.createElement("div");
            div.classList.add("form-check");
            let input = document.createElement("input");
            input.type = "checkbox";
            input.classList.add("form-check-input");
            input.classList.add("subcollection_filter");
            input.id =
                `${item.item_name.replace(/\s+/g, '_').toLowerCase()}-${filterName}-popup`; // Replace spaces with underscores
            input.value = item.item_name;
            let label = document.createElement("label");
            label.classList.add("form-check-label");
            label.setAttribute("for", input.id);
            label.innerText = item.item_name;
            input.setAttribute("onclick", "getsubcollectionproduct(" + item.id + ")"); // Add onclick attribute
            input.setAttribute("data-id", item.id);
            div.appendChild(input);
            div.appendChild(label);
            popupContainer.appendChild(div);
        });
    }


    // Function to generate sorting buttons for each letter from A to Z based on available data
    function generatePopupSortingButtons(filterName, data) {
        let sortingButtonsContainer = document.getElementById(`sorting-buttons-${filterName}`);
        if (!sortingButtonsContainer) {
            console.error(`Container for sorting buttons not found: sorting-buttons-${filterName}`);
            return;
        }
        sortingButtonsContainer.innerHTML = ''; // Clear existing buttons

        // Create the '#' button
        let button = document.createElement("button");
        button.className = "sort-button";
        button.setAttribute("data-sort", "#");
        button.innerText = "#";
        button.addEventListener("click", function() {
            toggleAllInputs(filterName);
        });
        sortingButtonsContainer.appendChild(button);

        // Using a Set to ensure uniqueness of available letters
        let availableLetters = new Set();
        data.forEach(function(item) {
            let firstLetter = item.item_name.trim().charAt(0).toUpperCase();
            availableLetters.add(firstLetter);
        });

        // Generate buttons for letters A to Z
        for (let i = 0; i < 26; i++) {
            let letter = String.fromCharCode(65 + i); // ASCII code for letters A to Z

            let button = document.createElement("button");
            button.className = "sort-button";
            button.setAttribute("data-sort", letter);
            button.innerText = letter;

            if (availableLetters.has(letter)) {
                // Enable button if the letter is available
                button.addEventListener("click", function() {
                    filterByLetter(filterName, this.getAttribute("data-sort"));
                });
            } else {
                // Disable button if the letter is not available
                button.disabled = true;
            }
            sortingButtonsContainer.appendChild(button);
        }
    }



    // Function to filter and display elements based on the clicked letter
    function filterByLetter(filterName, letter) {
        console.log(letter)

        let elements = document.querySelectorAll(`#filter-elements-${filterName} > div`);
        console.log(elements)

        elements.forEach(function(element) {
            let label = element.querySelector("label").innerText.trim();
            if (label.charAt(0).toUpperCase() === letter) {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        });
    }

    // Function to filter elements based on search input in the popup
    function filterByPopUpSearch(filterName) {
        let searchInput = document.getElementById(`search-popup-${filterName}`).value.toLowerCase();
        let elements = document.querySelectorAll(`#filter-elements-${filterName} > div`);
        elements.forEach(function(element) {
            let label = element.querySelector("label").innerText.toLowerCase();
            if (label.includes(searchInput)) {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        });
    }

    // Add event listeners for search input in the popup
    document.querySelectorAll("[id^='search-popup']").forEach(input => {
        input.addEventListener("input", function() {
            let filterName = this.id.split("-")[2];
            filterByPopUpSearch(filterName);
        });
    });

    // Add event listeners for sorting buttons
    document.querySelectorAll(".sort-button").forEach(button => {
        button.addEventListener("click", function() {
            let filterName = this.parentNode.id.split("-")[2];
            let letter = this.getAttribute("data-sort");
            if (letter === "#") {
                toggleAllInputs(filterName);
            } else {
                filterByLetter(filterName, letter);
            }
        });
    });

    // Function to toggle the visibility of all input elements
    function toggleAllInputs(filterName) {
        let elements = document.querySelectorAll(`#filter-elements-${filterName} > div`);
        elements.forEach(function(element) {
            element.style.display = "block";
        });
    }

    // Event handler for checkbox change
    function handleCheckboxChange() {
        const id = this.getAttribute('data-id');
        const filterId = this.id;
        const filterName = this.id.split("-")[1];
        // const label = this.nextElementSibling.innerText;
        const label = this.parentNode.querySelector('label'); // Extract the label element
        const selectedFiltersWrapper = document.getElementById("selected-filters-wrapper");

        if (this.checked) {
            // Create a new element for the selected filter
            const selectedFilter = document.createElement("div");
            selectedFilter.classList.add("selected-filter");
            selectedFilter.id = `selected-filter-${filterId}`;
            selectedFilter.innerHTML = `
            <label for="${filterId}">
            ${label.textContent} <span>&times;</span></label>
        `;
            selectedFiltersWrapper.appendChild(selectedFilter); // Append the selected filter
        } else {
            // If unchecked, remove the corresponding selected filter
            const selectedFilter = document.getElementById(`selected-filter-${filterId}`);
            if (selectedFilter) {
                selectedFiltersWrapper.removeChild(selectedFilter); // Remove the selected filter from the list
            }
        }
    }

    // Function to handle All Other filters change
    function handleOtherFiltersChange() {

        const filterId = this.id; // Extract the filter ID
        const label = this.parentNode.querySelector('label'); // Extract the label element
        const selectedFiltersWrapper = document.getElementById(
            "selected-filters-wrapper"); // Container for selected filters

        if (this.checked) {
            // Create a new element for the selected filter
            const selectedFilter = document.createElement("div");
            selectedFilter.classList.add("selected-filter");
            selectedFilter.id = `selected-filter-${filterId}`;
            selectedFilter.innerHTML = `
            <label for="${filterId}">
            ${label.textContent} <span>&times;</span></label>
        `;
            selectedFiltersWrapper.appendChild(selectedFilter); // Append the selected filter
        } else {
            // If unchecked, remove the corresponding selected filter
            const selectedFilter = document.getElementById(`selected-filter-${filterId}`);
            if (selectedFilter) {
                selectedFiltersWrapper.removeChild(selectedFilter); // Remove the selected filter from the list
            }
        }
    }

    // Function to synchronize checkbox state between sidebar and popup
    function syncCheckboxState(filterValue, isChecked) {
        // Update corresponding popup filter checkbox
        $('#popup-subcollection .subcollection_filter[value="' + filterValue + '"]').prop('checked', isChecked);
        // Update corresponding sidebar filter checkbox
        $('.subcollection_filter[value="' + filterValue + '"]').prop('checked', isChecked);
    }

    // Event listener for checkbox change, delegated to a parent element
    $(document).on('change', '.subcollection_filter[type="checkbox"]', function() {
        let filterValue = $(this).val();
        let isChecked = $(this).is(':checked');

        // Sync changes to popup filter
        syncCheckboxState(filterValue, isChecked);
    });

    // Event listener for popup filter checkbox change
    $(document).on('change', '#popup-subcollection .subcollection_filter[type="checkbox"]', function() {
        let filterValue = $(this).val();
        let isChecked = $(this).is(':checked');
        // Sync changes to sidebar filter
        syncCheckboxState(filterValue, isChecked);
    });

    // Get all weight checkboxes with class 'weight_filter'
    // const weightCheckboxes = document.querySelectorAll('.weight_filter[type="checkbox"]');
    // // Attach event listener to each weight checkbox
    // weightCheckboxes.forEach(checkbox => {
    //     checkbox.addEventListener('change', handleOtherFiltersChange);
    // });

    // Get all Others checkboxes with class 'others'
    // const othersCheckboxes = document.querySelectorAll('.others[type="checkbox"]');
    // // Attach event listener to each Others checkbox
    // othersCheckboxes.forEach(checkbox => {
    //     checkbox.addEventListener('change', handleOtherFiltersChange);
    // });

    // function updateSelectedFilters() {
    //     document.querySelectorAll('.subcollection_filter').forEach(input => {
    //         input.addEventListener('change', handleCheckboxChange);
    //     });
    //     document.querySelectorAll('.classification_name_filter').forEach(input => {
    //         input.addEventListener('change', handleCheckboxChange);
    //     });

    //     document.querySelectorAll('.form-check-input.weight_filter').forEach(input => {
    //         input.addEventListener('change', handleCheckboxChange);
    //         console.log("event added")
    //     });
    // }

    // updateSelectedFilters()


    // Function to clear all selected inputs
    function clearAllSelectedInputs() {
        var selectedcollectionString = $("#col").val();
        var selectedcollection = selectedcollectionString.split(",");

        var selectedsubcollectionString = $("#subcol").val();
        var selectedsubcollection = selectedsubcollectionString.split(",");

        var selectedweightfrom = $("#hdweightfrom").val();
        var selectedweightto = $("#hdweightto").val();

        var selectedweightfrom = selectedweightfrom.split(",");
        var selectedweightto = selectedweightto.split(",");

        var selectedclassification = $("#class").val();
        var selectedcategory = $("#jewcat").val();

        // Clear all checkboxes
        $(".subcollection_filter").prop("checked", false);
        $(".others").prop("checked", false);
        $(".weight_filter").prop("checked", false);
        $(".classification").prop("checked", false);
        $(".category").prop("checked", false);

        document.getElementById("selected-filters-wrapper").innerHTML = "";
        // // Remove selected filters
        // const selectedFiltersWrapper = document.getElementById("selected-filters-wrapper");
        // selectedsubcollection.forEach(id => {
        //     // If unchecked, remove the corresponding selected filter
        //     const selectedFilterSidebar = document.getElementById(
        //         `selected-filter-${id.toLowerCase()}-subcollection-sidebar`);
        //     if (selectedFilterSidebar && selectedFilterSidebar.parentNode === selectedFiltersWrapper) {
        //         selectedFiltersWrapper.removeChild(
        //             selectedFilterSidebar); // Remove the selected filter from the list
        //     }

        //     const selectedFilterPopup = document.getElementById(
        //         `selected-filter-${id.toLowerCase()}-subcollection-popup`);
        //     if (selectedFilterPopup && selectedFilterPopup.parentNode === selectedFiltersWrapper) {
        //         selectedFiltersWrapper.removeChild(
        //             selectedFilterPopup); // Remove the selected filter from the list
        //     }
        // });

        // selectedcollection.forEach(id => {
        //     // If unchecked, remove the corresponding selected filter
        //     const selectedOtherFilter = document.getElementById(`selected-filter-${id}`);
        //     if (selectedOtherFilter && selectedOtherFilter.parentNode === selectedFiltersWrapper) {
        //         selectedFiltersWrapper.removeChild(
        //             selectedOtherFilter); // Remove the selected filter from the list
        //     }
        // });

        // const selectedWeightRange = document.getElementById("weightRangeFilter");
        // selectedweightfrom.forEach((id, index) => {
        //     const weightFromId = index + 1;
        //     // If unchecked, remove the corresponding selected filter
        //     const selectedWeightFromFilter = document.getElementById(
        //         `selected-filter-weightfrom${weightFromId}`);
        //     if (selectedWeightFromFilter && selectedWeightFromFilter.parentNode === selectedFiltersWrapper) {
        //         selectedFiltersWrapper.removeChild(
        //             selectedWeightFromFilter); // Remove the selected filter from the list
        //     }
        // });

        // // Remove the selected filter
        // const selectedClassificationFilter = document.querySelector('.selected-filter span[data-id]');
        // console.log(selectedClassificationFilter, selectedClassificationFilter?.parentNode, selectedClassificationFilter
        //     ?.parentNode?.parentNode, selectedFiltersWrapper);

        // if (selectedClassificationFilter) {
        //     const parentElement = selectedClassificationFilter.parentNode.parentNode;
        //     if (parentElement === selectedFiltersWrapper) {
        //         selectedFiltersWrapper.removeChild(selectedClassificationFilter
        //             .parentNode); // Remove the parent of the span
        //     }
        // }

        if (selectedsubcollectionString != '' || selectedcollectionString != '' || selectedweightfrom != '' ||
            selectedweightto != '' || selectedclassification != '' || selectedcategory != '') {
            getsubcollectionproduct();
            getclassificationproduct();
            getcategoryproduct();
        }
    }

    // Function to clear all checked checkboxes
    function clearCheckboxes() {
        var selectedsubcollectionString = $("#subcol").val();
        var selectedsubcollection = selectedsubcollectionString.split(",");
        // Clear all checkboxes
        $(".subcollection_filter").prop("checked", false);

        // Remove selected filters
        // const selectedFiltersWrapper = document.getElementById("selected-filters-wrapper");
        // selectedsubcollection.forEach(id => {
        //     // If unchecked, remove the corresponding selected filter
        //     const selectedFilter = document.getElementById(
        //         `selected-filter-${id.toLowerCase()}-subcollection-sidebar`);
        //     if (selectedFilter) {
        //         selectedFiltersWrapper.removeChild(selectedFilter); // Remove the selected filter from the list
        //     }

        //     const selectedPopupFilter = document.getElementById(
        //         `selected-filter-${id.toLowerCase()}-subcollection-popup`);
        //     if (selectedPopupFilter) {
        //         selectedFiltersWrapper.removeChild(
        //             selectedPopupFilter); // Remove the selected filter from the list
        //     }
        // });
        if (selectedsubcollectionString != '') {
            getsubcollectionproduct();
        }
    }
</script>
