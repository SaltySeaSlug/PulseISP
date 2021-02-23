/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

$(document).ready(function () {
	$('[data-toggle="switch"]').bootstrapSwitch();
	$('.select2').select2();
});


$(function checkSupport() {
	var NotificationIsSupported = !!(window.Notification /* W3C Specification */ ||
		window.webkitNotifications /* old WebKit Browsers */ ||
		navigator.mozNotification /* Firefox for Android and Firefox OS */)

	if (!NotificationIsSupported) {
		alert("Your browser does not support notifications");
	}

});


function showInfoAlert(message, title, timeout = 2000) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "100",
		"hideDuration": "100",
		"timeOut": timeout,
		"extendedTimeOut": "100",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.info(message, title)

	//Toast.fire({type: 'success', title: message })
}
function showSuccessAlert(message, title, timeout = 2000) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "100",
		"hideDuration": "100",
		"timeOut": timeout,
		"extendedTimeOut": "100",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.success(message, title)

	//Toast.fire({type: 'success', title: message })
}
function showWarningAlert(message, title, timeout = 2000) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "100",
		"hideDuration": "100",
		"timeOut": timeout,
		"extendedTimeOut": "100",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.warning(message, title)

	//Toast.fire({type: 'success', title: message })
}
function showErrorAlert(message, title, timeout = 2000) {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"positionClass": "toast-top-right",
		"preventDuplicates": true,
		"onclick": null,
		"showDuration": "100",
		"hideDuration": "100",
		"timeOut": timeout,
		"extendedTimeOut": "100",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.error(message, title)

	//Toast.fire({type: 'error', title: message, showConfirmButton: true })
}

function rememberState(id, value) {

	// Check browser support
	if (typeof(Storage) != "undefined") {
		// Store
		localStorage.setItem(id, value);
		// Retrieve
		localStorage.getItem("id");
	} else {
		"Sorry, your browser does not support Web Storage...";
	}

}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var expires = "expires="+ d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i <ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

$(function() {
	var $sortable = $('.connectedSortable');

	var dashboard = JSON.parse(localStorage.getItem('remember.dashboard.layout'));
	if (dashboard) {
		$.each(dashboard, function(i, column) {
			$.each(column[1], function(i, item) {
				$('#' + item).appendTo($('#' + column[0])); // or prependTo for reverse
			});
		});
	}

	$sortable.sortable({ update: saveNewOrder });

	function saveNewOrder() {
		var dat = [];
		var i = 0;
		$.each($sortable, function() {
			dat[i++] = [this.id, $(this).sortable('toArray')]; // this.id is the column id, the 2nd element are the job id's in that column
		});
		localStorage.setItem('remember.dashboard.layout', JSON.stringify(dat));
	}
});

/*
$(function() {
    window.onload = function() {
        document.addEventListener("contextmenu", function(e){
            e.preventDefault();
        }, false);
        document.addEventListener("keydown", function(e) {
            //document.onkeydown = function(e) {
            // "I" key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                disabledEvent(e);
            }
            // "J" key
            if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                disabledEvent(e);
            }
            // "S" key + macOS
            if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                disabledEvent(e);
            }
            // "U" key
            if (e.ctrlKey && e.keyCode == 85) {
                disabledEvent(e);
            }
            // "F12" key
            if (event.keyCode == 123) {
                disabledEvent(e);
            }
        }, false);
        function disabledEvent(e){
            if (e.stopPropagation){
                e.stopPropagation();
            } else if (window.event){
                window.event.cancelBubble = true;
            }
            e.preventDefault();
            return false;
        }
    };
});
*/


$("#clear").click(function() {
	window.localStorage.clear();
	window.location.reload();
});
$("#save").click(function() {
	var text = $("#text").text();
	currentPos.txt = text;
	$("#append-area").append(text + "<br>");
	localStorage.setItem("appended", JSON.stringify(currentPos));
});


//let debug = true;

//let cADownloaded, cAUploaded, cAChart = '';
//let cDownloaded, cUploaded, cChart = '';
//let chartInterval, chartAuthInterval, activeSessionInterval, alertInterval, activeIPInterval, customerInterval, chartSessionInterval = '';
function curTime(hour) {
	if (hour === 0) return "00:00";
	else if (hour >=1 && hour <= 9) return "0" + hour + ":00";
	else if (hour >=10 && hour <= 23) return hour +":00";
	else return null;
}
function curDay(day) {
	if (day % 10 === 1) return day +"st";
	else if (day % 10 === 2) return day +"nd";
	else if (day % 10 === 3) return day +"rd";
	else if (day % 10 === 4 || day % 10 === 5 || day % 10 === 6 || day % 10 === 7 || day % 10 === 8 || day % 10 === 9 || day % 10 === 0) return day +"th";
	else return null;
}


function buildSessionChartData(data) {

	if (typeof data === "undefined") { console.debug("SessionChart data null"); return; }

	var name = [];
	var active = [];

	for (var i in data) {
		name.push(data[i].period);
		active.push(data[i].active);
	}

	return {
		labels: name,
		datasets: [{
			label: 'Active',
			backgroundColor: "#ffffff",
			data: active
		}]
	};
}
function buildSessionChartConfig(data) {
	return {
		type: 'line',
		data: data,
		options: {
			title: {
				display: false
			},
			legend: {
				display: false
			},
			tooltips: {
				mode: 'index',
				intersect: false,
				callbacks: {
					title: function(tooltipItems, data) {
						//Return value for title
						return moment((tooltipItems[0].xLabel * 1000)).format('lll');
					},
					label: function (item, data) {
						var datasetLabel = data.datasets[item.datasetIndex].label || "";
						var dataPoint = item.yLabel;
						var label = data.labels[item.index];
						return " Active: " + dataPoint; // + " @ " + label;
					}
				},
				itemSort: function(a, b) {
					return b.datasetIndex - a.datasetIndex
				}
			},
			responsive: true,
			maintainAspectRatio : false,
			scales: {
				xAxes: [{
					scaleLabel: {
						display: false,
					},
					ticks : {
						beginAtZero: true,
						fontColor: "white",
						display: false
					},
					gridLines: {
						display: false,
					},
				}],
				yAxes: [{
					scaleLabel: {
						display: false,
						labelString: 'Usage'
					},
					gridLines: {
						display: true,
					},
					ticks: {
						beginAtZero: true,
						fontColor: "white",
						display: false
					}
				}]
			}
		}
	}
}
function bindSessionChart(data, canvas) {
	var config = buildSessionChartConfig(buildSessionChartData(data));
	var ctx = document.getElementById(canvas).getContext('2d');
	var chart = new Chart(ctx, config);
}

function buildUsageChartData(data) {

	if (typeof data === "undefined") { console.debug("UsageChart data null"); return; }

	var name = [];
	var upload = [];
	var download = [];

	for (var i in data) {
		if (localStorage.getItem('remember.chart.usage.period') === 'T') name.push(curTime(data[i].period));
		else if (localStorage.getItem('remember.chart.usage.period') === 'M') name.push(curDay(data[i].period));
		else name.push(data[i].period);

		upload.push((data[i].uploaded === undefined) ? 0 : data[i].uploaded);
		download.push((data[i].downloaded === undefined) ? 0 : data[i].downloaded);
	}

	return {
		labels: name,
		datasets: [{
			label: 'Uploaded',
			backgroundColor: "#6f42c1",
			data: upload
		}, {
			label: 'Downloaded',
			backgroundColor: "#fd7e14",
			data: download
		}]
	};
}
function buildUsageChartConfig(data) {
	return {
		type: 'bar',
		data: data,
		options: {
			title: {
				display: false
			},
			legend: {
				display: false
			},
			tooltips: {
				mode: 'index',
				intersect: false,
				callbacks: {
					title: function () {
						return "";
					},
					label: function (item, data) {
						var datasetLabel = data.datasets[item.datasetIndex].label || "";
						var dataPoint = item.yLabel;
						var label = data.labels[item.index];

						if (localStorage.getItem('remember.chart.usage.period') === 'T') return " " + datasetLabel + ": " + bytes(dataPoint, true) + " @ " + label;
						if (localStorage.getItem('remember.chart.usage.period') === 'W') return " " + datasetLabel + ": " + bytes(dataPoint, true) + " on " + label;
						if (localStorage.getItem('remember.chart.usage.period') === 'M') return " " + datasetLabel + ": " + bytes(dataPoint, true) + " on the " + label;
					}
				},
				itemSort: function(a, b) {
					return b.datasetIndex - a.datasetIndex
				}
			},
			responsive: true,
			maintainAspectRatio : false,
			scales: {
				xAxes: [{
					scaleLabel: {
						display: false,
					},
					ticks : {
						beginAtZero: true,
						fontColor: "black"
					},
					gridLines: {
						display: false,
					},
					stacked: true
				}],
				yAxes: [{
					scaleLabel: {
						display: false,
						labelString: 'Usage'
					},
					gridLines: {
						display: true,
					},
					stacked: true,
					ticks: {
						beginAtZero: true,
						fontColor: "black",
						callback: function (data, index, labels) {
							return bytes(data, true);
						}
					}
				}]
			}
		}
	}
}
function bindUsageChart(data, canvas) {
	/*Chart.plugins.register({
		afterDraw: function(chart) {
			if (chart.data.datasets.length === 0) {
				// No data is present
				var ctx = chart.chart.ctx;
				var width = chart.chart.width;
				var height = chart.chart.height
				chart.clear();

				ctx.save();
				ctx.textAlign = 'center';
				ctx.textBaseline = 'middle';
				ctx.font = "16px normal 'Helvetica Nueue'";
				ctx.fillText('No data to display', width / 2, height / 2);
				ctx.restore();
			}
		}
	});*/
	var config = buildUsageChartConfig(buildUsageChartData(data));
	var ctx = document.getElementById(canvas).getContext('2d');
	var usageChart = new Chart(ctx, config);
}

function buildAuthChartData(data) {

	if (typeof data === "undefined") { console.debug("AuthChart data null"); return; }

	var name = [];
	var reject = [];
	var accept = [];

	for (var i in data) {
		if (localStorage.getItem('remember.chart.auth.period') === 'T') name.push(curTime(data[i].period));
		else if (localStorage.getItem('remember.chart.auth.period') === 'M') name.push(curDay(data[i].period));
		else name.push(data[i].period);

		reject.push(data[i].reject);
		accept.push(data[i].accept);
	}

	return {
		labels: name,
		datasets: [{
			label: 'Rejected',
			backgroundColor: "#dc3545",
			data: reject
		}, {
			label: 'Accepted',
			backgroundColor: "#28a745",
			data: accept
		}]
	};
}
function buildAuthChartConfig(data) {
	return {
		type: 'bar',
		data: data,
		options: {
			title: {
				display: false
			},
			legend: {
				display: false
			},
			tooltips: {
				mode: 'index',
				intersect: false,
				callbacks: {
					title: function(tooltipItems, data) {
						//Return value for title
						return "";
						return tooltipItems[0].xLabel;
					},
					label: function (item, data) {
						var datasetLabel = data.datasets[item.datasetIndex].label || "";
						var dataPoint = item.yLabel;
						var label = data.labels[item.index];

						if (localStorage.getItem('remember.chart.usage.period') === 'T') return " " + datasetLabel + ": " + bytes(dataPoint, true) + " @ " + label;
						if (localStorage.getItem('remember.chart.usage.period') === 'W') return " " + datasetLabel + ": " + bytes(dataPoint, true) + " on " + label;
						if (localStorage.getItem('remember.chart.usage.period') === 'M') return " " + datasetLabel + ": " + bytes(dataPoint, true) + " on the " + label;
					}
				},
				itemSort: function(a, b) {
					return b.datasetIndex - a.datasetIndex
				}
			},
			responsive: true,
			maintainAspectRatio : false,
			scales: {
				xAxes: [{
					scaleLabel: {
						display: false,
					},
					ticks : {
						beginAtZero: true,
						fontColor: "black"
					},
					gridLines: {
						display: false,
					},
					stacked: true
				}],
				yAxes: [{
					scaleLabel: {
						display: false,
						labelString: 'Usage'
					},
					gridLines: {
						display: true,
					},
					stacked: true,
					ticks: {
						beginAtZero: true,
						stepSize: 1000,
						callback: function (data, index, labels) {
							return data;
						},
						fontColor: "black"
					}
				}]
			}
		}
	}
}
function bindAuthChart(data, canvas) {
	var config = buildAuthChartConfig(buildAuthChartData(data));
	var ctx = document.getElementById(canvas).getContext('2d');
	var usageChart = new Chart(ctx, config);
}

function getChartUsage(period, url, interval){
	if (period === 'T') { cChart = 'today-chart-canvas'; }
	if (period === 'W') { cChart = 'thisweek-chart-canvas'; }
	if (period === 'M') { cChart = 'thismonth-chart-canvas'; }
	$('#' + cChart).replaceWith($('<canvas id="' + cChart + '" height="300" style="height: 300px;"></canvas>'));

	localStorage.setItem('remember.chart.usage.period', period);
	localStorage.setItem('remember.chart.usage.url', url);

	$.ajax({
		url: url,
		type : 'GET',
		data : {'period' : period},
		dataType : 'json',
		beforeSend: function() { $("#lUChart").show(); $("#rStats").hide(); },
		complete: function() { $('#lUChart').hide(); $("#rStats").show();
		},
		success: function (data) {
			console.log('success : ' + JSON.stringify(data));

			cDownloaded = bytes(data['count']['downloaded'], true);
			cUploaded = bytes(data['count']['uploaded'], true);

			$("#rDownload").html('Downloaded [ ' + cDownloaded + ' ]');
			$("#rUpload").html('Uploaded [ ' + cUploaded + ' ]');

			bindUsageChart(data['chartdata'], cChart);

			if (interval === undefined) return;
			if (interval > 0) {
				clearInterval(interval);
				interval = setInterval(function () {
					getChartUsage(localStorage.getItem('remember.chart.usage.period'),localStorage.getItem('remember.chart.usage.url'), interval);
				}, interval);
			}
		},
		error: function(data) {
console.log('error : ' + data);
			var responseText=JSON.stringify(data);
			alert(responseText);
		}
	});
}
function getActiveSessions(period, interval) {
	$.ajax({
		url : './data/getStat.php',
		type : 'GET',
		data : {'action' : 'getSessionCount'},
		dataType : 'json',
		beforeSend: function() { $("#lASession").show(); },
		complete: function() { $('#lASession').hide(); },
		success: function (data) {
			if (typeof data === "undefined") { console.debug("Active sessions count data null"); return; }

			rsltActive = (data != null) ? data['active'] : "0";
			rsltTotal = (data != null) ? data['total'] : "0";
			$("#rASession").html(rsltActive + ' / ' + rsltTotal);

			if (interval > 0) {
				clearInterval(activeSessionInterval);
				activeSessionInterval = setInterval(function () {
					getActiveSessions(null, interval);
				}, interval);
			}
		},
		error: function(data) {
			//console.log(data);
			var responseText=JSON.parse(data);
			alert("Error(s) while building the ZIP file:\n");
		}
	});
}
function getAlerts(period, interval) {
	$.ajax({
		url : './data/getStat.php',
		type : 'GET',
		data : {'action' : 'getAlertCount'},
		dataType : 'json',
		beforeSend: function() { $("#lAlerts").show(); },
		complete: function() { $('#lAlerts').hide(); },
		success: function (data) {
			if (typeof data === "undefined") { console.debug("Alert count data null"); return; }

			rsltTotal = (data != null) ? data['total'] : "0";
			$("#rAlerts").html(rsltTotal);

			if (interval > 0) {
				clearInterval(alertInterval);
				alertInterval = setInterval(function () {
					getAlerts(null, interval);
				}, interval);
			}
		},
		error: function(data) {
//console.log(data);
			var responseText=JSON.parse(data);
			alert("Error(s) while building the ZIP file:\n");
		},
	});
}
function getIPCount(period, interval) {
	$.ajax({
		url : './data/getStat.php',
		type : 'GET',
		data : {'action' : 'getIPCount'},
		dataType : 'json',
		beforeSend: function() { $("#lIP").show(); },
		complete: function() { $('#lIP').hide(); },
		success: function (data) {
			if (typeof data === "undefined") { console.debug("IP count data null"); return; }

			rsltIPfree = (data != null) ? data['used'] : "0";
			rsltIPtotal = (data != null) ? data['total'] : "0";
			$("#rIP").html(rsltIPfree + ' / ' + rsltIPtotal);

			if (interval > 0) {
				clearInterval(activeIPInterval);
				activeIPInterval = setInterval(function () {
					getIPCount(null, interval);
				}, interval);
			}
		},
		error: function(data) {
//console.log(data);
			var responseText=JSON.parse(data);
			alert("Error(s) while building the ZIP file:\n");
		}
	});
}
function getCustomerCount(period, interval) {
	$.ajax({
		url : './data/getStat.php',
		type : 'GET',
		data : {'action' : 'getCustomerCount'},
		dataType : 'json',
		beforeSend: function() { $("#lCustomers").show(); },
		complete: function() { $('#lCustomers').hide(); },
		success: function (data) {
			if (typeof data === "undefined") { console.debug("Customer count data null"); return; }

			rsltActive = (data != null) ? data['active'] : "0";
			rsltTotal = (data != null) ? data['total'] : "0";
			$("#rCustomers").html(rsltTotal);

			if (interval > 0) {
				clearInterval(customerInterval);
				customerInterval = setInterval(function () {
					getCustomerCount(null, interval);
				}, interval);
			}
		},
		error: function(data) {
//console.log(data);
			var responseText=JSON.parse(data);
			alert("Error(s) while building the ZIP file:\n");
		}
	});
}
function getChartAuth(period, url, interval) {
	if (period === 'T') {
		cAChart = 'today-authchart-canvas';
	}
	if (period === 'W') {
		cAChart = 'thisweek-authchart-canvas';
	}
	if (period === 'M') {
		cAChart = 'thismonth-authchart-canvas';
	}
	$('#' + cAChart).replaceWith($('<canvas id="' + cAChart + '" height="300" style="height: 300px;"></canvas>'));

	localStorage.setItem('remember.chart.auth.period', period);
	localStorage.setItem('remember.chart.auth.url', url);


	$.ajax({
		url: url,
		type: 'GET',
		data: {'period': period},
		dataType: 'json',
		beforeSend: function () {
			$("#lUAChart").show();
			$("#rAStats").hide();
		},
		complete: function () {
			$('#lUAChart').hide();
			$("#rAStats").show();
		},
		success: function (data) {
			if (typeof data === "undefined") { console.debug("ChartAuth data null"); return; }

			cADownloaded = data['count']['accepted'];
			cAUploaded = data['count']['rejected'];

			$("#rADownload").html('Accepted [ ' + cADownloaded + ' ]');
			$("#rAUpload").html('Rejected [ ' + cAUploaded + ' ]');

			bindAuthChart(data['chartdata'], cAChart);


			if (interval > 0) {
				clearInterval(chartAuthInterval);
				chartAuthInterval = setInterval(function () {
					getChartAuth(localStorage.getItem('remember.chart.auth.period'), interval);
				}, interval);
			}
		},
		error: function(data) {
			console.log(data);
			alert("ErrorChartAuth:" + data);
		}
	});
}
function getChartSession(interval){
	$.ajax({
		url : './data/getStat.php',
		type : 'GET',
		data : {'action' : 'getChartSessionData'},
		dataType : 'json',
		beforeSend: function() { $("#lSChart").show(); },
		complete: function() { $('#lSChart').hide(); },
		success: function (data) {
			if (typeof data === "undefined") { console.debug("SessionChart data null"); return; }

			bindSessionChart(data['chartdata'], 'line-chart-canvas');

			if (interval > 0) {
				clearInterval(chartSessionInterval);
				chartSessionInterval = setInterval(function () {
					getChartSession(interval);
				}, interval);
			}
		},
		error: function(data) {
//console.log(data);
			alert(data);
		}
	});
}


$.fn.enterKey = function (fnc) {
	return this.each(function () {
		$(this).keypress(function (ev) {
			var keycode = (ev.keyCode ? ev.keyCode : ev.which);
			if (keycode == '13') {
				fnc.call(this, ev);
			}
		})
	})
}

/*$('form input').keydown(function (e) {
	if (e.keyCode == 13) {
		var inputs = $(this).parents("form").eq(0).find(":input");
		if (inputs[inputs.index(this) + 1] != null) {
			inputs[inputs.index(this) + 1].focus();
		}
		e.preventDefault();
		return false;
	}
});*/

function initMap1(map, gps, readonly = false, options = null) {
	// The location of Uluru
	var myLatlng = new google.maps.LatLng(-34.397, 150.644);
	// The map, centered at Uluru
	var gmap = new google.maps.Map(document.getElementById(map), {zoom: 8, center: myLatlng, styles: [
			{elementType: 'geometry', stylers: [{color: '#242f3e'}]},
			{elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
			{elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
			{
				featureType: 'administrative.locality',
				elementType: 'labels.text.fill',
				stylers: [{color: '#d59563'}]
			},
			{
				featureType: 'poi',
				elementType: 'labels.text.fill',
				stylers: [{color: '#d59563'}]
			},
			{
				featureType: 'poi.park',
				elementType: 'geometry',
				stylers: [{color: '#263c3f'}]
			},
			{
				featureType: 'poi.park',
				elementType: 'labels.text.fill',
				stylers: [{color: '#6b9a76'}]
			},
			{
				featureType: 'road',
				elementType: 'geometry',
				stylers: [{color: '#38414e'}]
			},
			{
				featureType: 'road',
				elementType: 'geometry.stroke',
				stylers: [{color: '#212a37'}]
			},
			{
				featureType: 'road',
				elementType: 'labels.text.fill',
				stylers: [{color: '#9ca5b3'}]
			},
			{
				featureType: 'road.highway',
				elementType: 'geometry',
				stylers: [{color: '#746855'}]
			},
			{
				featureType: 'road.highway',
				elementType: 'geometry.stroke',
				stylers: [{color: '#1f2835'}]
			},
			{
				featureType: 'road.highway',
				elementType: 'labels.text.fill',
				stylers: [{color: '#f3d19c'}]
			},
			{
				featureType: 'transit',
				elementType: 'geometry',
				stylers: [{color: '#2f3948'}]
			},
			{
				featureType: 'transit.station',
				elementType: 'labels.text.fill',
				stylers: [{color: '#d59563'}]
			},
			{
				featureType: 'water',
				elementType: 'geometry',
				stylers: [{color: '#17263c'}]
			},
			{
				featureType: 'water',
				elementType: 'labels.text.fill',
				stylers: [{color: '#515c6d'}]
			},
			{
				featureType: 'water',
				elementType: 'labels.text.stroke',
				stylers: [{color: '#17263c'}]
			}
		]});
	// The marker, positioned at Uluru
	var gmarker = new google.maps.Marker({position: myLatlng, map: gmap});

	var geocoder = new google.maps.Geocoder;
	var infowindow = new google.maps.InfoWindow;

	document.getElementById('submitBtn').addEventListener('click', function() {
		geocodeAddress(geocoder, gmap);
		geocodePlaceId(geocoder, gmap, infowindow);
		geocodeLatLng(geocoder, gmap, infowindow);
	});
}
function geocodeAddress(geocoder, resultsMap) {
	var address = document.getElementById('address').value;
	geocoder.geocode({componentRestrictions: {
			country: 'AU',
			postalCode: '2000'
		}, 'address': address}, function(results, status) {
		if (status === 'OK') {
			resultsMap.setCenter(results[0].geometry.location);
			var marker = new google.maps.Marker({
				map: resultsMap,
				position: results[0].geometry.location
			});
		} else {
			alert('Geocode was not successful for the following reason: ' + status);
		}
	});
}
function geocodeLatLng(geocoder, map, infowindow) {
	var input = document.getElementById('latlng').value;
	var latlngStr = input.split(',', 2);
	var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
	geocoder.geocode({'location': latlng}, function(results, status) {
		if (status === 'OK') {
			if (results[0]) {
				map.setZoom(11);
				var marker = new google.maps.Marker({
					position: latlng,
					map: map
				});
				infowindow.setContent(results[0].formatted_address);
				infowindow.open(map, marker);
			} else {
				window.alert('No results found');
			}
		} else {
			window.alert('Geocoder failed due to: ' + status);
		}
	});
}
function geocodePlaceId(geocoder, map, infowindow) {
	var placeId = document.getElementById('place-id').value;
	geocoder.geocode({'placeId': placeId}, function(results, status) {
		if (status === 'OK') {
			if (results[0]) {
				map.setZoom(11);
				map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location
				});
				infowindow.setContent(results[0].formatted_address);
				infowindow.open(map, marker);
			} else {
				window.alert('No results found');
			}
		} else {
			window.alert('Geocoder failed due to: ' + status);
		}
	});
}


function initAutocomplete_() {
	var placeSearch, autocomplete;

	// Create the autocomplete object, restricting the search predictions to
	// geographical location types.
	autocomplete = new google.maps.places.Autocomplete(
		document.getElementById('autocomplete'), {types: ['geocode']});

	// Avoid paying for data that you don't need by restricting the set of
	// place fields that are returned to just the address components.
	autocomplete.setFields(['address_component']);

	// When the user selects an address from the drop-down, populate the
	// address fields in the form.
	autocomplete.addListener('place_changed', fillInAddress);
}
function fillInAddress_() {
	/*var componentForm = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		postal_code: 'short_name'
	};*/

	// Get the place details from the autocomplete object.
	var place = autocomplete.getPlace();

	for (var component in componentForm) {
		document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
	}

	// Get each component of the address from the place details,
	// and then fill-in the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType]) {
			var val = place.address_components[i][componentForm[addressType]];
			document.getElementById(addressType).value = val;
		}
	}
}
function geolocate_() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};
			var circle = new google.maps.Circle(
				{center: geolocation, radius: position.coords.accuracy});
			autocomplete.setBounds(circle.getBounds());
		});
	}
}

function initMap111() {
	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -33.8688, lng: 151.2195},
		zoom: 13
	});
	var card = document.getElementById('pac-card');
	var input = document.getElementById('pac-input');
	var types = document.getElementById('type-selector');
	var strictBounds = document.getElementById('strict-bounds-selector');

	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

	var autocomplete = new google.maps.places.Autocomplete(input);

	// Bind the map's bounds (viewport) property to the autocomplete object,
	// so that the autocomplete requests use the current map bounds for the
	// bounds option in the request.
	autocomplete.bindTo('bounds', map);

	// Set the data fields to return when the user selects a place.
	autocomplete.setFields(
		['address_components', 'geometry', 'icon', 'name']);

	var infowindow = new google.maps.InfoWindow();
	var infowindowContent = document.getElementById('infowindow-content');
	infowindow.setContent(infowindowContent);
	var marker = new google.maps.Marker({
		map: map,
		anchorPoint: new google.maps.Point(0, -29)
	});

	autocomplete.addListener('place_changed', function() {
		infowindow.close();
		marker.setVisible(false);
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			window.alert("No details available for input: '" + place.name + "'");
			return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(17);  // Why 17? Because it looks good.
		}
		marker.setPosition(place.geometry.location);
		marker.setVisible(true);

		var address = '';
		if (place.address_components) {
			address = [
				(place.address_components[0] && place.address_components[0].short_name || ''),
				(place.address_components[1] && place.address_components[1].short_name || ''),
				(place.address_components[2] && place.address_components[2].short_name || '')
			].join(' ');
		}

		infowindowContent.children['place-icon'].src = place.icon;
		infowindowContent.children['place-name'].textContent = place.name;
		infowindowContent.children['place-address'].textContent = address;
		infowindow.open(map, marker);
	});

	// Sets a listener on a radio button to change the filter type on Places
	// Autocomplete.
	function setupClickListener(id, types) {
		var radioButton = document.getElementById(id);
		radioButton.addEventListener('click', function() {
			autocomplete.setTypes(types);
		});
	}

	setupClickListener('changetype-all', []);
	setupClickListener('changetype-address', ['address']);
	setupClickListener('changetype-establishment', ['establishment']);
	setupClickListener('changetype-geocode', ['geocode']);

	document.getElementById('use-strict-bounds')
		.addEventListener('click', function() {
			console.log('Checkbox clicked! New state=' + this.checked);
			autocomplete.setOptions({strictBounds: this.checked});
		});
}

function buildPathGoogleMap(map, gps1, gps2) {

	if (map == null || map == "" || gps1 == null || gps1 == "" || gps2 == null || gps2 == "") return;

	let lat1, lng1, lat2, lng2;
	let mapCanvas = document.getElementById(map);

	if (IsValidGPS(gps1)) {
		lat1 = parseFloat(gps1.split(',', 2)[0]);
		lng1 = parseFloat(gps1.split(',', 2)[1]);
	}
	if (IsValidGPS(gps2)) {
		lat2 = parseFloat(gps2.split(',', 2)[0]);
		lng2 = parseFloat(gps2.split(',', 2)[1]);
	}

	let gmap = new google.maps.Map(mapCanvas, {
		zoom: 11,
		center: {lat: lat1 + 0.046, lng: lng1 - 0.020 },
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	});
	let losCoordinates = [
		{lat: lat1, lng: lng1},
		{lat: lat2, lng: lng2}
	];
	let losCoordinatesPath = new google.maps.Polyline({
		path: losCoordinates,
		geodesic: false,
		strokeColor: '#ff851b',
		strokeOpacity: 1.0,
		strokeWeight: 1
	});
// test
	var gmarker = new google.maps.Marker({
		position: latLng,
		title:"Hello World!"
	});
	gmarker.setMap(gmap);

	losCoordinatesPath.setMap(gmap);
}
function buildMarkerGoogleMap(map, gps) {

	if (map == null || map == "" || gps == null || gps == "") return;

	let lat, lng;
	let mapCanvas = document.getElementById(map);

	if (IsValidGPS(gps)) {
		lat = parseFloat(gps.split(',', 2)[0]);
		lng = parseFloat(gps.split(',', 2)[1]);
	}

	var latLng = new google.maps.LatLng(lat, lng);
	var gmap = new google.maps.Map(mapCanvas, {
		zoom: 11,
		center: latLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	});
	var gmarker = new google.maps.Marker({
		position: latLng,
		title:"Hello World!"
	});

	gmarker.setMap(gmap);
}

function drawPathGoogleMap(map, gps1, gps2) {

	let lat1, lng1, lat2, lng2;

	if (IsValidGPS(gps1)) {
		lat1 = parseFloat(gps1.split(',')[0]);
		lng1 = parseFloat(gps1.split(',')[1]);
	}
	if (IsValidGPS(gps2)) {
		lat2 = parseFloat(gps2.split(',')[0]);
		lng2 = parseFloat(gps2.split(',')[1]);
	}

	let mapCanvas = document.getElementById(map);

	let latLng = new google.maps.LatLng(lat1, lng1);

	let gmap = new google.maps.Map(mapCanvas, {
		zoom: 11,
		center: latLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	});

	let iconBase = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/';
	let icons = {
		parking: {
			icon: iconBase + 'parking_lot_maps.png'
		},
		library: {
			icon: iconBase + 'library_maps.png'
		},
		info: {
			icon: iconBase + 'info-i_maps.png'
		}
	};
	let gmarker = new google.maps.Marker({
		position: latLng,
		icon: icons.library.icon,
		label: "",
		title:"Hello World!"
	});
	gmarker.setMap(gmap);


	let losCoordinates = [
		{lat: lat1, lng: lng1},
		{lat: lat2, lng: lng2}
	];
	let losCoordinatesPath = new google.maps.Polyline({
		path: losCoordinates,
		geodesic: false,
		strokeColor: '#ff851b',
		strokeOpacity: 1.0,
		strokeWeight: 1
	});
	losCoordinatesPath.setMap(gmap);
}
function drawMarkerGoogleMap(map, gps) {
	let lat1, lng1, lat2, lng2;
	if (IsValidGPS(gps1)) {
		lat1 = parseFloat(gps.split(',')[0]);
		lng1 = parseFloat(gps.split(',')[1]);
	}
	var latLng = new google.maps.LatLng(lat, lng);
	gmap.center = latLng;

	var gmarker = new google.maps.Marker({
		position: latLng,
		title:"Hello World!"
	});
	gmarker.setMap(gmap);
}

function initMap11() {
	var map = new google.maps.Map(document.getElementById('google-map'), {
		zoom: 3,
		center: {lat: 0, lng: -180},
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	});

	var flightPlanCoordinates = [
		{lat: -34.145925, lng: 18.865297},
		{lat: -34.0556972, lng: 18.8206144}
	];
	var flightPath = new google.maps.Polyline({
		path: flightPlanCoordinates,
		geodesic: false,
		strokeColor: '#FF0000',
		strokeOpacity: 1.0,
		strokeWeight: 2
	});

	flightPath.setMap(map);
}


var map;
var service;
var infowindow;

function initMap() {
	var sydney = new google.maps.LatLng(-33.867, 151.195);

	infowindow = new google.maps.InfoWindow();

	map = new google.maps.Map(
		document.getElementById('google-map'), {center: sydney, zoom: 15});

	var request = {
		query: 'Museum of Contemporary Art Australia',
		fields: ['name', 'geometry'],
	};

	var service = new google.maps.places.PlacesService(map);

	service.findPlaceFromQuery(request, function(results, status) {
		if (status === google.maps.places.PlacesServiceStatus.OK) {
			for (var i = 0; i < results.length; i++) {
				//createMarker(results[i]);
			}
			map.setCenter(results[0].geometry.location);
		}
	});
}


function buildGoogleMap(map, gps, readonly = false, options = null) {

	if (map == null || map === '') return;
	if (document.getElementById(map) == null) return;

	//if (debug) console.log('Building Map ' + map);

	let contact_map, contact_marker, lat, lng, zoom = 18;

	if (gps != null && gps !== '' && gps !== "" && IsValidGPS(gps)) {
		lat = parseFloat(gps.split(',')[0]);
		lng = parseFloat(gps.split(',')[1]);
	} else {
		lat = parseFloat("0");
		lng = parseFloat("0");
		zoom = 2;
	}

	//if (debug) console.log('Parsing GPS Co-ordinates ' + lat + ',' + lng);

	let latlng = new google.maps.LatLng(lat, lng);

	contact_map = new google.maps.Map(document.getElementById(map), {
		center: latlng,
		zoom: zoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		fullscreenControl: false,
		streetViewControl: false,
		disableDefaultUI: true,
		draggable: !readonly,
		zoomControl: !readonly,
		scrollwheel: !readonly,
		disableDoubleClickZoom: readonly,
		clickableIcons: !readonly
	});
	contact_marker = new google.maps.Marker({
		position: latlng,
		map: contact_map,
		draggable: !readonly,
		clickable: !readonly
	});

	google.maps.event.addListenerOnce(contact_map, "idle", function () {
		//if (debug) console.log('Listener Idle ' + map);

		google.maps.event.trigger(contact_map, "resize");
		contact_map.setZoom(contact_map.getZoom());
	});
	google.maps.event.addListener(contact_marker, 'mouseup', function () {
		//if (debug) console.log('Listener Mouse Up ' + map);

		if (options != null && options.output !== undefined) {
			var gpsstr = contact_marker.getPosition();
			document.getElementById(options.output).value = gpsstr.toString().substring(1,gpsstr.toString().length-1);
			//document.getElementById(options.outputgrp).ele .show();
			//document.getElementById(options.output).trigger('change');
			//if (debug) console.log('Listener Mouse Up ' + map + ' output.value ' + document.getElementById(options.output).value);
		}

	});

	if (options != null && options.input !== undefined) {

		try {
			let input = document.getElementById(options.input);
			let autocomplete = new google.maps.places.Autocomplete(input);

			autocomplete.setTypes([]);
			autocomplete.bindTo('bounds', contact_map);
			autocomplete.setOptions({strictBounds: true});
			if (options.country !== undefined) {
				//if (debug) console.log('Setting Restrictions ' + map + ' output.country ' + options.country);

				autocomplete.setComponentRestrictions({'country': options.country});
			}
			autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);
			autocomplete.addListener('place_changed', function () {
				//if (debug) console.log('Listener Place Changed ' + map);

				let place = autocomplete.getPlace();

				if (!place.geometry) return;

				if (place.geometry.viewport) {
					//if (debug) console.log('Listener Place Changed ' + map + ' viewport ' + place.geometry.viewport);

					contact_map.fitBounds(place.geometry.viewport);
					contact_marker.setPosition(place.geometry.location);
					document.getElementById(options.output).value = place.geometry.location.toString().substring(1, place.geometry.location.toString().length - 1);

				} else {
					//if (debug) console.log('Listener Place Changed ' + map + ' location ' + place.geometry.location);

					contact_marker.setPosition(place.geometry.location);
					contact_map.setCenter(place.geometry.location);
					contact_map.setZoom(zoom);
					document.getElementById(options.output).value = place.geometry.location.toString().substring(1, place.geometry.location.toString().length - 1);

				}

				if (options.output !== undefined) {
					//document.getElementById(options.output).value = contact_marker.getPosition();
					//if (debug) console.log('Listener Place Changed ' + map + ' output.value ' + document.getElementById(options.output).value);
				}

				//contact_marker.setPosition(place.geometry.location);

				// Get the place details from the autocomplete object.

				for (const component in componentForm) {
					console.log(component);
					document.getElementById(component).value = "";
					document.getElementById(component).disabled = false;
				}

				// Get each component of the address from the place details,
				// and then fill-in the corresponding field on the form.
				for (const component of place.address_components) {
					const addressType = component.types[0];

					if (componentForm[addressType]) {
						const val = component[componentForm[addressType]];
						document.getElementById(addressType).value = val;
					}
				}
			});
		} catch (e) {

		}
	}
	if (options != null && options.location !== undefined) {

		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({'address': options.location}, function (results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				//contact_map.setCenter(results[0].geometry.location);
				contact_map.setCenter(latlng);
			} else {
				//showErrorAlert("Could not find location: " + options.location);
			}
		});
	}

	document.getElementById(map).map = contact_map;
	document.getElementById(map).marker = contact_marker;
}


function bytes(bytes, label, decimal = 1) {
	if (bytes == 0) return '0 B';
	let s = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
	let e = Math.floor(Math.log(bytes)/Math.log(1024));
	let value = ((bytes/Math.pow(1024, Math.floor(e))).toFixed(decimal));
	e = (e < 0) ? (-e) : e;
	if (label) value += ' ' + s[e];
	return value;
}

function realmCheck(email) {
	let parts = email.split('@');
	if (parts.length === 2) {
		if (parts[1].length > 0) {
			return true;
		}
	}
	return false;
}
function removeNL(s) {
	r = "";
	for (i=0; i < s.length; i++) {
		if (s.charAt(i) != '\n' &&
			s.charAt(i) != '\r' &&
			s.charAt(i) != '\t') {
			r += s.charAt(i);
		} else {
			r += ' ';
		}
	}
	return r;
}

function IsValidGPS(input) {

	if (/([+-]?\d+\.?\d+)\s*,\s*([+-]?\d+\.?\d+)/.test(input.trim())) {
		return true
	}
	return  false
}
function IsValidGPSLatLon(lat, lon) {

	let validLat = /^(-?[1-8]?\d(?:\.\d{1,18})?|90(?:\.0{1,18})?)$/.test(lat.trim());
	let validLon = /^(-?(?:1[0-7]|[1-9])?\d(?:\.\d{1,18})?|180(?:\.0{1,18})?)$/.test(lon.trim());

	if (validLat && validLon) {
		return true
	}

	alert("You have entered an invalid GPS co-ordinate!")
	return  false
}
function IsValidIPAddress(input) {
	if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(input.trim())) {
		return true
	}

	alert("You have entered an invalid IP address!")
	return false
}
function IsValidEmail(input) {
	if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(input.trim())) {
		return true
	}

	alert("You have entered an invalid email address!")
	return false
}


function generatePassword(passwordLength) {
	var numberChars = "0123456789";
	var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var lowerChars = "abcdefghijklmnopqrstuvwxyz";
	var allChars = numberChars + upperChars + lowerChars;
	var randPasswordArray = Array(passwordLength);
	randPasswordArray[0] = numberChars;
	randPasswordArray[1] = upperChars;
	randPasswordArray[2] = lowerChars;
	randPasswordArray = randPasswordArray.fill(allChars, 3);
	return shuffleArray(randPasswordArray.map(function(x) { return x[Math.floor(Math.random() * x.length)] })).join('');
}

function shuffleArray(array) {
	for (var i = array.length - 1; i > 0; i--) {
		var j = Math.floor(Math.random() * (i + 1));
		var temp = array[i];
		array[i] = array[j];
		array[j] = temp;
	}
	return array;
}

