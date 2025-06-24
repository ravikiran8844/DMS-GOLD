// 
var month = JSON.parse($("#orderdata").val());
var totalWeight = JSON.parse($("#ordermonth").val());
console.log(month);
console.log(totalWeight);
function newchart1(month,totalWeight){
    var maxY = Math.max(...totalWeight);
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            // labels: ["xSunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            labels: month,
            datasets: [{
                label: 'Statistics',
                // data: [460, 458, 330, 502, 430, 610, 488],
                data: totalWeight,
                borderWidth: 2,
                backgroundColor: '#3F4CB2',
                borderColor: '#3F4CB2',
                borderWidth: 2.5,
                pointBackgroundColor: '#F0F0F0',
                pointRadius: 4
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: '#f2f2f2',
                    },
                    ticks: {
                        beginAtZero: true,
                     //   stepSize: 150,
                        fontColor: "#9aa0ac", // Font Color
                    }
                    // ticks: {
                    //     min: 0,
                    //     max: maxY,
                    //     stepSize: 1,
                    //     suggestedMin: 100,
                    //     suggestedMax: 200,
                    //     callback: function(label, index, labels) {
                    //         if (label == 10000) {
                    //             return label;
                    //         } else if (label == maxY) {
                    //             return label;
                    //         } else if (label == 6000) {
                    //             return label;
                    //         } else if (label == 4000) {
                    //             return label;
                    //         } else if (label == 2000) {
                    //             return label;
                    //         } else if (label == 1000) {
                    //             return label;
                    //         } else if (label == 500) {
                    //             return label;
                    //         } else if (label == 100) {
                    //             console.log("100 ...");
                    //             return 100;
                    //         } else if (label == 0) {
                    //             console.log("Value is greater than 0 but not greater than 5");
                    //         }
                    //     }
                    // }
                    // ticks: {
                    //     min: 0,
                    //     max: maxY,
                    //     stepSize: 1,
                    //     callback: function (value, index, values) {
                    //         return ((value / maxY) * 100).toFixed(2) + "%";
                    //     }
                    // }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    },
                    gridLines: {
                        display: false
                    }
                }]
            },
        }
    });
    
}
function newchart2(month,totalWeight){
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
	type: 'line',
	data: {
	//	 labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        labels:month,
		datasets: [{
			label: 'Statistics',
	//	     data: [460, 458, 330, 502, 430, 610, 488],
            data:totalWeight,
			borderWidth: 2,
			backgroundColor: '#FFC4A6',
			borderColor: '#FFC4A6',
			borderWidth: 2.5,
			pointBackgroundColor: '#ffffff',
			pointRadius: 4
		}]
	},
	options: {
		legend: {
			display: false
		},
		scales: {
			yAxes: [{
				gridLines: {
					drawBorder: false,
					color: '#f2f2f2',
				},
				ticks: {
					beginAtZero: true,
					//stepSize: 150,
					fontColor: "#9aa0ac", // Font Color
				}
			}],
			xAxes: [{
				ticks: {
					display: false,
					fontColor: "#9aa0ac", // Font Color
				},
				gridLines: {
					display: false
				}
			}]
		},
	}
});
}
// newchart1(month,totalWeight);
// newchart2(month,totalWeight);
$('#dealerfilter, #datefilter, #zonefilter, #projectfilter').on('change', function () {
    var selectedDealerId = $('#dealerfilter').val();
    var selectedDate = $('#datefilter').val();
    var selectedZone = $('#zonefilter').val();
    var selectedProject = $('#projectfilter').val(); // Add this line

    $.ajax({
        url: 'filters',
        method: 'GET',
        data: {
            dealerId: selectedDealerId,
            dateFilter: selectedDate,
            zoneFilter: selectedZone,
            projectFilter: selectedProject // Add this line
        },
        success: function (response) {
            console.log(response.ordersCount);
            $("#totalorders").text(response.ordersCount);
            $("#totalweight").text(response.weightCount);
            $("#totalproject").text(response.projectCount);

            if ('filteredOrders' in response && 'totalWeightSum' in response) {
                $("#totalorders").text(response.filteredOrders);
                $("#totalweight").text(response.totalWeightSum);
                $(".myChart2div").html('<canvas id="myChart2"></canvas>');
                $(".myChartdiv").html('<canvas id="myChart"></canvas>');
                newchart1(month,totalWeight);
                newchart2(month,totalWeight);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});


