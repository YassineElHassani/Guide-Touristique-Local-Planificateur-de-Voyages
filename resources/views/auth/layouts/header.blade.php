<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Vitour - Travel & Tour Booking HTML Template</title>

    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="{{ url('/app/css/app.css') }}">
    <link rel="stylesheet" href="{{ url('/app/css/jquery.fancybox.min.css') }}">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="{{ url('/assets/images/favico.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ url('/assets/images/favico.png') }}">

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

            <!-- Main Header -->
            <header class="main-header flex">
                <!-- Header Lower -->
                <div id="header">
                    <div class="header-top">
                        <div class="header-top-wrap flex-two">
                            <div class="header-top-right">
                                <ul class=" flex-three">
                                    <li class="flex-three">
                                        <i class="icon-day"></i>
                                        <span>Thursday, Mar 26, 2021</span>
                                    </li>
                                    <li class="flex-three">
                                        <i class="icon-mail"></i>
                                        <span>support@example.com</span>
                                    </li>
                                    <li class="flex-three">
                                        <i class="icon-phone"></i>
                                        <span>684 555-0102 490</span>
                                    </li>


                                </ul>
                            </div>
                            <div class="header-top-left flex-two">
                                <a href="contact-us.html" class="booking">
                                    <i class="icon-19"></i>
                                    <span>Booking Now</span>
                                </a>
                                <div class="follow-social flex-two">
                                    <span>Follow Us :</span>
                                    <ul class="flex-two">
                                        <li><a href="#"><i class="icon-icon-2"></i></a></li>
                                        <li><a href="#"><i class="icon-icon_03"></i></a></li>
                                        <li><a href="#"><i class="icon-x"></i></a></li>
                                        <li><a href="#"><i class="icon-icon"></i></a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="header-lower">
                        <div class="tf-container full">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="inner-container flex justify-space align-center">
                                        <!-- Logo Box -->
                                        <div class="mobile-nav-toggler mobie-mt mobile-button">
                                            <i class="icon-Vector3"></i>
                                        </div>
                                        <div class="logo-box">
                                            <div class="logo">
                                                <a href="index.html">
                                                    <img src="{{ url('/assets/images/logo.png') }}" alt="Logo">
                                                </a>
                                            </div>
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
                                                                <li><a href="tour-package-v4.html">Tour package </a>

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
                                                                <li><a href="blog-details.html">Blog Detail</a></li>
                                                            </ul>
                                                        </li>

                                                        <li class="dropdown2"><a href="#">Pages</a>
                                                            <ul>
                                                                <li><a href="about-us.html">About Us</a></li>
                                                                <li><a href="team.html">Team member</a></li>
                                                                <li><a href="gallery.html">Gallery</a></li>
                                                                <li><a href="terms-condition.html">Terms &
                                                                        Condition</a>
                                                                </li>
                                                                <li><a href="help-center.html">Help center</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="dropdown2"><a href="#">Dashboard</a>
                                                            <ul>
                                                                <li><a href="dashboard.html">Dashboard </a></li>
                                                                <li><a href="my-booking.html">My booking</a></li>
                                                                <li><a href="my-listing.html">My Listing</a></li>
                                                                <li><a href="add-tour.html">Add Tour</a></li>
                                                                <li><a href="my-favorite.html">My Favorites</a></li>
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
                                            <div class="language">
                                                <div class="nice-select" tabindex="0">
                                                    <img src="{{ url('/assets/images/page/language.svg') }}"
                                                        alt=""><span class="current">English</span>
                                                    <ul class="list">
                                                        <li data-value class="option selected"><img
                                                                src="{{ url('/assets/images/page/language.svg') }}"
                                                                alt="">English
                                                        </li>
                                                        <li data-value="Vietnam" class="option"><img
                                                                src="{{ url('/assets/images/page/language.svg') }}"
                                                                alt="">Vietnam
                                                        </li>
                                                        <li data-value="German" class="option"><img
                                                                src="{{ url('/assets/images/page/language.svg') }}"
                                                                alt="">German
                                                        </li>
                                                        <li data-value="Russian" class="option"><img
                                                                src="{{ url('/assets/images/page/language.svg') }}"
                                                                alt="">Russian
                                                        </li>
                                                        <li data-value="Canada" class="option"><img
                                                                src="{{ url('/assets/images/page/language.svg') }}"
                                                                alt="">Canada
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="currency">
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">USD</span>
                                                    <ul class="list">
                                                        <li data-value class="option selected">USD</li>
                                                        <li data-value="vnd" class="option">VND</li>
                                                        <li data-value="ero" class="option">ERO</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="search-mobie relative">
                                                <div class="dropdown">
                                                    <a type="button" class="show-search" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="icon-Vector5"></i>
                                                    </a>
                                                    <ul class="dropdown-menu top-search">
                                                        <form action="/" id="search-bar-widget">
                                                            <input type="text" placeholder="Search here...">
                                                            <button type="button"><i
                                                                    class="icon-search-2"></i></button>
                                                        </form>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="register">
                                                <ul class="flex align-center">
                                                    <li class="">
                                                        <a href="login.html"><i class="icon-user-1-1"></i>
                                                            <span>Sign in</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="{{ url('/assets/images/page/fl1.png') }}" alt="" class="fly-ab">
                    </div>
                </div>

                <!-- End Header Lower -->
                <a href="#" class="header-sidebar flex-three" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <i class="icon-Bars"></i>
                </a>

                <!-- Mobile Menu  -->
                <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
                <div class="mobile-menu">
                    <div class="menu-backdrop"></div>
                    <nav class="menu-box">
                        <div class="nav-logo"><a href="index.html">
                                <img src="{{ url('assets/images/logo2.png') }}" alt=""></a></div>
                        <div class="bottom-canvas">
                            <div class="menu-outer">
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- End Mobile Menu -->

            </header>
            <!-- End Main Header -->
