<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Vitour - Travel & Tour Booking HTML Template</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="app/css/app.css">
    <link rel="stylesheet" href="app/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="app/css/map.min.css">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="assets/images/favico.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favico.png">

</head>

<body class="body header-fixed ">

    <div class="preload preload-container">
        <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
            <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
            <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000"
                stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
        </svg>
    </div>

    <!-- /preload -->

    <div id="wrapper">

        <div id="pagee" class="clearfix">

            <div class="sidebar-dashboard">
                <div class="db-logo">
                    <a href="index.html"><img src="assets/images/favico.png" alt="Logo"><span>Vitour</span></a>
                </div>
                <div class="db-menu">
                    <ul>
                        <li class="active">
                            <a href="dashboard.html">
                                <i class="icon-Vector-9"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="my-booking.html">
                                <i class="icon-Layer-2"></i>
                                <span>My Booking</span>
                            </a>
                        </li>
                        <li>
                            <a href="my-listing.html">
                                <i class="icon-Group-81"></i>
                                <span>My Listing</span>
                            </a>
                        </li>
                        <li>
                            <a href="add-tour.html">
                                <i class="icon-Group-91"></i>
                                <span>Add Tour</span>
                            </a>
                        </li>
                        <li>
                            <a href="my-favorite.html">
                                <i class="icon-Vector-10"></i>
                                <span>My Favorites</span>
                            </a>
                        </li>
                        <li>
                            <a href="my-profile.html">
                                <i class="icon-profile-user-1"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="login.html">
                                <i class="icon-turn-off-1"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>


                </div>

            </div>

            <div class="has-dashboard">
                <!-- Main Header -->
                <header class="main-header flex">
                    <!-- Header Lower -->
                    <div id="header">
                        <div class="header-dashboard">
                            <div class="tf-container full">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="inner-container flex justify-space align-center">
                                            <!-- Logo Box -->
                                            <div class="header-search flex-three">
                                                <div class="icon-bars">
                                                    <i class="icon-Vector3"></i>
                                                </div>
                                                <form action="/" class="search-dashboard">
                                                    <i class="icon-Vector5"></i>
                                                    <input type="search" placeholder="Search tours">
                                                </form>

                                            </div>
                                            <div class="nav-outer flex align-center">
                                                <!-- Main Menu -->
                                                <nav class="main-menu show navbar-expand-md">
                                                    <div class="navbar-collapse collapse clearfix"
                                                        id="navbarSupportedContent">
                                                        <ul class="navigation clearfix">
                                                            <li class="dropdown2">
                                                                <a href="#">Home</a>
                                                                <ul>
                                                                    <li><a href="index.html">Home Page 01</a></li>
                                                                    <li><a href="home2.html">Home Page 02</a></li>
                                                                    <li><a href="home3.html">Home Page 03</a></li>
                                                                    <li><a href="home4.html">Home Page 04</a></li>
                                                                    <li><a href="home5.html">Home Page 05</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown2">
                                                                <a href="#">Tour</a>
                                                                <ul>
                                                                    <li><a href="archieve-tour.html">Archieve tour</a>

                                                                    </li>
                                                                    <li><a href="tour-package-v2.html">Tour left
                                                                            sidebar</a>

                                                                    </li>
                                                                    <li><a href="tour-package-v4.html">Tour package
                                                                        </a>

                                                                    </li>
                                                                    <li><a href="tour-single.html">Tour Single </a>

                                                                    </li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown2"><a href="#">Destination</a>
                                                                <ul>
                                                                    <li><a href="tour-destination-v1.html">Destination
                                                                            V1</a></li>
                                                                    <li><a href="tour-destination-v2.html">Destination
                                                                            V2</a></li>
                                                                    <li><a href="tour-destination-v3.html">Destination
                                                                            V3</a></li>
                                                                    <li><a href="single-destination.html">Destination
                                                                            Single</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown2 "><a href="#">Blog</a>
                                                                <ul>
                                                                    <li><a href="blog.html">Blog</a></li>
                                                                    <li><a href="blog-details.html">Blog Detail</a>
                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li class="dropdown2 "><a href="#">Pages</a>
                                                                <ul>
                                                                    <li><a href="about-us.html">About Us</a></li>
                                                                    <li><a href="team.html">Team member</a></li>
                                                                    <li><a href="gallery.html">Gallery</a></li>
                                                                    <li><a href="terms-condition.html">Terms &
                                                                            Condition</a></li>
                                                                    <li><a href="help-center.html">Help center</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="dropdown2 current"><a
                                                                    href="#">Dashboard</a>
                                                                <ul>
                                                                    <li class="current"><a
                                                                            href="dashboard.html">Dashboard</a>
                                                                    </li>
                                                                    <li><a href="my-booking.html">My booking</a></li>
                                                                    <li><a href="my-listing.html">My Listing</a></li>
                                                                    <li><a href="add-tour.html">Add Tour</a></li>
                                                                    <li><a href="my-favorite.html">My Favorites</a>
                                                                    </li>
                                                                    <li><a href="my-profile.html">My profile</a></li>
                                                                </ul>
                                                            </li>
                                                            <li><a href="contact-us.html">Contact</a></li>
                                                        </ul>
                                                    </div>
                                                </nav>
                                                <!-- Main Menu End-->
                                            </div>
                                            <div class="header-account flex align-center">

                                                <div class="dropdown notification">
                                                    <a class="icon-notification" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icon-notification-1"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <div class="message-item  flex-three">
                                                                <div class="image">
                                                                    <i class="icon-26"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="body-title">Discount available</div>
                                                                    <div class="text-tiny">Morbi sapien massa,
                                                                        ultricies at rhoncus at, ullamcorper nec diam
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="message-item  flex-three">
                                                                <div class="image">
                                                                    <i class="icon-26"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="body-title">Discount available</div>
                                                                    <div class="text-tiny">Morbi sapien massa,
                                                                        ultricies at rhoncus at, ullamcorper nec diam
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="message-item  flex-three">
                                                                <div class="image">
                                                                    <i class="icon-26"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="body-title">Discount available</div>
                                                                    <div class="text-tiny">Morbi sapien massa,
                                                                        ultricies at rhoncus at, ullamcorper nec diam
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>
                                                <div class="dropdown account">
                                                    <a type="button" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <img src="./assets/images/page/avata.jpg" alt="image">
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Account</a></li>
                                                        <li><a href="#">Setting</a></li>
                                                        <li><a href="#">Support</a></li>
                                                        <li><a href="login.html">Logout</a></li>
                                                    </ul>
                                                </div>
                                                <div class="mobile-nav-toggler mobile-button">
                                                    <i class="icon-bar"></i>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Header Lower -->


                    <!-- Mobile Menu  -->
                    <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
                    <div class="mobile-menu">
                        <div class="menu-backdrop"></div>
                        <nav class="menu-box">
                            <div class="nav-logo"><a href="index.html">
                                    <img src="assets/images/logo2.png" alt=""></a></div>
                            <div class="bottom-canvas">
                                <div class="menu-outer">
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!-- End Mobile Menu -->

                </header>
