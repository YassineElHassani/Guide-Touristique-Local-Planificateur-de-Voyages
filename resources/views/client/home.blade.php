@extends('client.template')
@section('title', 'Home')

@section('content')

    <!-- End Main Header -->
    <main id="main">

        <section class="breadcumb-section">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12 center z-index1">
                        <h1 class="title"> Archieve Tour</h1>
                        <ul class="breadcumb-list flex-five">
                            <li><a href="index.html">Home</a></li>
                            <li><span>Tour Package</span></li>
                        </ul>
                        <img class="bcrumb-ab" src="./assets/images/page/mask-bcrumb.png" alt="">
                    </div>
                </div>

            </div>
        </section>

        <!-- Widget Select Form -->
        <div class="mt--82 z-index3 relative">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="search-form-widget-slider relative">
                            <form action="/" id="search-form-slider">
                                <div class="flex wd-search">
                                    <div class="form-group flex">
                                        <i class="icon-18"></i>
                                        <div class="search-bar-group">
                                            <label>Destination</label>
                                            <div class="nice-select" tabindex="0">
                                                <span class="current">Melborn ,Australia</span>
                                                <ul class="list">
                                                    <li data-value class="option selected">Melborn ,Australia
                                                    </li>
                                                    <li data-value="hanoi" class="option">HaNoi ,Vietnam</li>
                                                    <li data-value="tolyo" class="option">Tokyo , Janpan</li>
                                                    <li data-value="korea" class="option">Seoul , Korea</li>
                                                </ul>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="form-group flex">
                                        <i class="icon-hiking-1-1 "></i>
                                        <div class="search-bar-group">
                                            <label>Type</label>
                                            <div class="nice-select" tabindex="0">
                                                <span class="current">Booking Type</span>
                                                <ul class="list">
                                                    <li data-value class="option selected">Booking Type</li>
                                                    <li data-value="booking" class="option">Booking Type</li>
                                                    <li data-value="booking" class="option">Booking Type</li>
                                                    <li data-value="booking" class="option">Booking Type</li>
                                                </ul>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="form-group flex">
                                        <i class=" icon-time-left "></i>
                                        <div class="search-bar-group">
                                            <label>Duration</label>
                                            <div class="nice-select" tabindex="0">
                                                <span class="current">2-4 days tour</span>
                                                <ul class="list">
                                                    <li data-value class="option selected">2-4 days tour</li>
                                                    <li data-value="booking" class="option">3-6 days tour</li>
                                                    <li data-value="booking" class="option">4-8 days tour</li>
                                                    <li data-value="booking" class="option">5-10 days tour</li>
                                                </ul>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="form-group flex">
                                        <i class="icon-user"></i>
                                        <div class="search-bar-group">
                                            <label>Guests</label>
                                            <input type="text" value="0">
                                        </div>
                                    </div>
                                    <div class="form-group flex-two">
                                        <div class="icon-icon-filter">
                                            <i class="icon-14"></i>
                                        </div>
                                        <a href="#" class="btn-search"><i class="icon-Vector5"></i>Search</a>
                                    </div>
                                </div>
                                <div class="wd-search-form">
                                    <div class="input-group-grid">
                                        <fieldset class="group-select relative ">
                                            <label>Filter By Price</label>
                                            <div class="widget widget-price ">
                                                <div id="slider-range"></div>
                                                <div class="slider-labels">
                                                    <div>
                                                        <input type="hidden" name="min-value" value="">
                                                        <input type="hidden" name="max-value" value="">
                                                    </div>
                                                    <div class="caption flex-three">
                                                        <p class="price-range">Price: </p>
                                                        <div class="number-range">
                                                            <span id="slider-range-value1"></span>
                                                            <span id="slider-range-value2"></span>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div><!-- /.widget_price -->
                                        </fieldset>
                                        <fieldset class="group-select relative input-npd ">
                                            <div class="search-bar-group relative">
                                                <label>0</label>
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">English</span>
                                                    <ul class="list">
                                                        <li data-value="" class="option selected focus">Language</li>
                                                        <li data-value="language1" class="option">Japan</li>
                                                        <li data-value="language2" class="option">Vietnames</li>
                                                        <li data-value="language3" class="option">Korea</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="group-select relative input-npd ">
                                            <div class="search-bar-group relative">
                                                <label>Any</label>
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">Month</span>
                                                    <ul class="list">
                                                        <li data-value="" class="option selected focus">Month</li>
                                                        <li data-value="month1" class="option">1 Month</li>
                                                        <li data-value="month2" class="option">2 Month</li>
                                                        <li data-value="month3" class="option">3 Month</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset class="group-select relative input-npd">
                                            <div class="search-bar-group relative">
                                                <label>Any</label>
                                                <div class="nice-select" tabindex="0">
                                                    <span class="current">Duration</span>
                                                    <ul class="list">
                                                        <li data-value="" class="option selected focus">Duration</li>
                                                        <li data-value="duration1" class="option">10-15 day</li>
                                                        <li data-value="duration2" class="option">15-30 day</li>
                                                        <li data-value="duration3" class="option">20-30 day</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <div class="group-check-box-wrap">
                                            <div class="checkbox">
                                                <input id="check4" type="checkbox" name="check" value="check">
                                                <label for="check4">Accepts Credit Cards</label>
                                            </div>
                                            <div class="checkbox">
                                                <input id="check5" type="checkbox" name="check" value="check">
                                                <label for="check5">Car Parking</label>
                                            </div>
                                        </div>
                                        <div class="group-check-box-wrap">
                                            <div class="checkbox">
                                                <input id="check6" type="checkbox" name="check" value="check">
                                                <label for="check6">Free Coupons</label>
                                            </div>
                                            <div class="checkbox">
                                                <input id="check7" type="checkbox" name="check" value="check">
                                                <label for="check7">Laundry Service</label>
                                            </div>
                                        </div>
                                        <div class="group-check-box-wrap">
                                            <div class="checkbox">
                                                <input id="check8" type="checkbox" name="check" value="check">
                                                <label for="check8">Outdoor Seating</label>
                                            </div>
                                            <div class="checkbox">
                                                <input id="check9" type="checkbox" name="check" value="check">
                                                <label for="check9">Reservations</label>
                                            </div>
                                        </div>
                                        <div class="group-check-box-wrap">
                                            <div class="checkbox">
                                                <input id="check10" type="checkbox" name="check" value="check">
                                                <label for="check10">Restaurant</label>
                                            </div>
                                            <div class="checkbox">
                                                <input id="check11" type="checkbox" name="check" value="check">
                                                <label for="check11">Smoking Allowed</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Widget Select Form -->

        <!-- Widget archieve tour -->
        <section class="archieve-tour">
            <div class="tf-container">
                <div class="listing-list-car-wrap listing-list-car-wrap-grid3">
                    <form action="/" class="tf-my-listing mb-37">
                        <div class="row align-center">
                            <div class="col-sm-5">
                                <p class="showing">Showing <span class="text-main">12</span> of 21 Results</p>
                            </div>
                            <div class="col-sm-7  flex-six group-bar-wrap">
                                <div class="listing-all-wrap">
                                    <div class="flex-three">
                                        <div class="group-select-recently">
                                            <div class="nice-select" tabindex="0">
                                                <i class="icon-Vector6"></i><span class="current">Price</span>
                                                <ul class="list">
                                                    <li data-value="" class="option selected focus">Price</li>
                                                    <li data-value="new" class="option">New</li>
                                                    <li data-value="Recently Added" class="option">Recently Added
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="toolbar-list">
                                            <div class="form-group">
                                                <a class="btn-display-listing-grid">
                                                    <i class="icon-list"></i>
                                                </a>
                                            </div>
                                            <div class="form-group">
                                                <a class="btn-display-listing-list active">
                                                    <i class="icon-Group-1000001297"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="listing-list-car-grid mb-60">
                        <div class="tour-listing box-sd">
                            <a href="tour-single.html" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">Featured</span>
                                    <div class="badge-media flex-five">
                                        <span class="media"><i class="icon-Group-1000002909"></i>5</span>
                                        <span class="media"><i class="icon-Group-1000002910"></i>2</span>
                                    </div>
                                </div>
                                <img src="./assets/images/travel-list/1.jpg" alt="Image Listing">

                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>United States USA</span>
                                <h3 class="title-tour-list"><a href="tour-single.html">Days and 6 nights
                                        From Moscow</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <span>(1 Review)</span>
                                </div>
                                <div class="icon-box flex-three">
                                    <div class="icons flex-three">
                                        <i class="icon-time-left"></i>
                                        <span>5 days</span>
                                    </div>
                                    <div class="icons flex-three">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span>12 Person</span>
                                    </div>
                                </div>
                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p>From <span class="price-sale">$169.00</span></p>
                                        <span class="price">$199.00</span>
                                    </div>
                                    <div class="icon-bookmark">
                                        <i class="icon-Vector-151"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tour-listing box-sd">
                            <a href="tour-single.html" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">Featured</span>
                                    <div class="badge-media flex-five">
                                        <span class="media"><i class="icon-Group-1000002909"></i>5</span>
                                        <span class="media"><i class="icon-Group-1000002910"></i>2</span>
                                    </div>
                                </div>
                                <img src="./assets/images/travel-list/2.jpg" alt="Image Listing">

                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>United States USA</span>
                                <h3 class="title-tour-list"><a href="tour-single.html">Days and 6 nights
                                        From Moscow</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <span>(1 Review)</span>
                                </div>
                                <div class="icon-box flex-three">
                                    <div class="icons flex-three">
                                        <i class="icon-time-left"></i>
                                        <span>5 days</span>
                                    </div>
                                    <div class="icons flex-three">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span>12 Person</span>
                                    </div>
                                </div>
                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p>From <span class="price-sale">$169.00</span></p>
                                        <span class="price">$199.00</span>
                                    </div>
                                    <div class="icon-bookmark">
                                        <i class="icon-Vector-151"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tour-listing box-sd">
                            <a href="tour-single.html" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">Featured</span>
                                    <div class="badge-media flex-five">
                                        <span class="media"><i class="icon-Group-1000002909"></i>5</span>
                                        <span class="media"><i class="icon-Group-1000002910"></i>2</span>
                                    </div>
                                </div>
                                <img src="./assets/images/travel-list/3.jpg" alt="Image Listing">

                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>United States USA</span>
                                <h3 class="title-tour-list"><a href="tour-single.html">Days and 6 nights
                                        From Moscow</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <span>(1 Review)</span>
                                </div>
                                <div class="icon-box flex-three">
                                    <div class="icons flex-three">
                                        <i class="icon-time-left"></i>
                                        <span>5 days</span>
                                    </div>
                                    <div class="icons flex-three">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span>12 Person</span>
                                    </div>
                                </div>
                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p>From <span class="price-sale">$169.00</span></p>
                                        <span class="price">$199.00</span>
                                    </div>
                                    <div class="icon-bookmark">
                                        <i class="icon-Vector-151"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tour-listing box-sd">
                            <a href="tour-single.html" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">Featured</span>
                                    <div class="badge-media flex-five">
                                        <span class="media"><i class="icon-Group-1000002909"></i>5</span>
                                        <span class="media"><i class="icon-Group-1000002910"></i>2</span>
                                    </div>
                                </div>
                                <img src="./assets/images/travel-list/4.jpg" alt="Image Listing">

                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>United States USA</span>
                                <h3 class="title-tour-list"><a href="tour-single.html">Days and 6 nights
                                        From Moscow</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <span>(1 Review)</span>
                                </div>
                                <div class="icon-box flex-three">
                                    <div class="icons flex-three">
                                        <i class="icon-time-left"></i>
                                        <span>5 days</span>
                                    </div>
                                    <div class="icons flex-three">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span>12 Person</span>
                                    </div>
                                </div>
                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p>From <span class="price-sale">$169.00</span></p>
                                        <span class="price">$199.00</span>
                                    </div>
                                    <div class="icon-bookmark">
                                        <i class="icon-Vector-151"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tour-listing box-sd">
                            <a href="tour-single.html" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">Featured</span>
                                    <div class="badge-media flex-five">
                                        <span class="media"><i class="icon-Group-1000002909"></i>5</span>
                                        <span class="media"><i class="icon-Group-1000002910"></i>2</span>
                                    </div>
                                </div>
                                <img src="./assets/images/travel-list/5.jpg" alt="Image Listing">

                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>United States USA</span>
                                <h3 class="title-tour-list"><a href="tour-single.html">Days and 6 nights
                                        From Moscow</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <span>(1 Review)</span>
                                </div>
                                <div class="icon-box flex-three">
                                    <div class="icons flex-three">
                                        <i class="icon-time-left"></i>
                                        <span>5 days</span>
                                    </div>
                                    <div class="icons flex-three">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span>12 Person</span>
                                    </div>
                                </div>
                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p>From <span class="price-sale">$169.00</span></p>
                                        <span class="price">$199.00</span>
                                    </div>
                                    <div class="icon-bookmark">
                                        <i class="icon-Vector-151"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tour-listing box-sd">
                            <a href="tour-single.html" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">Featured</span>
                                    <div class="badge-media flex-five">
                                        <span class="media"><i class="icon-Group-1000002909"></i>5</span>
                                        <span class="media"><i class="icon-Group-1000002910"></i>2</span>
                                    </div>
                                </div>
                                <img src="./assets/images/travel-list/6.jpg" alt="Image Listing">

                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>United States USA</span>
                                <h3 class="title-tour-list"><a href="tour-single.html">Days and 6 nights
                                        From Moscow</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                    <span>(1 Review)</span>
                                </div>
                                <div class="icon-box flex-three">
                                    <div class="icons flex-three">
                                        <i class="icon-time-left"></i>
                                        <span>5 days</span>
                                    </div>
                                    <div class="icons flex-three">
                                        <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7"
                                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span>12 Person</span>
                                    </div>
                                </div>
                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p>From <span class="price-sale">$169.00</span></p>
                                        <span class="price">$199.00</span>
                                    </div>
                                    <div class="icon-bookmark">
                                        <i class="icon-Vector-151"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 ">
                            <ul class="tf-pagination flex-five mt-20">
                                <li>
                                    <a class="pages-link" href="#"> <i class="icon-29"></i></a>
                                </li>
                                <li>
                                    <a class="pages-link" href="#">1</a>
                                </li>
                                <li class="pages-item active" aria-current="page">
                                    <a class="pages-link" href="#">2</a>
                                </li>
                                <li><a class="pages-link" href="#">3</a></li>
                                <li>
                                    <a class="pages-link" href="#"><i class=" icon--1"></i></a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Widget archieve tour -->

        <!-- Widget About Us -->
        <section class="about-us-h3 pd-main about-us-archieve relative">
            <div class="bg-archieve-about"></div>
            <div class="tf-container ">
                <div class="row z-index3 relative">
                    <div class="col-md-6">
                        <div class="about-us-h3-image relative">
                            <img src="./assets/images/page/explore3.jpg" alt="image" class="image-explore">
                            <div class="about-vector">
                                <div class="icon">
                                    <svg width="257" height="125" viewBox="0 0 257 125" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M255.985 32.7066C255.566 32.1461 255.357 31.5857 254.938 31.0252C254.519 30.745 253.891 30.745 253.263 30.745C253.054 30.745 253.054 30.4648 252.844 30.4648C253.054 30.1845 253.263 29.9043 253.473 29.9043C253.682 29.6241 253.891 29.6241 254.101 29.3438C253.891 29.0636 253.891 28.7834 253.682 28.5031C253.473 28.2229 253.263 27.3822 252.635 27.9427C252.007 28.5031 251.379 28.7834 250.751 29.0636C249.285 29.9043 248.238 29.9043 247.61 27.9427C247.192 26.5415 246.564 25.4206 246.354 24.0194C246.354 22.338 245.307 21.7775 243.842 21.7775C243.214 21.7775 242.586 21.7775 241.958 22.6182C241.539 23.1787 240.911 22.8985 240.492 22.338C240.283 22.0578 240.073 21.7775 239.864 21.4973C239.445 20.6566 239.026 21.2171 238.608 21.4973C237.77 21.7775 238.189 20.3764 237.77 20.0961C237.561 19.8159 237.352 19.8159 236.933 19.8159C235.677 19.8159 234.839 19.5357 233.792 18.695C232.746 17.574 231.28 17.8543 230.443 17.0136C229.396 15.8926 228.349 15.3322 227.302 14.4915C225.836 16.1729 225.418 12.8101 224.162 13.0903C223.952 13.0903 223.743 12.8101 223.533 12.5298C222.696 11.6891 221.859 11.6891 221.23 12.5298C220.393 13.3705 219.765 11.4089 219.137 12.8101C219.137 12.8101 218.509 12.5298 218.09 12.2496C216.834 11.6891 215.787 10.8484 214.531 10.8484C213.275 10.8484 212.018 9.7275 210.553 9.7275C209.715 9.7275 208.878 9.7275 208.041 9.7275C206.994 9.7275 206.156 9.16704 206.156 8.0461C205.738 6.08447 205.319 6.92517 204.481 7.48564C204.063 7.76587 203.435 8.0461 203.016 8.32634C202.806 8.32634 202.388 8.60657 202.178 8.32634C201.76 7.2054 199.666 6.92517 200.503 4.68331C201.55 4.12284 200.503 3.56237 200.503 3.84261C199.247 6.64494 197.154 6.08447 195.269 5.80424C194.222 5.524 193.176 4.96354 192.338 4.12284C191.71 3.56237 191.291 3.84261 190.873 4.12284C190.454 4.68331 189.826 4.68331 189.407 4.12284C188.779 3.56237 188.151 3.28214 187.523 3.28214C186.057 3.28214 184.801 3.28214 183.336 3.28214C182.917 3.28214 182.707 3.00191 182.498 2.44144C181.661 2.44144 181.242 3.84261 180.195 3.56237C179.567 3.28214 178.73 3.28214 178.101 3.56237C176.636 5.24377 175.589 3.56237 174.333 3.56237C174.124 3.56237 174.124 3.00191 173.914 2.72167C173.705 2.16121 173.705 1.60074 173.077 2.16121C172.867 2.44144 172.449 3.00191 172.239 3.28214C171.821 3.84261 171.611 3.28214 171.402 2.72167C171.402 2.44144 171.402 1.88097 171.402 1.60074C171.402 1.32051 171.402 0.199575 170.774 1.04027C170.146 1.60074 169.727 2.16121 169.308 3.00191C168.471 3.84261 167.843 3.56237 167.005 3.28214C165.33 2.72167 163.865 2.16121 162.19 1.60074C160.515 1.04027 158.84 3.00191 157.165 1.60074C155.281 3.00191 153.187 2.72167 151.093 2.72167C150.675 2.72167 150.256 2.72167 149.837 3.00191C149.209 3.84261 148.372 3.56237 147.534 3.84261C146.487 3.84261 145.231 3.28214 144.394 4.40307C143.975 4.96354 143.766 4.12284 143.347 3.84261C142.928 3.28214 142.3 2.44144 141.672 3.56237C140.416 2.16121 138.95 2.72167 137.694 2.72167C136.019 2.72167 134.344 2.16121 132.879 3.56237C132.46 3.84261 131.832 3.56237 131.413 3.28214C130.785 2.72167 130.157 2.44144 129.529 3.28214C128.901 3.84261 128.273 4.12284 127.645 4.40307C127.017 4.96354 126.598 4.68331 126.179 4.12284C125.76 3.56237 125.551 4.12284 125.132 4.12284C121.364 5.80424 120.736 5.80424 117.386 5.80424C116.758 5.80424 116.339 5.524 115.92 5.24377C115.083 4.96354 114.664 6.3647 114.036 6.08447C113.617 5.80424 113.198 5.80424 112.78 5.80424C112.361 5.524 112.152 4.96354 111.733 5.52401C110.895 6.3647 109.849 6.08447 109.011 6.64494C107.964 7.48564 106.708 8.0461 105.452 8.0461C103.986 8.32634 102.312 8.0461 100.846 8.0461C100.427 8.0461 99.7992 7.2054 99.3805 7.48564C98.7524 7.76587 98.1243 8.32634 97.4962 8.32634C96.6587 8.32634 96.0306 9.7275 95.1932 9.44727C94.5651 9.16703 94.1464 10.8484 93.3089 10.0077C92.4714 9.16704 91.8433 10.8484 91.0059 10.5682C90.3778 10.288 89.5403 10.5682 88.9122 10.5682C88.0748 10.5682 87.4467 11.6891 86.6092 11.6891C84.9343 11.4089 83.4688 13.0903 81.7939 12.8101C80.5377 12.5298 79.7002 13.0903 78.8628 14.4915C78.8628 14.7717 78.2347 15.0519 78.0253 14.7717C76.5597 13.3705 75.5129 15.3322 74.0474 15.0519C72.7912 14.7717 71.3256 15.0519 69.8601 15.0519C69.0226 15.0519 68.1852 15.3322 67.5571 16.1729C66.7196 17.574 66.0915 17.2938 65.0447 16.4531C64.626 16.1729 63.7885 16.1729 63.5792 16.4531C62.323 17.8543 60.8574 17.2938 59.6012 17.2938C59.1825 17.2938 58.9731 16.7333 58.9731 16.1729C58.9731 15.6124 58.9731 15.0519 58.7638 14.4915C58.7638 13.931 58.5544 13.931 58.1357 14.2112C57.717 14.7717 57.0889 15.0519 57.717 16.4531C58.1357 17.574 57.9263 18.1345 57.0889 18.4147C56.8795 18.4147 56.4608 18.4147 56.2514 18.4147C55.2046 18.4147 55.2046 18.4147 54.7859 16.4531C54.7859 16.1729 54.7859 16.1729 54.7859 15.8926C54.3671 14.7717 53.739 13.931 52.9016 13.931C52.2735 13.931 52.0641 15.3322 52.4828 16.7333C52.4828 17.0136 52.6922 17.0136 52.6922 17.2938C52.9016 18.1345 52.4829 18.9752 51.8548 19.2554C51.436 19.5357 51.0173 19.5357 50.8079 18.9752C50.5986 18.4147 50.5986 17.8543 50.3892 17.574C49.5517 16.1729 49.133 16.1729 48.0862 17.8543C47.6675 18.4147 47.2487 18.695 46.6207 18.1345C45.7832 17.0136 44.7364 17.2938 43.8989 17.574C43.0615 17.8543 42.4334 18.695 42.224 19.8159C42.0146 19.8159 41.8053 19.5357 41.5959 19.5357C40.1304 18.4147 38.6648 17.8543 37.8273 20.6566L37.618 20.9368C37.1993 20.6566 36.7805 20.0961 36.1524 20.9368C35.315 22.0578 34.6869 23.1787 33.4307 21.4973C32.3839 21.4973 30.9183 20.0961 30.2902 22.6182C30.2902 22.8985 29.6621 23.1787 29.2434 23.1787C28.406 23.1787 27.5685 23.4589 26.731 23.1787C25.6842 23.1787 24.8468 24.5799 23.5906 24.2996C22.9625 24.2996 22.5438 25.1403 21.9157 25.981C20.2407 27.6624 18.7752 28.2229 16.0535 27.3822C15.6347 27.3822 15.216 27.3822 14.7973 27.3822C13.7505 27.3822 13.3317 28.2229 13.5411 29.6241C13.7505 30.1845 13.9598 30.4648 14.1692 31.0252C14.3785 31.8659 14.3785 32.4264 13.7505 32.7066C11.2381 34.388 9.56317 38.031 6.42271 38.5915C6.21334 38.5915 6.00398 39.152 6.00398 39.4322C5.79461 40.8334 3.4916 40.8334 4.1197 43.3555C4.1197 43.3555 3.4916 43.9159 3.07288 44.1962C2.23542 45.0369 1.39796 46.1578 0.769869 47.2787C-0.276952 49.8008 0.141776 51.202 2.23542 51.7625C3.07288 52.0427 3.91033 51.7625 4.74779 51.4822C5.79461 51.202 6.42271 50.9218 7.26016 50.9218C8.30698 50.9218 9.14444 50.6415 9.9819 49.8008C10.61 49.2404 11.2381 48.9601 11.8662 48.6799C12.0755 48.6799 12.2849 48.9601 12.4943 48.9601C12.4943 49.2404 12.2849 49.2404 12.2849 49.5206C11.8662 50.3613 11.2381 50.6415 10.61 50.9218C9.77254 51.4822 10.61 51.7625 10.8194 51.7625C11.2381 51.7625 11.6568 52.0427 11.6568 52.6032C11.8662 53.1636 11.4474 54.0043 10.61 54.0043C9.14444 53.7241 8.30698 55.1253 7.0508 55.1253C6.21334 55.1253 6.00398 55.6857 5.58525 56.8067C5.37588 57.6474 4.95716 58.2078 5.58525 59.0485C6.00398 59.609 6.00398 60.4497 6.21334 61.0102C6.84143 62.4113 6.21334 62.1311 6.00398 62.4113C5.79461 62.6916 5.37588 62.6916 5.37588 62.9718C5.16652 64.373 4.74779 65.4939 4.53843 66.6148C4.32906 68.016 4.53843 69.6974 4.53843 71.0986C4.53843 71.9393 4.95716 72.4997 5.37588 73.0602C5.79461 73.9009 5.79461 73.9009 4.74779 74.7416C4.32906 75.0218 4.32906 75.8625 4.53843 76.1427C4.95716 76.9834 5.37588 77.5439 6.00398 77.8242C7.0508 78.1044 6.84143 78.9451 6.42271 79.7858C6.21334 80.3463 6.00398 80.9067 6.63207 80.9067C7.26016 81.187 7.67889 81.4672 7.67889 82.3079C7.67889 83.1486 7.67889 83.709 8.09762 84.2695C8.72571 85.1102 9.35381 85.9509 9.9819 86.5114C10.61 87.3521 10.61 87.3521 11.6568 86.2311C11.8662 85.9509 12.2849 85.1102 12.4943 85.6707C12.913 86.7916 13.3317 87.3521 14.1692 87.9125C14.3785 87.9125 14.3785 88.473 13.9598 88.7532C12.913 89.0335 12.4943 89.5939 13.1224 90.9951C13.5411 91.8358 12.913 92.1161 12.7036 92.9568C12.7036 93.7975 12.7036 94.3579 12.7036 95.1986C12.2849 98.0009 13.3317 99.9626 15.0066 101.084C16.0535 101.644 16.4722 102.765 17.3096 103.325C17.9377 103.606 18.9846 103.045 19.4033 102.204C19.6127 101.924 19.6127 101.084 20.2407 101.644C20.8688 102.765 21.4969 104.166 22.125 105.287C22.9625 106.408 23.1718 106.688 24.2187 105.287C24.8468 104.727 25.0561 105.007 25.4749 105.287C26.1029 105.847 26.731 105.847 27.3591 105.287C27.7779 104.727 28.406 104.446 28.406 105.567C28.1966 107.809 29.4528 108.65 30.2902 109.49C30.9183 110.051 31.3371 108.65 32.1745 108.93C33.012 108.93 33.8494 108.93 34.4775 109.771C34.6869 110.051 34.8963 110.051 35.315 110.051C37.4086 110.331 37.618 110.331 38.2461 111.452C38.6648 112.013 38.6648 112.853 39.0835 113.414C39.5023 113.974 39.921 114.254 40.5491 114.254C40.7585 114.254 41.1772 113.974 41.5959 113.694C42.0146 113.414 42.224 112.573 42.6427 112.573C43.8989 112.293 43.6896 111.172 43.8989 110.051C43.8989 109.771 44.1083 109.49 44.3176 109.49C44.3176 109.49 44.527 109.771 44.7364 109.771C44.9457 109.771 44.9457 110.051 44.9457 110.051C45.3645 111.452 45.7832 112.853 46.4113 113.974C47.2487 115.375 48.9237 113.974 49.7611 115.375C49.9705 115.936 50.5986 115.936 50.8079 115.375C51.436 114.254 52.6922 114.815 52.9016 113.134C53.1109 112.013 54.1578 112.293 54.7859 112.573C55.2046 112.573 55.8327 113.414 56.2514 113.694C57.2982 113.974 56.8795 115.095 57.0889 115.936C57.717 116.216 58.1357 116.777 58.5544 117.617C57.717 118.738 58.1357 119.299 59.1825 119.579C60.2293 121.26 61.0668 119.859 62.1136 119.579C62.323 119.859 62.323 120.42 62.5323 120.42C63.3698 120.7 64.2073 120.7 65.0447 120.7C65.8822 120.7 66.3009 120.139 66.5103 119.299C66.7196 118.458 67.3477 118.458 67.9758 119.018C68.8133 120.139 69.8601 121.26 71.3256 121.26C72.1631 122.661 72.7912 120.7 73.4193 120.98C74.2567 121.541 74.8848 121.821 75.5129 120.7C76.141 119.579 76.7691 119.579 77.6066 120.42C78.0253 120.98 78.6534 120.98 79.0721 121.541C79.4908 122.101 79.9096 122.942 80.3283 122.942C80.747 122.942 81.1658 122.101 81.5845 121.541C82.0032 120.98 82.4219 121.541 82.6313 121.541C83.6781 121.26 84.725 120.7 85.5624 120.42C85.5624 119.018 86.3999 118.738 87.2373 118.458C87.4467 118.458 87.8654 117.897 87.8654 117.897C88.2841 118.178 88.7029 118.458 88.7029 119.018C89.1216 120.7 89.7497 121.541 91.0059 121.26C92.4714 120.7 93.3089 122.381 94.5651 122.381C95.8213 122.381 97.0774 121.821 98.1243 122.942C98.3336 123.222 98.543 123.502 98.7524 122.942C99.5898 121.821 100.637 122.381 101.474 122.101C102.73 122.101 105.452 121.26 106.499 120.42C106.708 120.139 106.918 120.139 107.127 120.42L109.43 121.26C110.267 122.101 111.314 122.661 112.361 123.222C112.989 123.502 113.617 123.222 113.827 122.381C114.036 121.541 114.245 120.98 114.873 120.98C115.92 121.26 116.548 119.859 117.595 119.579C118.223 119.579 118.642 118.458 119.479 118.458C120.736 118.458 120.526 119.859 121.154 120.7C121.992 121.541 123.039 122.381 123.876 123.222C124.714 124.063 125.132 124.063 125.97 123.502C126.807 122.661 128.273 123.222 128.901 121.541C129.11 120.98 129.11 120.42 129.529 120.139C130.157 119.859 130.366 120.7 130.785 120.98C131.413 121.821 132.251 122.942 132.879 123.782C133.088 124.063 133.507 124.063 133.716 124.063C134.135 123.782 134.344 123.222 134.763 123.222C135.182 123.222 135.391 124.063 136.229 123.502C137.275 122.661 138.322 122.381 139.369 123.222C139.997 123.782 140.416 123.502 140.625 122.942C141.044 122.381 141.463 121.821 142.3 122.381C142.928 122.942 143.766 122.942 144.603 122.101C145.65 121.26 146.906 120.98 147.116 118.738C147.116 118.178 148.162 118.178 148.581 118.738C149 119.299 149.209 119.859 149.628 120.42C150.256 122.101 151.303 123.222 152.35 124.623C152.559 124.903 152.768 124.623 152.978 124.063C152.978 123.782 153.187 122.942 153.187 123.222C153.815 123.222 154.653 124.063 154.862 122.101C154.862 121.541 155.281 120.7 155.699 120.139C156.118 119.299 157.165 119.018 157.793 119.579C158.212 119.859 158.421 120.139 158.84 120.7C159.468 121.821 160.096 121.541 160.934 120.7C161.98 119.859 162.608 120.139 163.237 121.541C163.655 122.381 163.865 122.661 164.493 122.381C165.33 121.821 166.168 120.98 167.005 120.42C167.633 120.139 168.261 120.139 168.889 120.7C169.308 121.26 169.727 121.821 170.146 122.101C170.564 122.381 170.983 120.98 171.402 121.821C171.82 122.381 172.449 122.661 172.867 122.101C173.705 120.7 174.961 120.139 176.008 119.579C177.264 119.018 178.73 119.299 179.986 118.178C180.195 117.897 180.823 118.178 181.242 118.458C182.079 119.018 182.707 119.299 183.336 119.859C184.173 120.42 184.592 120.139 185.22 119.579C186.267 117.617 187.732 116.777 189.616 117.057C190.663 117.057 191.082 117.897 191.71 118.738C191.919 119.299 192.129 119.579 192.338 120.139C192.966 119.859 192.757 119.018 192.757 118.178C192.757 117.617 192.757 117.057 192.757 116.496C192.966 115.936 193.385 115.656 193.594 115.375C194.013 114.815 194.222 115.375 194.641 115.656C195.06 115.936 195.479 115.936 195.897 115.656C196.316 115.375 196.316 114.815 196.944 115.375C198.2 116.496 199.247 116.496 199.875 114.254C199.875 113.974 200.294 113.974 200.503 113.694C200.922 113.414 201.132 113.134 200.713 112.573C200.294 112.013 199.875 111.732 199.247 111.452C198.41 110.611 198.41 109.771 199.247 108.93C200.294 107.529 201.76 108.65 202.597 107.249C203.016 107.529 203.644 107.809 204.063 108.089C204.481 108.37 205.319 108.37 205.738 108.089C206.575 106.968 207.203 108.089 207.831 108.37C208.041 108.65 208.041 109.21 208.25 109.21C209.087 109.21 209.925 109.491 210.762 109.21C211.181 109.21 211.181 108.93 210.972 108.37C210.344 107.249 209.715 105.847 208.878 105.007C208.041 104.166 206.994 103.606 205.738 103.606C205.319 103.606 205.109 103.045 204.691 102.485C204.481 102.204 204.481 101.924 204.691 101.644C205.109 101.364 206.366 101.084 207.622 101.364C208.041 101.364 208.669 101.644 208.878 101.364C209.715 100.243 210.972 100.243 212.018 100.523C213.275 100.523 214.531 100.523 215.787 100.523C216.206 100.523 216.624 100.243 216.834 99.9626C216.415 99.6823 216.206 99.4021 215.787 99.4021C215.578 99.4021 215.578 99.1219 215.578 99.1219L215.787 98.8416C217.253 98.8416 218.718 98.0009 220.184 97.4405C220.393 97.4405 220.393 97.4405 220.602 97.4405C221.23 97.4405 221.859 97.4405 222.068 98.0009C222.277 98.5614 222.277 99.1219 222.277 99.4021C223.534 99.4021 223.743 99.4021 223.743 98.0009C223.743 96.88 224.162 96.0393 224.58 95.7591C226.255 94.9184 227.302 92.9567 228.768 91.2753C230.024 89.8742 231.28 87.6323 233.374 89.3137C235.886 87.9125 238.817 88.473 240.911 85.3904C242.167 84.83 243.004 83.709 243.842 82.5881C244.889 80.9067 246.564 82.3079 247.82 81.4672C248.448 80.9067 249.285 80.9067 249.704 79.7858C249.076 78.6649 249.285 78.3846 250.332 78.1044C252.216 77.8242 253.682 76.423 254.729 74.4614C254.938 74.1811 254.938 73.6207 254.938 73.3404C254.729 72.4997 254.519 71.659 254.101 70.8183C253.682 69.9776 253.263 69.4172 252.844 68.5765C252.426 68.016 253.682 67.1753 252.844 66.3346C251.588 65.4939 252.844 63.8125 252.007 62.6916C251.798 62.4113 251.798 61.5706 252.007 61.0102C252.844 59.0485 253.054 56.8067 252.007 54.845C251.588 54.0043 252.007 53.4439 252.216 52.8834C252.635 52.0427 252.844 50.9218 253.054 50.0811C252.426 49.5206 251.798 49.2404 251.17 48.6799C250.96 48.3997 250.541 48.3997 250.332 48.3997C249.913 48.1194 249.913 47.8392 250.332 47.559C251.588 46.7183 253.054 45.8776 254.31 45.0369C254.938 44.4764 254.519 44.1962 254.101 43.9159C253.473 43.6357 253.263 43.0752 253.263 42.2345C253.263 41.6741 253.473 41.1136 253.682 40.8334C253.891 41.1136 254.101 41.1136 254.31 41.3938C254.729 41.3938 255.566 40.5531 255.566 40.2729C255.566 39.9927 255.357 39.7124 255.147 39.7124C254.101 38.5915 253.891 38.3113 254.729 37.1903C255.148 36.6299 255.776 35.7892 256.194 35.2287C256.404 34.6682 255.147 33.2671 255.985 32.7066ZM42.6427 20.3764C42.4334 20.3764 42.224 20.3764 42.224 20.0961C42.224 20.0961 42.224 19.8159 42.224 19.5357C42.224 19.5357 42.224 19.5357 42.224 19.8159C42.4334 19.8159 42.6427 20.0961 42.8521 20.0961C42.6427 20.0961 42.6427 20.3764 42.6427 20.3764ZM47.4581 20.3764L47.2487 20.0961C47.2487 20.0961 47.2487 20.0961 47.2487 19.8159C47.2487 19.8159 47.2487 19.8159 47.2487 19.5357H47.4581C47.8768 20.0961 47.8768 20.3764 47.4581 20.3764ZM62.7417 119.299C62.7417 119.579 62.5323 119.579 62.323 119.579C62.323 119.579 62.323 119.579 62.1136 119.579C62.1136 119.579 62.1136 119.579 62.323 119.579C62.323 119.299 62.5323 119.018 62.5323 118.738H62.7417C62.9511 119.018 62.7417 119.018 62.7417 119.299ZM201.76 101.364C201.341 101.364 201.132 101.364 201.132 100.803C201.132 100.523 201.55 100.523 201.76 100.523C201.969 100.523 202.178 100.803 202.388 101.084C202.178 101.084 201.969 101.364 201.76 101.364ZM207.831 107.529C208.041 107.249 208.25 107.529 208.041 107.809C207.831 108.089 207.622 108.089 207.412 108.089C207.622 108.089 207.622 107.529 207.831 107.529Z"
                                            fill="#4DA528" />
                                    </svg>
                                </div>
                                <span class="font-yes text-white">Never stop Exploring</span>
                            </div>
                            <p class=" center"><span class="text-main">2,500</span> people booked
                                Tommorow land Event in last 24 hours</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about-us-h3-content">
                            <div class="mb-18">
                                <span class="sub-title-heading text-main font-yes fs-28-46">Explore the
                                    world</span>
                                <h2 class="title-heading mb-18">Great opportunity for <span class="booking-title">
                                        <span class="booking">adventure <span class="dot"></span></span></span>
                                    & travels</h2>
                                <p class="des">Welcome to our Print 128 website! We are a professional and
                                    reliable printing
                                    company that offers a wide range of printing services to</p>
                            </div>
                            <p class="text-main ranger-suport mb-32">a range of programs and supports in the
                                disability including:</p>

                            <ul class="list-icon mb-37">
                                <li>
                                    <i class="icon-Group-13"></i>
                                    <span>Discover great deals on hotel around the
                                        world</span>
                                </li>
                                <li>
                                    <i class="icon-Group-13"></i>
                                    <span>Our tours are designed withpeople</span>
                                </li>
                                <li>
                                    <i class="icon-Group-13"></i>
                                    <span>Let your local host tailor the tourcompletely to
                                        your wish.</span>
                                </li>
                            </ul>

                            <div class="about-wrap flex-three">
                                <div class="image-list flex-three">
                                    <img src="./assets/images/avata/6.jpg" alt="Image" class="item">
                                    <img src="./assets/images/avata/5.jpg" alt="Image" class="item">
                                    <img src="./assets/images/avata/4.jpg" alt="Image" class="item">
                                    <img src="./assets/images/avata/3.jpg" alt="Image" class="item">
                                    <img src="./assets/images/avata/1.jpg" alt="Image" class="item">
                                    <img src="./assets/images/avata/2.jpg" alt="Image" class="item">
                                    <div class="icon text-white item flex-five">
                                        <i class="icon-uniE914"></i>
                                    </div>
                                </div>
                                <a href="#" class="btn-main">
                                    <p class="btn-main-text">More about us</p>
                                    <p class="iconer">
                                        <i class="icon-arrow-right"></i>
                                    </p>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Widget About Us -->

        <section class="mb--93">
            <div class="tf-container">
                <div class="callt-to-action flex-two">
                    <div class="callt-to-action-content flex-three">
                        <div class="image">
                            <img src="./assets/images/page/ready.png" alt="Image">
                        </div>
                        <div class="content">
                            <h2 class="title-call">Ready to adventure and enjoy natural</h2>
                            <p class="des">Lorem ipsum dolor sit amet, consectetur notted adipisicin</p>
                        </div>
                    </div>
                    <img src="./assets/images/page/vector4.png" alt="" class="shape-ab">
                    <div class="callt-to-action-button">
                        <a href="#" class="get-call">Let,s get started</a>
                    </div>
                </div>
            </div>

        </section>

    </main>

@endsection
