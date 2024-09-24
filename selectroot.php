<?php
session_start();

// Assuming usertype is stored in session or fetched from the database
// Example: $_SESSION['usertype'] = 'counter';
$usertype = $_SESSION['usertype'] ?? '';




?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<!--Boostrap CDN-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<script src=" 	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />


	<!-- Bootstrap 5 JS (optional) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->


	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- jQuery (required by Bootstrap 5 Datepicker) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Bootstrap Datepicker CSS -->
	<!-- <link rel="stylesheet"
		href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"> -->

	<!-- Bootstrap Datepicker JS -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script> -->

	<!-- Optionally, include Bootstrap icons for the calendar icon -->
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> -->


	<!-- Select2 JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
	<link rel="stylesheet" href="locationImg.css">


	<style>
		body {
			overflow-y: auto;
			scrollbar-width: none;
		}

		html {
			scrollbar-width: none;
		}

		.combo-style {
			background-color: #585858;
			border: none;
		}

		a {
			text-decoration: none;
		}
	</style>

</head>

<body style="background-color:#0c2d3b">
	<?php
	$usertype = "counter";
	if ($usertype = 'counter') {
		echo "<script>console.log('$usertype')</script>";
		echo '
		<!-- Navbar only for counter users -->
		<nav class="navbar navbar-expand-sm navbar-light bg-dark">
			<div class="container-fluid">
				<a class="navbar-brand" href="#"><img src="gallery/logo.png" height="40px" width="40px"></a>
				<div class="navbar-collapse">
					<p style="color:aqua; font-family:Lona BC; font-size: 24px;">EzBus</p>
				</div>
			</div>
		</nav>

		<!-- Image card section only for counter users -->
		<div class="bg-image card shadow-1-strong" style="background-image: url(\'gallery/highway2.png\'); height: 400px;">
			<div class="card-body text-white">
				<h5 class="card-title">Card title</h5>
				<p class="card-text">
					Some quick example text to build on the card title and make up
					the bulk of the card\'s content.
				</p>
			</div>
		</div>
	';
	}
	?>

	<!-- Date Button Section -->
	<div class="d-flex align-items-end container-fluid " style="background: rgba(19, 19, 19, 0.5); height: 85px;">


		<!-- Search root from-->
		<div class="container d-flex col-6 justify-content-end collapse">
			<!-- Date picker ----------------------------------------------------->
			<div class="form-group mt-4 col-4 mb-3">
				<label for="date" style="color:white;">Choose Date:</label>
				<div class="input-group date" id="datepicker">
					<input type="Date" class="form-control " placeholder="Select a date" id="dateInput">
					<!-- <span class="input-group-append">
							<span class="input-group-text bg-light border"><i class="bi bi-calendar3"></i></span>
						</span> -->
				</div>
			</div>

			<!-- Select from city ------------------------------------------->

			<div class="container mt-4 col-4 mb-3 ">
				<label for="selectFrom" class="form-label" style="color: white;">From:</label>
				<select id="selectFrom" class="form-select ">
					<option value="" disabled selected>Select an option</option>
					<option value="All">All</option>
				</select>
			</div>

			<!-- Select To city -------------------------------------------------->
			<!-- Search root To-->
			<div class="container  mt-4 col-4 mb-3">
				<label for="selectTo" class="form-label" style="color: white;">To:</label>
				<select id="selectTo" class="form-select ">
					<option value="" disabled selected>Select an option</option>
					<option value="All">All</option>

				</select>
			</div>

			<!-- Search button ----------------------------------------------------------->
			<div class="mt-5">
				<button type="button" class="btn btn-info" id="btn">Search</button>
			</div>
		</div>
	</div>

	</div>

	<!-- Shedule table ------------------------------------------------------------------>
	<div class="container">
		<div>
			<table id="sheduleTable" class="table table-success table-striped table-light table-hover mt-4">
				<thead class="tableColor">
					<tr class="tableColor">
						<th class="tableColor" style="background-color:#ffd76c">From</th>
						<th scope="col" style="background-color:#ffd76c">To</th>
						<th scope="col" style="background-color:#ffd76c">Time</th>
						<th scope="col" style="background-color:#ffd76c">Seat Count</th>
						<th scope="col" style="background-color:#ffd76c">Ticket Price</th>
						<th scope="col" style="background-color:#ffd76c">Get Tickets</th>
					</tr>
				</thead>
				<tbody>

				</tbody>

			</table>
		</div>



		<div id="result" class="tableColor"></div>

	</div>


	<script type="text/javascript">
		// -----------------------------Function to add a new option---------------------------------------------
		function addOption(id, value, text) {
			// Get the select element by its ID
			const selectElement = document.getElementById(id);

			// Create a new option element
			const newOption = document.createElement('option');

			// Set the value and text of the new option
			newOption.value = value;
			newOption.textContent = text;

			// Append the new option to the select element
			selectElement.appendChild(newOption);
		}


		//------------------------------------- Initialize two selects using Select2  ------------------------------->

		$(document).ready(function() {
			setRoot();
			$('#selectFrom').select2({
				placeholder: 'Search for an option',
				allowClear: true
			});

			$('#selectTo').select2({
				placeholder: 'Search for an option',
				allowClear: true
			});
		});

		// -------------------------- set roots for select boxes--------------------

		function setRoot() {
			$.ajax({
				url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php',
				data: {
					action: 'getRoot'
				}, // Specify the action to be handled in PHP
				dataType: 'json', // Expect JSON response from PHP
				success: function(response) {
					console.log(response); // Log the response for debugging

					$('#selectFrom').empty();
					addOption('selectFrom', "All", "All");

					const selectBoxFrom = document.getElementById('selectFrom');
					const selectBoxTo = document.getElementById('selectTo');

					if (Array.isArray(response)) {
						response.forEach(function(item) {

							let foundFrom = true;
							let foundTo = true;

							for (let i = 0; i < selectBoxFrom.options.length; i++) {
								if (selectBoxFrom.options[i].value === item.FromCity) {
									foundFrom = false;
									break;
								}
							}

							for (let i = 0; i < selectBoxTo.options.length; i++) {
								if (selectBoxTo.options[i].value === item.ToCity) {
									foundTo = false;
									break;
								}
							}

							if (foundFrom) {
								addOption('selectFrom', item.FromCity, item.FromCity);
							}

							if (foundTo) {
								addOption('selectTo', item.ToCity, item.ToCity);
							}

						});
					} else {

						console.error('Error: Unexpected data format');
					}

				},
				error: function(jqXHR, textStatus, errorThrown) {

					console.error('Error details:', textStatus, errorThrown); // Log error details
				}

			});

		}
		// --------------------- Set Select box values disable and enable ---------------------------

		function disableOptions(selectedText) {
			$.ajax({
				url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php', // URL to the PHP script
				type: 'POST',
				data: {
					action: 'getRoot'
				}, // Specify the action to be handled in PHP
				dataType: 'json', // Expect JSON response from PHP
				success: function(response) {
					console.log(response);
					enableOption("All");

					if (Array.isArray(response)) {
						response.forEach(function(item) {

							if (item.FromCity === selectedText) {

								enableOption(item.ToCity);
							}

						});

					} else {
						console.error('Error: Unexpected data format');
					}

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('Error details:', textStatus, errorThrown); // Log error details
				}

			});

		}

		// ---------- enable function----------------------------------

		function enableOption(value) {
			var options = document.querySelectorAll(`#selectTo option[value="${value}"]`);
			options.forEach(function(option) {
				option.disabled = false;
			});
		}


		function changeSelectValue(value) {
			var selectBox = document.getElementById('selectTo option');
			selectBox.value = value; // Set the selected value
		}

		// ------ Add data to shedule table---------------------------------------

		function CreateTable(from, to, date) {
			let fromCity = from;
			let toCity = to;
			let day = date;
			let method;

			if (fromCity === "All" && toCity === "All") {
				method = "getAll";
			} else {
				method = "getTable";
			}
			console.log(method)
			$.ajax({
				url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php',
				type: 'POST',
				data: {
					action: method,
					fromCity: fromCity,
					toCity: toCity,
					day: day
				},
				dataType: 'json',
				success: function(response) {
					console.log(response);

					if (Array.isArray(response)) {

						// Iterate over the bus schedules and append to the result
						response.forEach(function(item) {
							console.log(item.ScheduleID);

							addRow(item.ScheduleID, item.FromCity, item.ToCity, item.Formatted_time, item.AvailableSeatCount, item.Price);
						});
					} else {

						console.error('Error: Unexpected data format');
					}
				},
				error: function(xhr, status, error) {
					console.error('AJAX Error: ' + status + error);
				}
			});
		}

		// ---------clear table---------------------------------------

		function clearTable(tableId) {
			var table = document.getElementById(tableId);

			// Clear all rows except the header row
			while (table.rows.length > 1) {
				table.deleteRow(1); // Deletes the second row (index 1)
			}
		}

		// ------ Add new rows---------------------------------------------------

		function addRow(sheduleId, from, to, time, availableSeatCount, ticketPrice) {
			var scheduleTable = document.getElementById("sheduleTable");
			var rowsNo = scheduleTable.getElementsByTagName("tr");

			var newRow = scheduleTable.insertRow(-1); // Insert at the end of the table

			// Insert cells
			var cell1 = newRow.insertCell(0);
			var cell2 = newRow.insertCell(1);
			var cell3 = newRow.insertCell(2);
			var cell4 = newRow.insertCell(3);
			var cell5 = newRow.insertCell(4);
			var cell6 = newRow.insertCell(5);

			// Set cell values
			cell1.innerHTML = from;
			cell2.innerHTML = to;
			cell3.innerHTML = time;
			cell4.innerHTML = availableSeatCount;
			cell5.innerHTML = ticketPrice;
			cell6.innerHTML = '<input id=' + sheduleId + ' class="btn btn-sm btn-danger" style="background-color: #FF4545; color: white;" type="button" value="Book" onclick="sendData(this.id)">';

		}

		// ------ call seat selection page ---------------------------

		function sendData(sheduleId) {

			window.location.href = `selectseat.php?sheduleId=${encodeURIComponent(sheduleId)}`;

		}

		// -----------Search button click event-----------------------------------------

		$('#btn').on('click', function() {

			var date = String(document.getElementById('dateInput').value);

			var selectBox = document.getElementById('selectTo');
			var selectedIndex = selectBox.selectedIndex;

			if (selectedIndex !== -1) { // Check if an option is selected
				var to = selectBox.options[selectedIndex].text;
			}

			var selectBox = document.getElementById('selectFrom');
			var selectedIndex = selectBox.selectedIndex;

			if (selectedIndex !== -1) { // Check if an option is selected
				var from = selectBox.options[selectedIndex].text;
			}

			clearTable("sheduleTable");
			CreateTable(from, to, date);

		});

		// --------- Slect box selected item selct event----------------------------------------------

		$('#selectFrom').change(function() {
			const selectedValue = $(this).val(); // Get the selected value
			const selectedText = $(this).find("option:selected").text(); // Get the selected text

			var options = document.querySelectorAll('#selectTo option');
			options.forEach(function(option) {
				option.disabled = true;
			});

			disableOptions(selectedText);

			$('#selectTo').val(-1);

		});

		// -------------- Datepicker select option and other settings----------------------------
		// $(document).ready(async function() {
		// 	try {
		// 		// Fetch the current date from the API
		// 		const response = await fetch('http://worldtimeapi.org/api/ip');
		// 		const data = await response.json();

		// 		// Extract the full datetime string
		// 		const fullDateTime = data.datetime;

		// 		// Set the start and end dates based on the fetched date
		// 		let startDateObj = new Date(fullDateTime); // Set the start date (current day)
		// 		let endDateObj = new Date(fullDateTime); // Copy the current date
		// 		endDateObj.setDate(startDateObj.getDate() + 6); // Set end date to 6 days after startDate


		// 		let startDate = `${startDateObj.getFullYear()}-${(startDateObj.getMonth() + 1).toString().padStart(2, '0')}-${startDateObj.getDate().toString().padStart(2, '0')}`;
		// 		let endDate = `${endDateObj.getFullYear()}-${(endDateObj.getMonth() + 1).toString().padStart(2, '0')}-${endDateObj.getDate().toString().padStart(2, '0')}`;

		// 		// Initialize the datepicker
		// 		$('#datepicker').datepicker({
		// 			format: 'yyyy-mm-dd', // Date format
		// 			autoclose: true, // Close the picker automatically after selection
		// 			todayHighlight: true, // Highlight today's date
		// 			clearBtn: true, // Add a clear button
		// 			showWeekDays: true, // Show the days of the week
		// 			weekStart: 1, // Set week start to Monday (0 = Sunday, 1 = Monday)
		// 			daysOfWeekHighlighted: [0, 6], // Highlight weekends (Sundays and Saturdays)
		// 			orientation: "auto bottom", // Display the picker at the bottom of the input
		// 			templates: {
		// 				leftArrow: '&laquo;', // Custom previous arrow
		// 				rightArrow: '&raquo;' // Custom next arrow
		// 			},
		// 			todayBtn: "linked", // Add a "Today" button
		// 			startDate: startDate, // Set the earliest selectable date
		// 			endDate: endDate // Set the latest selectable date
		// 		});
		// 	} catch (error) {
		// 		console.error("Error fetching date:", error);
		// 	}
		// });


		// function sendData(sheduleId) {
		// 	const xhr = new XMLHttpRequest();
		// 	xhr.open("POST", "process.php", true);
		// 	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

		// 	xhr.onreadystatechange = function() {
		// 		if (xhr.readyState === 4 && xhr.status === 200) {
		// 			window.location.href = `selectseat.php?sheduleId=${encodeURIComponent(sheduleId)}`;
		// 		}
		// 	};
		// 	xhr.send(`sheduleId=${encodeURIComponent(sheduleId)}`);
		// }
	</script>

</body>

</html>