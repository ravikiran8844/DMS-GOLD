var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var baseurl = window.location.origin;

// Define initial chart data
$(document).ready(function () {
    $("#datefilter").daterangepicker({
        autoUpdateInput: false, // Prevent automatic update of input field
    });
    // Update input field when a date range is selected
    $("#datefilter").on("apply.daterangepicker", function (ev, picker) {
        $(this).val(
            picker.startDate.format("DD-MM-YYYY") +
                " - " +
                picker.endDate.format("DD-MM-YYYY")
        );
    });
    FromDate = moment();
    ToDate = moment();
    $("#daterangefilter").daterangepicker({
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [
                moment().subtract("days", 1),
                moment().subtract("days", 1),
            ],
            "Last 7 Days": [moment().subtract("days", 6), moment()],
            "Last 30 Days": [moment().subtract("days", 29), moment()],
            "This Month": [moment().startOf("month"), moment().endOf("month")],
            "Last Month": [
                moment().subtract("month", 1).startOf("month"),
                moment().subtract("month", 1).endOf("month"),
            ],
        },
        //FromDate: moment(),
        //ToDate: moment(),
        startDate: moment().subtract(6, "days"),
        endDate: moment(),
        locale: {
            format: "DD-MM-YYYY",
        },
    });
});
function newchart1(totalWeight, month) {
    let initialData = {
        labels: month,
        datasets: [
            {
                label: "Total Weight",
                backgroundColor: "#7BD3EA",
                borderColor: "transparent",
                data: totalWeight,
                pointHoverBackgroundColor: "#F78D1E",
                pointBorderColor: "transparent",
                pointHoverBorderColor: "#fff",
                pointHoverBorderWidth: 5,
                borderWidth: 1,
                pointRadius: 8,
                pointHoverRadius: 8,
                cubicInterpolationMode: "monotone",

                //barPercentage: 10,
                barThickness: 50,
                //maxBarThickness: 10,
                //minBarLength: 10,
                //data: [10, 20, 30, 40, 50, 60, 70]
            },
        ],
    };
    // Get chart canvas and context
    const ctx1 = $("#Chart1")[0].getContext("2d");
    const config = {
        type: "bar",
        data: initialData,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        labelColor: function (context) {
                            return {
                                backgroundColor: "#ffffff",
                                color: "#171717",
                            };
                        },
                    },
                    intersect: false,
                    backgroundColor: "#F78D1E",
                    title: {
                        fontFamily: "Poppins",
                        color: "#8F92A1",
                        fontSize: 14,
                    },
                    body: {
                        fontFamily: "Poppins",
                        color: "#171717",
                        fontStyle: "600",
                        fontSize: 16,
                    },
                    multiKeyBackground: "transparent",
                    displayColors: false,
                    padding: {
                        x: 30,
                        y: 10,
                    },
                    bodyAlign: "center",
                    titleAlign: "center",
                    titleColor: "#ffffff",
                    bodyColor: "#ffffff",
                    bodyFont: {
                        family: "Inter",
                        size: "16",
                        weight: "600",
                    },
                },
                legend: {
                    display: false,
                },
            },
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: false,
            },
            scales: {
                y: {
                    grid: {
                        display: true,
                        drawTicks: false,
                        drawBorder: false,
                    },
                    ticks: {
                        padding: 35,
                        max: 1200,
                        min: 500,
                    },
                },
                x: {
                    grid: {
                        drawBorder: false,
                        color: "rgba(143, 146, 161, .1)",
                        zeroLineColor: "rgba(143, 146, 161, .1)",
                    },
                    ticks: {
                        padding: 20,
                    },
                },
            },
        },
    };
    // Initialize chart with initial data
    const chart1 = new Chart(ctx1, config);
}
function newchart2(totalWeight, month) {
    //Chart 2
    const ctx2 = $("#Chart2")[0].getContext("2d");
    const labels1 = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "June",
        "July",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];
    const labels = month;
    // const labels = month;
    const data1 = {
        labels: labels,

        datasets: [
            {
                label: "EF IDOL",
                data: [90, 0, 0, 0, 0, 0, 0, 0, 0, 30, 0, 0],
                backgroundColor: "#F183B1",
                stack: "Stack 0",
            },
            {
                label: "ELECTRO FORMING",
                data: [10, 60, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0],
                backgroundColor: "#E8BA30",
                stack: "Stack 0",
            },
            {
                label: "SIL CASTING",
                data: [0, 10, 70, 0, 0, 0, 0, 0, 0, 10, 0, 0],
                backgroundColor: "#30C9E8",
                stack: "Stack 0",
            },
            {
                label: "SIL CHAIN",
                data: [10, 0, 0, 40, 0, 0, 0, 0, 0, 10, 0, 0],
                backgroundColor: "#2DD171",
                stack: "Stack 0",
            },
            {
                label: "SIL CLADDING",
                data: [0, 0, 10, 0, 60, 0, 0, 0, 0, 20, 0, 0],
                backgroundColor: "#307CE8",
                stack: "Stack 0",
            },
            {
                label: "SIL HOME DECOR",
                data: [0, 10, 0, 0, 0, 80, 0, 0, 0, 40, 0, 0],
                backgroundColor: "#E86D30",
                stack: "Stack 0",
            },
            {
                label: "SIL INDIANIA",
                data: [10, 0, 0, 0, 0, 0, 90, 0, 0, 10, 0, 0],
                backgroundColor: "#2A9DB3",
                stack: "Stack 0",
            },
            {
                label: "SIL PAYAL",
                data: [10, 0, 10, 0, 0, 0, 0, 50, 70, 10, 0, 0],
                backgroundColor: "#97BDF3",
                stack: "Stack 0",
            },
            {
                label: "SIL SOLID IDOL",
                data: [10, 0, 0, 0, 0, 0, 0, 0, 60, 80, 0, 0],
                backgroundColor: "#E8307C",
                stack: "Stack 0",
            },
            {
                label: "SIL UTENSIL",
                data: [0, 0, 10, 0, 0, 0, 0, 0, 0, 20, 60, 0],
                backgroundColor: "#3136A9",
                stack: "Stack 0",
            },
            {
                label: "SJ-RUMI",
                data: [0, 0, 10, 0, 0, 0, 0, 0, 0, 10, 0, 90],
                backgroundColor: "#832F5C",
                stack: "Stack 0",
            },
        ],
    };
    const data = {
        labels: labels,
        datasets: [
            {
                label: "IDOL",
                data: totalWeight,
                backgroundColor: "#F183B1",
                stack: "Stack 0",
                barThickness: 50, // Adjust the bar width
            },
        ],
    };
    const config = {
        type: "bar",
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Project vs Volume vs Month",
                },
                legend: {
                    display: true,
                    position: "right",
                },
            },
            responsive: true,
            interaction: {
                intersect: false,
            },

            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                },
            },
        },
    };
    const chart = new Chart(ctx2, config);
}
var totalWeight = JSON.parse($("#orderdata").val());
var month = JSON.parse($("#ordermonth").val());

// newchart1(totalWeight,month);
// newchart2(totalWeight,month);
$("#daterangefilter").on("change", function () {
    var selectedDate = $("#daterangefilter").val();
    $.ajax({
        url: "datefilters",
        method: "GET",
        data: {
            daterangefilter: selectedDate,
        },
        success: function (response) {
            console.log("New count");
            console.log(response.ordersCount);
            $("#totalorders").text(response.ordersCount);
            $("#totalweight").text(response.weightCount);
            $("#totalproject").text(response.projectCount);

            if ("filteredOrders" in response && "totalWeightSum" in response) {
                console.log("New count Datas");
                $("#totalorders").text(response.filteredOrders);
                $("#totalweight").text(response.totalWeightSum);
                $(".totpcr").text(
                    response.orderscountWithPercentage.toFixed(2) + "%"
                );
                $(".orderwegpcr").text(
                    response.ordersWithPercentage.toFixed(2) + "%"
                );
                $(".ordpjpcr").text(100 + "%");

                $(".Chart1div").html(
                    '<canvas id="Chart1" style="width: 100%; height: 400px; margin-left: -35px;"></canvas>'
                );
                newchart1(response.ordermonthweight, response.ordermonthname);
                $(".Chart2div").html('<canvas id="Chart2"></canvas>');
                newchart2(response.ordermonthweight, response.ordermonthname);
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
});

$("#datefilter").on("apply.daterangepicker", function (ev, picker) {
    console.log("Hello");
    var startDate = picker.startDate.format("DD-MM-YYYY");
    var endDate = picker.endDate.format("DD-MM-YYYY");
    console.log("From Date" + startDate + " To Date " + endDate);

    var nlabels = new Array(),
        ndatas = new Array();
    $.ajax({
        url: "/dealerDashboarddaterange",
        type: "POST", // Adjust method if needed
        data: {
            startDate: startDate,
            endDate: endDate,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            console.log("New Range");
            data.totalWeightMonthly.forEach(function (item) {
                nlabels.push(item.month + " " + item.year);
                ndatas.push(item.total_weight);
            });
            updateChartData(ndatas, nlabels);
            $(".total-orders-btn").html(
                'Total Orders <span class="fw-bold">' +
                    data.ordersCount +
                    "</span>"
            );
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle errors
            console.error(textStatus, errorThrown);
        },
    });
});
