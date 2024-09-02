<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <!-- Bootstrap Bundle JS (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --grey: #F1F0F6;
            --dark-grey: #8d8d8d;
            --light: #fff;
            --dark: #000;
            --green: #81d43a;
            --light-green: #e3ffcb;
            --blue: #1775F1;
            --light-blue: #d0e4ff;
            --dark-blue: #0c5fcd;
            --red: #fc3b56;
        }

        html {
            overflow-x: hidden;
        }

        body {
            background: var(--grey);

        }

        a {
            text-decoration: none;
        }

        /* side bar start*/

        #sidebar {
            position: fixed;
            max-width: 260px;
            width: 100%;
            height: 100%;
            background: var(--light);
            top: 0;
            left: 0;
            overflow-y: auto;
            scrollbar-width: none;
            transition: all .3s ease;
            z-index: 200;
        }

        #sidebar.hide {
            max-width: 60px;
        }

        #sidebar.hide:hover {
            max-width: 260px;
        }

        #sidebar::-webkit-scrollbar {
            display: none;
        }

        #sidebar .brand {
            font-size: 24px;
            height: 64px;
            display: flex;
            align-items: center;
            font-weight: 700;
            color: var(--blue);
            transition: all .3s ease;
            padding: 0 6px;
            position: sticky;


        }


        #sidebar .icon {
            min-width: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 8px;

        }

        #sidebar .side-menu {
            margin: 36px 0;
            padding: 0 20px;
            transition: all .3s ease;

        }

        #sidebar.hide .side-menu {
            padding: 0 8px;
        }

        #sidebar .side-menu a {
            display: flex;
            align-items: center;
            font-size: 20px;
            color: var(--dark);
            padding: 12px 16px 12px 0;
            transition: all .3s ease;
            border-radius: 10px;
            margin: 4px 0;
        }

        #sidebar .side-menu>li>a:hover {
            background: var(--grey);
        }

        #sidebar .side-menu a.active,
        #sidebar .side-menu a.active:hover {
            background: var(--blue);
            color: var(--light);
        }

        #sidebar .menu {
            padding-left: 48px;

        }

        #sidebar .menu a:hover {
            color: var(--blue);
        }



        /*sidebar end*/

        /* Content Section */
        #content {
            position: relative;
            width: calc(100% - 260px);
            left: 260px;
            transition: all .3s ease;
        }

        #content.expanded {
            width: calc(100% - 60px);
            left: 60px;
        }

        /* Navbar Styling */
        nav {
            background: var(--light);
            height: 64px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 28px;

        }

        nav .toggle-sidebar {
            font-size: 24px;
            font-weight: lighter;
            cursor: pointer;
        }

        nav .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--dark);
        }

        nav .nav-link .icon {
            font-size: 18px;
        }

        nav .nav-link .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid var(--light);
            background: var(--red);
            color: var(--light);
            font-size: 10px;
            font-weight: 700;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav .divider {
            width: 1px;
            background: var(--grey);
            height: 12px;
            display: block;
        }

        nav .profile {
            position: relative;
        }

        nav .profile img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        nav .profile .profile-link {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--light);
            padding: 10px 0;
            box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
            border-radius: 10px;
            width: 150px;
            z-index: 1000;
        }

        nav .profile .profile-link a {
            padding: 10px 16px;
            display: flex;
            gap: 6px;
            font-size: 14px;
            color: var(--dark);
            align-items: center;
            transition: all .3s ease;
            text-decoration: none;
        }

        nav .profile .profile-link a:hover {
            background: var(--grey);
        }


        /*Navbar close*/

        /* Main */
        main {
            padding: 24px 20px 20px 20px;
            width: 100%;
        }

        main .title {
            font-size: 28px;
            font-weight: 600;
        }

        main .breadcrumbs li,
        main .breadcrumbs li a {
            font-size: 14px;
        }

        main .breadcrumbs li a {
            color: var(--blue);
        }

        main .breadcrumbs li a.active,
        main .breadcrumbs li a.divider {
            color: var(--dark-grey);
            pointer-events: none;
        }

        /* Main */

        /*content end */



        @media screen and (max-width:768px) {
            #content {
                position: relative;
                width: calc(100%-60px);
                transition: all .3s ease;
            }

            nav .nav-link {
                display: none;
            }
        }
    </style>
    <title>Admin Dashboard</title>
</head>

<body>
    <!-- SideBar start -->
    <section id="sidebar">
        <a href="#" class="brand"><i class='bx bxs-bus icon'></i> EzBus</a>
        <ul class="list-unstyled component m-0 side-menu gap-5">
            <!-- Home -->
            <li><a href="#" id="Home" data-url="AdminPanel/AdminHomePanel.php" class="home active"><i class="bi bi-columns-gap icon"></i>Home</a></li>
            <!-- Users -->
            <li>
                <a href="#UsersMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle ">
                    <i class="bi bi-person icon"></i>Users
                </a>

                <ul class=" collapse list-unstyled menu" id="UsersMenu">
                    <li><a href="#" id="Admin" data-url="AdminPanel/AdminAdminPanel.php">Admin</a></li>
                    <li><a href="#" id="Counter" data-url="AdminPanel/AdminCounterPanel.php">Counter</a></li>
                    <li><a href="#" id="Conductor" data-url="AdminPanel/AdminConductorPanel.php">Conductor</a></li>
                    <li><a href="#" id="Driver" data-url="AdminPanel/AdminDriverPanel.php">Drivers </a></li>
                </ul>

            </li>
            
            <!-- Route -->
            <li><a href="#" id="Route" data-url="AdminPanel/AdminRoutePanel.php"><i class="bi bi-geo-alt icon"></i>Routes </a></li>
            <!-- Buss -->
            <li><a href="#" id="Bus" data-url="AdminPanel/AdminBusPanel.php"><i class="bi bi-bus-front-fill icon"></i></i>Buses </a></li>
            <!-- Schedule -->
            <li><a href="#" id="Schedule" data-url="AdminPanel/AdminSchedulePanel.php"><i class="bi bi-calendar-range icon"></i>Schedules </a></li>
            
            <!-- Reports -->
            <li>
                <a href="#ReportsMenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <i class="bi bi-file-earmark-text icon"></i>Reports
                </a>
                <ul class=" collapse list-unstyled menu " id="ReportsMenu">
                    <li><a href="#">Admin</a></li>
                    <li><a href="#">Counter</a></li>
                    <li><a href="#">Counductor</a></li>
                </ul>
            </li>

        </ul>
    </section>
    <!-- SideBar Close -->


    <section id="content">
        <!-- Navbar Start-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!-- Toggle Sidebar Button -->
                <i class="bi bi-list toggle-sidebar"></i>


                <!-- Navbar Items Aligned to the Right -->
                <div class="ms-auto d-flex gap-2">

                    <!-- Show Name -->
                    <div class="text-muted pt-2 text-capitalize d-flex">
                        <h6>Hi, </h6>
                        <h6 id="ShowUserName">Kalindu Suraj</h6>
                    </div>
                    <!-- Divider -->
                    <span class="divider"></span>

                    <!-- Bell Icon with Badge -->
                    <a href="#" class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#Notification" aria-controls="Notification">
                        <i class='bx bxs-bell bx-tada-hover icon'></i>
                        <span class="badge">5</span>
                    </a>

                    <!-- Divider -->
                    <span class="divider"></span>

                    <!-- Profile Menu -->
                    <div class="profile">
                        <a href="#ProfileMenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="ProfileMenu">
                            <img src="src/profile.png" alt="Profile">
                        </a>
                        <ul class="collapse list-unstyled profile-link" id="ProfileMenu">
                            <li><a href="#" id="Profile" data-url="AdminPanel/AdminProfilePanel.php"><i class="bi bi-person-circle icon"></i>Profile</a></li>
                            <li><a href="#" id="logout" onclick="confirmLogout()"><i class='bx bx-log-out bx-fade-left icon'></i>Log out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar Close-->
        <!-- Main -->
        <main>
            <section id="view">

            </section>
        </main>
    </section>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="Notification" aria-labelledby="NotificationLabel">
        <div class="offcanvas-header">
            <h5 id="NotificationLabel">Notification</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            
        </div>
    </div>






    <script>
        // Select all dropdown menus
        const dropdownMenus = document.querySelectorAll('#sidebar .collapse');
        // Select all Sidebar btn within the sidebar, excluding submenu items
        const sidebarBtn = document.querySelectorAll('#sidebar .side-menu > li > a');

        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listeners to all Sidebar btn
            sidebarBtn.forEach(function(link) {
                link.addEventListener('click', function() {
                    // Remove 'active' class from all Sidebar btn
                    sidebarBtn.forEach(function(lnk) {
                        lnk.classList.remove('active');
                    });

                    // Add 'active' class to the clicked Sidebar btn
                    link.classList.add('active');

                    // Close all dropdown menus
                    dropdownMenus.forEach(function(menu) {
                        const collapseInstance = bootstrap.Collapse.getInstance(menu);
                        if (collapseInstance) {
                            collapseInstance.hide();
                        }
                    });
                });
            });


            // form load
            const viewSection = document.getElementById('view');

            async function loadContent(url) {
                try {
                    const response = await fetch(url);
                    if (response.ok) {
                        const content = await response.text();
                        viewSection.innerHTML = content;
                        executeScripts(viewSection);
                    } else {
                        viewSection.innerHTML = `<p>Failed to load content. Status: ${response.status}</p>`;
                    }
                } catch (error) {
                    viewSection.innerHTML = `<p>Error: ${error.message}</p>`;
                }
            }

            function executeScripts(container) {
                const scripts = container.querySelectorAll('script');
                scripts.forEach(script => {
                    const newScript = document.createElement('script');
                    newScript.textContent = script.textContent;
                    document.body.appendChild(newScript).parentNode.removeChild(newScript);
                });
            }

            function setActiveLink(link) {
                document.querySelectorAll('#sidebar a').forEach(link => link.classList.remove('active'));
                link.classList.add('active');
            }
            document.querySelectorAll('#sidebar a[data-url]').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('data-url');
                    loadContent(url);
                });
            });
            // Load default content (home) on page load
            const defaultLink = document.querySelector('#Home');
            if (defaultLink) {
                const defaultUrl = defaultLink.getAttribute('data-url');
                loadContent(defaultUrl);
                setActiveLink(defaultLink);
            }

            // Handle Profile Menu Click
            const profileMenuLink = document.querySelector('#Profile');
            if (profileMenuLink) {
                profileMenuLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('data-url');
                    loadContent(url);
                    setActiveLink(this);
                });
            }

        });

        //profile dropdown
        const profile = document.querySelector('nav .profile');
        const imgProfile = profile.querySelector('img')
        const dropdownProfile = profile.querySelector('.profile-link')

        window.addEventListener('click', function(e) {
            if (e.target !== imgProfile) {
                if (e.target !== dropdownProfile) {
                    if (dropdownProfile.classList.contains('show')) {
                        dropdownProfile.classList.remove('show');
                    }

                }
            }
        })

        //toggle sidebar
        const toggleSidebar = document.querySelector('nav .toggle-sidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('hide');
            content.classList.toggle('expanded');
        })

        sidebar.addEventListener('mouseleave', function() {
            if (sidebar.classList.contains('hide')) {
                // Close all dropdown menus
                dropdownMenus.forEach(function(menu) {
                    const collapseInstance = bootstrap.Collapse.getInstance(menu);
                    if (collapseInstance) {
                        collapseInstance.hide();
                    }
                });
            }
        });

        function confirmLogout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'index.php';
            }
        }
    </script>

</body>

</html>