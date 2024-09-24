
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EzBus Seat Selection</title>

    <!--Bootstrap CDN-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* General container adjustments for full-width */
        .container1 {
            max-width: 100%;
            padding: 0;
        }

        /* Adjust font sizes for mobile */
        @media (max-width: 576px) {

            h4,
            h5 {
                font-size: 1.2rem;
            }

            p {
                font-size: 0.9rem;
            }
        }

        /* Glass effect for the location/details section */
        .glass-container {
            backdrop-filter: blur(10px) saturate(150%);
            -webkit-backdrop-filter: blur(10px) saturate(150%);
            background-color: rgba(255, 213, 130, 0.5);
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            color: #fff;
        }

        /* Location Section */
        .location-section {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* Date Section */
        .date-section {
            background-color: #4a90e2;
            color: white;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }

        /* Selected seats styling */
        .selected-seats {
            background-color: #adff9a;
            padding: 15px;
            border-radius: 10px;
            color: black;
        }

        /* Icons */
        .icon {
            font-size: 1.5rem;
            color: red;
        }

        .calendar-icon {
            color: #4a90e2;
        }

        .recent-search-icon {
            color: purple;
        }

        /* Switch icon */
        .switch-icon {
            font-size: 1.8rem;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            color: white;
        }

        /* Search button styling */
        .search-button {
            background-color: #4a90e2;
            border-radius: 50%;
            padding: 15px;
            color: white;
            display: inline-block;
            margin-top: 20px;
        }

        .search-button:hover {
            background-color: #357ab7;
        }

        /* Seat button styles */
        .btnStyle {
            margin: 5px;
            width: 45px;
        }

        /* Responsiveness adjustments */
        @media (max-width: 768px) {
            .card {
                width: 100%;
                margin: 10px 0;
            }

            .btnmin {
                font-size: 10px;
                margin: 2px;
            }


        }

        @media (min-width: 768px) {
            .container1 {
                max-width: 300px;
                /* Maintain the original width on desktop */

            }

            .glass-container {
                max-width: 300px;
            }

            .scroll-icon {
                display: none;
                /* Show the icon on mobile devices */
            }

        }

        .scroll-icon {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 2.5rem;
            color: #4a90e2;
            /* or any color you prefer */
            z-index: 9999;
        }

        @media (max-width: 576px) {}
    </style>
</head>

<body style="background-color:#0c2d3b">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-light bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex gap-2" href="#">
                <img src="gallery/logo.png" style="margin: 0;" height="40px" width="40px" alt="Logo">
                <p style="color:aqua; font-family:Lona BC; font-size: 34px; margin: 0;"> EzBus</p>
            </a>
            <!-- <div class="navbar-collapse">
                <p style="color:aqua; font-family:Lona BC; font-size: 24px;">EzBus</p>
            </div>     -->
        </div>
    </nav>
    <div style="background-color: rgba(255, 213, 130 , 1);height: 50px;" class="justify-content-center d-flex">
        <p class="mt-2" style="font-size: 20px; color:#523700;">Select seat as you wish...!</p>
    </div>

    <!-- Main Content: Seat Array and Location Details -->
    <div class="container">
        <div class="row">
            <!-- Seat Selection Section -->
            <div class="col-12 col-md-6 d-flex justify-content-center">
                <div class="col-12 col-lg-10 container1">
                    <div class="row d-flex mt-4 card" style="background-color:#ffdf5c;">
                        <div class="col-12 justify-content-center d-flex container" style="background-color:#ffb25c;">
                            <p>Front</p>
                        </div>
                        <div class="card-body justify-content-center d-flex">
                            <table id="seat">
                                <!-- Seat table content -->
                            </table>

                        </div>
                        <div id="scrollIcon" class="scroll-icon text-center">
                            <i class='bx bx-down-arrow-circle bx-fade-up '></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location and Details Section -->

            <div id="ticket" class="col-12 col-md-6 mt-4 d-flex justify-content-center">

                <div class="glass-container bg-light card p-3">
                    <p class="text-dark text-center">Schedule ID : <span id="showScheduleID"></span></p>
                    <!-- Location Details -->
                    <div class="location-section">
                        <div class="icon">
                            <i class="bi bi-geo-alt-fill"></i> Location Details
                        </div>

                        <div class="mt-3">
                            <p>From</p>
                            <h4 id="fromCity"></h4>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p>To</p>
                            <div class="switch-icon">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                        </div>
                        <h4 id="toCity"></h4>
                    </div>

                    <!-- Date Details -->
                    <div class="calendar-icon mb-3">
                        <i class="bi bi-calendar-event-fill"></i> Date Details
                    </div>
                    <div class="date-section d-flex justify-content-around">
                        <div>
                            <h4 id="disDate">10</h4>
                            <p id="disMonth">Dec Wed</p>
                            <!-- <small>Onward</small> -->
                        </div>
                        <div>
                            <h5>Unit Price</h5>
                            <p id="ticketPrice">500.00</p>
                            <!-- <small>Return</small> -->
                        </div>
                    </div>

                    <!-- Pay Button -->
                    <div class="text-center">
                        <form id="paymentForm" action="process.php?action=TicketPayment&Price=" method="POST">
                            <button type="submit" id="payButton" class="btn btn-info"><i class="bi bi-arrow-right-circle-fill" onclick=""></i></button>
                        </form>
                    </div>

                    <!-- <div class="text-center">
                        
                        <div class="btn btn-primary mt-3" id="payButton">
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </div>
                    </div> -->

                    <!-- Price total -->
                    <div class="selected-seats mt-4">
                        <div class="recent-search-icon">
                            <i class="bi bi-ticket-perforated"></i> Selected seats
                        </div>
                        <div class="mt-3">
                            <div class="justify-content-between">
                                <p id="disSeatId"></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Total Price <i class="bi bi-arrow-right"></i></p>
                                <p>RS.</p>
                                <p id="totalPrice" class="price">0.00</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">
        //form

        //
        window.onload = function() {
            getDetails();
            seatArray(49);

        }

        /*--------------------------- making seat array ---------------------------------*/
        function seatArray(num) {

            let rowCount = 11;
            if (num % 7 == 0) {
                rowCount = 12;
            }

            var table = document.getElementById("seat");

            //for default time didfine
            // document.getElementById('timeBelt').value = "10.00 AM";
            // document.getElementById('time1').style.backgroundColor = "#4AF1FF";
            // document.getElementById('time1').style.color = "#002C3B ";

            for (var i = 0; i <= rowCount; i++) {
                var row = table.insertRow(i);
                for (let j = 65; j <= 69; j++) {

                    var x = 0;
                    var cell1 = row.insertCell(x);

                    if (i < 10) {
                        var sId = String.fromCharCode(j) + '0' + i;
                    } else {
                        var sId = String.fromCharCode(j) + i;
                    }

                    if (j == 67 && i != rowCount) {
                        cell1.innerHTML = '<input id=' + sId + ' class="btn btn-sm btn-success btnStyle d-none btnmin" style="background-color: #5cffd0  ;color : #00484D;" type="button" data-status="0" name="sId" value=' + sId + ' onclick="setSeat(this.id)">';
                        continue;
                    }

                    cell1.innerHTML = '<input id=' + sId + ' class="btn btn-sm btn-success btnStyle btnmin"  style="background-color: #5cffd0  ;color : #00484D;" type="button" status="0" name="sId" value=' + sId + ' onclick="setSeat(this.id)">';


                }
            }

            disableSeats();
            // document.getElementById('rowNum').value = 0;

        }

        // ----- Seat array , seat button click event------------------------

        function setSeat(sid) {
            var seat = document.getElementById(sid);
            var par = document.getElementById("ss" + sid);
            console.log("Seat No :\n", sid);


            if (seat.getAttribute("status") == "1") {
                //--------remove-----------------
                seat.style.backgroundColor = "#5cffd0";
                seat.setAttribute("status", "0");
                setPrice(0);
            } else {
                //-----------set-----------
                seat.style.backgroundColor = "#FF4545 ";
                seat.setAttribute("status", "1");
                setPrice(1);

            }

            storeSelectedSeat(sid);
            document.getElementById("disSeatId").innerHTML = selectedSeatArray;

        }
        let tot = 0;
        //--------Price set function------------------------------
        function setPrice(status) {
            let price = document.getElementById("ticketPrice").innerHTML;
            let total = document.getElementById("totalPrice").innerHTML;

            let newTot = price;

            if (status == 1) {
                tot = parseFloat(total) + parseFloat(price)
                newTot = tot + ".00";
            } else {
                tot = parseFloat(total) - parseFloat(price)
                newTot = tot + ".00";
            }

            document.getElementById("totalPrice").innerHTML = newTot;

        }

        // ---------Selected seat array----------

        var selectedSeatArray = []; //globle array

        function storeSelectedSeat(value) {

            var arr = selectedSeatArray;
            const index = arr.indexOf(value);

            if (index === -1) {
                // Value not found, so add it
                arr.push(value);
            } else {
                // Value found, so remove it
                arr.splice(index, 1);
            }
        }

        // ---------get Shedules from db --------------------


        function getDetails() { // Accept 'scheduleId' as a parameter

            const params = new URLSearchParams(window.location.search); //get schduleId
            const scheduleId = params.get('sheduleId');
            $("#showScheduleID").text(scheduleId);

            console.log(scheduleId);

            $.ajax({
                url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php', // URL to the PHP script
                type: 'POST', // Request method (POST)
                data: {
                    action: 'getSchedule',
                    scheduleId: scheduleId
                }, // Data sent to the server
                dataType: 'json', // Expected data format from the server (JSON)

                success: function(response) {
                    console.log(response); // Log the response for debuggin

                    // Check if the response is an array
                    if (Array.isArray(response)) {
                        console.log("Data sent:\n", response);

                        document.getElementById("ticketPrice").innerHTML = response.Price;
                        response.forEach(function(item) {

                            const dateStr = item.Date;
                            console.log(dateStr);
                            const dateParts = dateStr.split('-');


                            document.getElementById("ticketPrice").innerHTML = item.Price;
                            document.getElementById("fromCity").innerHTML = item.FromCity;
                            document.getElementById("toCity").innerHTML = item.ToCity;
                            document.getElementById("disDate").innerHTML = dateParts[2];
                            document.getElementById("disMonth").innerHTML = dateParts[1] + " | " + dateParts[0];


                        });

                    } else {
                        console.error('Error: Unexpected data format');
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    alert("hui");
                    console.error('Error details:', textStatus, errorThrown); // Log error details
                }
            });
        }

        function disableSeats() {
            const params = new URLSearchParams(window.location.search); //get schduleId
            const scheduleId = params.get('sheduleId');

            $.ajax({
                url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php', // URL to the PHP script
                type: 'POST', // Request method (POST)
                data: {
                    action: 'getSeats',
                    scheduleId: scheduleId
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);

                    // Check if the response is an array
                    if (Array.isArray(response)) {

                        //document.getElementById("ticketPrice").innerHTML=response.TicketPrice;
                        response.forEach(function(item) {
                            console.log("seatno" + item.SeatNo)
                            document.getElementById(`${item.SeatNo}`).style.backgroundColor = "#707070  ";
                            document.getElementById(`${item.SeatNo}`).disabled = true;
                        });

                    } else {
                        console.error('Error: Unexpected data format');
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    alert("hui");
                    console.error('Error details:', textStatus, errorThrown); // Log error details
                }
            });
        }

        window.addEventListener('scroll', function() {

            var scrollIcon = document.getElementById('scrollIcon');

            // Calculate how far the user has scrolled
            var scrollTop = window.scrollY; // Distance from the top of the document
            var windowHeight = window.innerHeight; // Height of the visible window
            var documentHeight = document.documentElement.scrollHeight; // Total height of the document

            // Check if the user has reached the bottom of the page
            if (scrollTop + windowHeight >= documentHeight - 50) {
                // If yes, hide the arrow
                scrollIcon.style.display = 'none';
            } else {
                // Otherwise, make sure the icon is visible
                scrollIcon.style.display = 'block';
                //scrollIcon.style.display = 'none';
            }
        });




        $('#payButton').on('click', function(event) {
            event.preventDefault();

            // Capture the data
            var Price = tot; // Assuming `tot` is declared globally or accessible.
            var seatData = document.getElementById("disSeatId").innerHTML;
            var scheduleID = document.getElementById("showScheduleID").textContent;

            // Log to ensure values are correct
            console.log(Price);
            console.log("scheduleID", scheduleID);
            console.log("seatData", seatData);

            // Send the data to process.php via AJAX
            $.ajax({
                url: 'process.php',
                type: 'POST', // Use POST method for sensitive data
                data: {
                    action: 'TicketPayment', // Custom action flag
                    Price: Price,
                    scheduleID: scheduleID,
                    seatData: seatData
                },
                success: function(response) {
                    console.log(response); // Handle the server response
                    loadStripe(Price);
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error); // Handle error
                }
            });
        });

        function loadStripe(amount) {
            $.ajax({
                url: 'process.php',
                method: 'GET',
                data: {
                    action: 'checkout',
                    seatPrice: amount
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.url) {
                        // Redirect to the checkout session
                        window.location.href = res.url;
                    } else {
                        alert('Error creating checkout session: ' + res.message);
                    }
                },
                error: function(err) {
                    console.error('AJAX error:', err);
                }
            });
        }


        // $('#payButton').on('click', function(event) {
        //     event.preventDefault();
        //     console.log("Pay Button Click");
        //     var Price = tot;
        //     // alert("hi");
        //     var seatData = document.getElementById("disSeatId").innerHTML;
        //     var scheduleID = document.getElementById("showScheduleID").textContent;
        //     console.log(Price);
        //     console.log("scheduleID",scheduleID);
        //     console.log("seatData",seatData);

        //     // alert(scheduleID,selectedSeatArray[0]);
        //     // alert("hi");


        //     $.ajax({
        //         type: "POST",
        //         url: 'http://localhost/testweb/GitHub/EzBus-Expressway-Online-Sheat-Booking-Web/process.php',
        //         dataType: "json",
        //         data: {
        //             action: 'TicketPayment',
        //             Price: Price,
        //             ScheduleID:scheduleID,
        //             seatData:seatData,

        //             //action: 'getSeats',

        //         },
        //         success: function(response) {
        //             alert("h1");
        //             console.log("Response from server:", response);
        //         },
        //         error: function(xhr, status, error) {
        //             alert("h2");
        //             console.error("Error fetching passenger data: " + status + " - " + error);
        //         }
        //     });



        // });
        //----------
        var form = document.getElementById('paymentForm');
        // var seatData = document.getElementById("disSeatId").innerHTML;
        //     var scheduleID = document.getElementById("showScheduleID").textContent;

        form.addEventListener('submit', function(event) {

            event.preventDefault();
            var newAction = "process.php?action=TicketPayment&Price=" + encodeURIComponent(tot) + "&seatData=" + encodeURIComponent(seatData) + "&scheduleID=" + encodeURIComponent(scheduleID);
            form.action = newAction;
            form.submit();
        });



        // function storeData() {
        //     alert("StoreData");
        //     var seatData = document.getElementById("disSeatId").textContent;
        //     var scheduleID = document.getElementById("showScheduleID").textContent;

        //     var xhr = new XMLHttpRequest();
        //     xhr.open("POST", "process.php?action=PaymentSucess", true);
        //     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //     xhr.onreadystatechange = function() {
        //         if (xhr.readyState == 4 && xhr.status == 200) {
        //             console.log(xhr.responseText);
        //         }
        //     };
        //     xhr.send("seatData=" + encodeURIComponent(seatData) + "&scheduleID=" + encodeURIComponent(scheduleID));

        // }
    </script>


</body>

</html>