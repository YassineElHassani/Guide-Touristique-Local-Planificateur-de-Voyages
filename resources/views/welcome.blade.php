@extends('template')
@section('title', 'Home Page')

@section('content')

    <main id="main">

        <!-- Widget Slider -->
        <section class="slider-home4 relative">
            <div class="tf-container">
                <div class="row ">
                    <div class="col-10 col-xl-7">
                        <div class="home4-content z-index3">
                            <span class="sub-title font-yes text-second fs-28-46 wow fadeInUp animated">Explore
                                the world</span>
                            <h1 class="title-slide text-white mb-40 wow fadeInUp animated">Adventure
                                <span class="animationtext clip text-main">
                                    <span class="cd-words-wrapper">
                                        <span class="item-text is-visible">Tour</span>
                                        <span class="item-text is-hidden">Tour</span>
                                    </span>
                                </span>
                                Camping start With Us
                            </h1>
                            <div class="btn-group">
                                <a href="{{ route('login')}}" class="btn-main wow fadeInUp animated">
                                    <p class="btn-main-text">Let,s get started</p>
                                    <p class="iconer">
                                        <i class="icon-arrow-right"></i>
                                    </p>
                                </a>
                                <a href="#" class="btn-w-wa text-main wow fadeInUp animated">Beautiful Places
                                    Arround the World.</a>
                            </div>
                        </div>

                    </div>
                    <div class="col-2 col-xl-5 relative">
                        <div class="video-wrap">
                            <a href="https://www.youtube.com/watch?v=n9LgeoJE4EI"
                                class="widget-icon-video widget-videos flex-five z-index3">
                                <i class="icon-Polygon-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mask-slider">
                    <img src="./assets/images/slide/mask-home4.png" alt="Image" class="mask-slider1">
                </div>
            </div>

        </section>
        <!-- Widget Slider -->

        <!-- Widget Select Form -->
        <div class="mt--50 z-index3 relative wow fadeInUp animated">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="search-form-widget-slider bg-white relative">
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

        <!-- Widget About Us -->
        <section class="about-us-h4">
            <div class="tf-container">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="image-about-h4-wrap relative">
                            <div class="image-about-item relative about-wrap-left wow fadeInLeft animated "
                                data-wow-delay="0.1s">
                                <img src="./assets/images/about-us/about-h41.jpg" alt="image">
                                <img src="./assets/images/page/shape5.1.png" alt="image" class="shape-about-h4">
                                <span class="quote">25,000 + Customer Worldwide</span>

                            </div>
                            <div class="image-about-item relative about-wrap-right wow fadeInUp animated "
                                data-wow-delay="0.1s">
                                <img src="./assets/images/about-us/about-h4.jpg" alt="image">
                                <img src="./assets/images/page/shape5.1.png" alt="image" class="shape-about-h4">

                            </div>
                            <div class="box-year center wow zoomIn animated " data-wow-delay="0.1s">
                                <span class="number">25</span>
                                <p>year of <br> experience</p>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-12 col-lg-6 inner-content-about">
                        <div class="mb-30">
                            <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Explore
                                the
                                world</span>
                            <h2 class="title-heading mb-18 wow fadeInUp animated">Great opportunity for <span
                                    class="text-gray font-yes">adventure</span> & travels </h2>
                            <p class="des wow fadeInUp animated">Welcome to our Print 128 website! We are a
                                professional and reliable
                                printing
                                company that offers a wide range of printing services to</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="icon-box-style6">
                                    <div class="icon relative">
                                        <i class="icon-Group2"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title-icon wow fadeInUp animated"><a href="#">Trusted travel
                                                guide</a></h6>
                                        <p class="des-icon wow fadeInUp animated">Welcome to our Print 128
                                            wesit!
                                            company that offers a wide r</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="icon-box-style6">
                                    <div class="icon relative">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_214_218" style="mask-type:luminance"
                                                maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                                                <path d="M0 0H40V40H0V0Z" fill="white" />
                                            </mask>
                                            <g mask="url(#mask0_214_218)">
                                                <path d="M20 23.125V38.8281H38.8281V12.2656H34.1406" stroke="currentColor"
                                                    stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M5.85938 12.2656H1.17188V38.8281H20V23.2031" stroke="currentColor"
                                                    stroke-width="2" stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M26.9598 9.14062H34.1406V34.1406H26.5035C23.5528 34.1406 20.933 36.0287 20 38.8281"
                                                    stroke="currentColor" stroke-width="2" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M13.0402 9.14062H5.85938V34.1406H13.4965C16.4472 34.1406 19.067 36.0287 20 38.8281"
                                                    stroke="currentColor" stroke-width="2" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M19.9999 1.17188C14.6972 1.17188 11.311 6.82758 13.815 11.5017L19.9999 23.0469L26.1848 11.5017C28.6888 6.82758 25.3025 1.17188 19.9999 1.17188Z"
                                                    stroke="currentColor" stroke-width="2" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M22.3438 8.20312C22.3438 9.4975 21.2944 10.5469 20 10.5469C18.7056 10.5469 17.6562 9.4975 17.6562 8.20312C17.6562 6.90875 18.7056 5.85937 20 5.85937C21.2944 5.85937 22.3438 6.90875 22.3438 8.20312Z"
                                                    stroke="currentColor" stroke-width="2" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="content">
                                        <h6 class="title-icon wow fadeInUp animated"><a href="#">Pesonalized
                                                Trips</a></h6>
                                        <p class="des-icon wow fadeInUp animated">Welcome to our Print 128
                                            wesit!
                                            company that offers a wide r</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-three btn-wrap-about  mb-30 ">
                            <a href="#" class="btn-main wow fadeInUp animated">
                                <p class="btn-main-text">More about us</p>
                                <p class="iconer">
                                    <i class="icon-arrow-right"></i>
                                </p>

                            </a>
                            <div class="profile flex-three wow fadeInUp animated">
                                <div class="image">
                                    <img src="./assets/images/avata/10.jpg" alt="">
                                </div>
                                <div class="content">
                                    <img src="./assets/images/page/name.png" alt="">
                                    <span class="text-main">Ceo & Founder</span>
                                </div>
                            </div>
                        </div>
                        <div class="map-check flex-three wow fadeInUp animated">
                            <div class="icon">
                                <svg width="33" height="30" viewBox="0 0 33 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_321_31)">
                                        <path
                                            d="M24.3102 0.240601C26.0182 0.240601 27.5818 0.938222 28.7124 2.04479C29.819 3.17542 30.5166 4.73906 30.5166 6.44703C30.5166 7.45738 30.2761 8.39556 29.8671 9.23751C29.0733 10.8252 25.0078 13.6157 24.3102 16.6467C23.1555 13.7119 19.5471 10.8252 18.7533 9.23751C18.3203 8.39556 18.0797 7.45738 18.0797 6.44703C18.0797 3.00703 20.8702 0.240601 24.3102 0.240601Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M24.3102 3.29565C26.0181 3.29565 27.3893 4.6909 27.3893 6.37481C27.3893 8.08278 26.0181 9.45397 24.3102 9.45397C22.6022 9.45397 21.231 8.08278 21.231 6.37481C21.231 4.6909 22.6022 3.29565 24.3102 3.29565Z"
                                            fill="#FEFEFE"></path>
                                        <path
                                            d="M9.44363 6.78381C11.8011 6.78381 13.894 7.72199 15.4336 9.26157C16.9731 10.8012 17.9113 12.9181 17.9113 15.2515C17.9113 16.5986 17.5986 17.8976 17.0212 19.0283C15.9387 21.1933 10.4299 24.9941 9.44363 29.1077C7.87999 25.1144 2.97259 21.1933 1.89007 19.0283C1.31273 17.8976 1 16.5986 1 15.2515C1 10.5606 4.77678 6.78381 9.44363 6.78381Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M9.4436 10.9695C11.777 10.9695 13.6534 12.8458 13.6534 15.1552C13.6534 17.4646 11.777 19.3409 9.4436 19.3409C7.13424 19.3409 5.25787 17.4646 5.25787 15.1552C5.25787 12.8458 7.13424 10.9695 9.4436 10.9695Z"
                                            fill="#FEFEFE"></path>
                                        <path
                                            d="M11.8011 29.8293C11.6808 29.8053 11.5846 29.685 11.6086 29.5647C11.6327 29.4204 11.753 29.3482 11.8732 29.3723H11.8973H11.9454H11.9695H12.0176L12.0416 29.3963H12.0897H12.1138H12.1379H12.186L12.21 29.4204H12.2581H12.2822H12.3303C12.4506 29.4444 12.5468 29.5647 12.5468 29.685C12.5228 29.8053 12.4025 29.9015 12.2822 29.9015V29.8774H12.2341H12.186H12.1619H12.1138H12.0897L12.0416 29.8534H12.0176H11.9695H11.9454L11.8973 29.8293H11.8732H11.8251H11.8011ZM24.1177 17.1037C24.1658 16.9835 24.2861 16.9113 24.4064 16.9594C24.5267 17.0075 24.5988 17.1519 24.5507 17.2721V17.2962L24.5267 17.3202V17.3443C24.4785 17.4646 24.3583 17.5127 24.2139 17.4646C24.0937 17.4405 24.0455 17.2962 24.0937 17.1759V17.1519V17.1278H24.1177V17.1037ZM23.4923 18.3787C23.5644 18.2825 23.7088 18.2584 23.805 18.3306C23.9253 18.3787 23.9493 18.523 23.8771 18.6433V18.6674L23.8531 18.6914V18.7155H23.829V18.7395H23.805V18.7636V18.7877H23.7809V18.8117L23.7569 18.8358L23.7328 18.8598V18.8839H23.7088V18.9079L23.6847 18.932V18.956H23.6606V18.9801H23.6366V19.0042L23.6125 19.0282V19.0523C23.5163 19.1485 23.372 19.1726 23.2758 19.0763C23.1795 19.0042 23.1555 18.8598 23.2276 18.7636V18.7395H23.2517V18.7155H23.2758V18.6914L23.2998 18.6674L23.3239 18.6433V18.6193H23.3479V18.5952H23.372V18.5712V18.5471H23.396V18.523L23.4201 18.499L23.4441 18.4749V18.4509H23.4682V18.4268V18.4028H23.4923V18.3787ZM22.2654 19.6537C22.3857 19.5815 22.53 19.6296 22.6022 19.7258C22.6503 19.8461 22.6262 19.9905 22.53 20.0626H22.506H22.4819V20.0867H22.4578L22.4338 20.1107H22.4097L22.3857 20.1348H22.3616V20.1588H22.3376H22.3135V20.1829H22.2895V20.207H22.2654H22.2413V20.231H22.2173H22.1932V20.2551H22.1692H22.1451V20.2791H22.1211H22.097V20.3032C21.9767 20.3513 21.8324 20.3032 21.7843 20.1829C21.7121 20.0626 21.7602 19.9183 21.8805 19.8702H21.9046V19.8461H21.9286H21.9527L21.9767 19.8221H22.0008V19.798H22.0248H22.0489V19.7739H22.073L22.097 19.7499H22.1211L22.1451 19.7258H22.1692V19.7018H22.1932H22.2173V19.6777H22.2413L22.2654 19.6537ZM20.6055 20.3272C20.7258 20.2791 20.8461 20.3513 20.8942 20.4956C20.9183 20.6159 20.8461 20.7362 20.7258 20.7602L20.7018 20.7843H20.6777H20.6537H20.6296V20.8084H20.6055H20.5815H20.5574H20.5334V20.8324H20.5093H20.4853H20.4612H20.4372V20.8565H20.4131H20.389H20.365H20.3409V20.8805H20.3169H20.2928H20.2688C20.1485 20.9286 20.0041 20.8324 19.9801 20.7121C19.956 20.5918 20.0282 20.4716 20.1485 20.4235H20.1725H20.1966H20.2206L20.2447 20.3994H20.2688H20.2928H20.3169L20.3409 20.3753H20.365H20.389H20.4131L20.4372 20.3513H20.4612H20.4853H20.5093L20.5334 20.3272H20.5574H20.5815H20.6055ZM18.7773 21.073C18.8735 20.9767 19.0179 20.9767 19.1141 21.073C19.2103 21.1692 19.1862 21.3135 19.1141 21.4098H19.09L19.066 21.4338V21.4579H19.0419L19.0179 21.4819V21.506H18.9938V21.53H18.9697V21.5541L18.9457 21.5781V21.6022H18.9216V21.6263L18.8976 21.6503V21.6744H18.8735V21.6984V21.7225C18.8014 21.8187 18.657 21.8668 18.5608 21.8187C18.4405 21.7465 18.3924 21.6022 18.4405 21.506L18.4646 21.4819V21.4579L18.4886 21.4338V21.4098L18.5127 21.3857L18.5367 21.3616V21.3376L18.5608 21.3135L18.5848 21.2895L18.6089 21.2654V21.2414H18.633V21.2173L18.657 21.1932V21.1692H18.6811V21.1451H18.7051L18.7292 21.1211L18.7532 21.097L18.7773 21.073ZM18.4886 23.0696C18.4165 22.9493 18.4646 22.805 18.5848 22.7569C18.6811 22.6847 18.8254 22.7328 18.8976 22.8531V22.8772H18.9216V22.9012V22.9253H18.9457V22.9493L18.9697 22.9734V22.9974H18.9938V23.0215L19.0179 23.0456V23.0696H19.0419V23.0937L19.066 23.1177L19.09 23.1418L19.1141 23.1658V23.1899C19.2103 23.2861 19.2103 23.4304 19.1141 23.5267C19.0179 23.5988 18.8735 23.5988 18.7773 23.5026L18.7532 23.4786L18.7292 23.4545L18.7051 23.4304V23.4064L18.6811 23.3823L18.657 23.3583L18.633 23.3342V23.3102L18.6089 23.2861L18.5848 23.2621V23.238L18.5608 23.2139L18.5367 23.1899V23.1658L18.5127 23.1418V23.1177L18.4886 23.0937V23.0696ZM20.1485 24.1762C20.0041 24.1521 19.932 24.0318 19.956 23.9116C19.9801 23.7913 20.1004 23.6951 20.2206 23.7191H20.2447H20.2688V23.7432H20.2928H20.3169H20.3409H20.365H20.389H20.4131L20.4372 23.7672H20.4612H20.4853H20.5093H20.5334H20.5574H20.5815L20.6055 23.7913H20.6296H20.6537H20.6777C20.798 23.8153 20.8942 23.9116 20.8702 24.0559C20.8702 24.1762 20.7499 24.2724 20.6055 24.2483H20.5815H20.5574H20.5334H20.5093H20.4853V24.2243H20.4612H20.4372H20.4131H20.389H20.365H20.3409H20.3169L20.2928 24.2002H20.2688H20.2447H20.2206H20.1966H20.1725L20.1485 24.1762ZM22.0248 24.3927C21.9046 24.3686 21.8083 24.2724 21.8083 24.1281C21.8083 24.0078 21.9286 23.9116 22.0489 23.9116H22.073H22.097H22.1211H22.1451L22.1692 23.9356H22.1932H22.2173H22.2413H22.2654H22.2895H22.3135H22.3376H22.3616H22.3857H22.4097H22.4338H22.4578H22.4819H22.506L22.53 23.9597C22.6503 23.9597 22.7465 24.0559 22.7465 24.2002C22.7465 24.3205 22.6262 24.4167 22.506 24.4167H22.4819H22.4578H22.4338H22.4097H22.3857H22.3616H22.3376L22.3135 24.3927H22.2895H22.2654H22.2413H22.2173H22.1932H22.1692H22.1451H22.1211H22.097H22.073H22.0489H22.0248ZM23.9012 24.4889C23.7569 24.4889 23.6606 24.3686 23.6847 24.2483C23.6847 24.1281 23.805 24.0318 23.9253 24.0318H23.9734H24.0215L24.0937 24.0559H24.1658H24.2139H24.2861L24.3583 24.08H24.4064C24.5267 24.104 24.6229 24.2002 24.6229 24.3446C24.5988 24.4649 24.4785 24.5611 24.3583 24.537H24.3102H24.238L24.1899 24.513H24.1177H24.0455H23.9974H23.9253L23.9012 24.4889ZM25.7054 24.8016C25.5611 24.7776 25.4889 24.6332 25.537 24.513C25.5611 24.3927 25.7054 24.3205 25.8257 24.3686H25.8978L25.946 24.3927L25.9941 24.4167H26.0422L26.0903 24.4408L26.1384 24.4649H26.1865L26.2346 24.4889L26.2827 24.513C26.403 24.5611 26.4752 24.7054 26.4271 24.8257C26.379 24.946 26.2346 24.9941 26.1143 24.946L26.0662 24.9219H26.0181L25.9941 24.8979H25.946L25.8978 24.8738L25.8497 24.8497H25.8016L25.7535 24.8257L25.7054 24.8016ZM27.2931 25.5714C27.1969 25.4993 27.1728 25.3549 27.245 25.2587C27.3412 25.1384 27.4855 25.1384 27.5818 25.2106L27.6058 25.2346L27.6299 25.2587L27.678 25.2828L27.702 25.3068L27.7261 25.3309L27.7502 25.3549L27.7742 25.379L27.8223 25.403L27.8464 25.4271L27.8704 25.4752L27.8945 25.4993L27.9185 25.5233L27.9426 25.5474L27.9667 25.5714C28.0388 25.6676 28.0388 25.812 27.9426 25.8842C27.8464 25.9804 27.702 25.9804 27.6058 25.8842V25.8601L27.5818 25.836L27.5577 25.812L27.5336 25.7879L27.5096 25.7639L27.4855 25.7398H27.4615L27.4374 25.7158L27.4134 25.6917L27.3893 25.6676L27.3653 25.6436L27.3412 25.6195L27.3171 25.5955L27.2931 25.5714ZM28.0148 26.9667C28.0388 26.8464 28.135 26.7502 28.2794 26.7742C28.3997 26.7742 28.4959 26.8945 28.4718 27.0388V27.0629V27.0869L28.4478 27.1351V27.1591V27.1832V27.2072L28.4237 27.2553V27.2794L28.3997 27.3034V27.3516V27.3756L28.3756 27.3997V27.4237L28.3515 27.4718V27.4959L28.3275 27.52V27.544C28.2553 27.6643 28.111 27.7124 27.9907 27.6643C27.8945 27.5921 27.8464 27.4478 27.8945 27.3275L27.9185 27.3034V27.2794L27.9426 27.2553V27.2313V27.2072L27.9667 27.1832V27.1591V27.1351L27.9907 27.111V27.0869V27.0629V27.0388L28.0148 27.0148V26.9907V26.9667ZM27.0044 28.2176C27.1247 28.1695 27.269 28.1935 27.3171 28.3138C27.3893 28.41 27.3653 28.5544 27.245 28.6265L27.1969 28.6506L27.1488 28.6746L27.1247 28.6987L27.0766 28.7227L27.0285 28.7468L27.0044 28.7709L26.9563 28.7949L26.9082 28.819L26.8601 28.843L26.812 28.8671C26.6917 28.9152 26.5474 28.8671 26.4992 28.7468C26.4511 28.6265 26.4992 28.4822 26.6195 28.4341L26.6676 28.41L26.6917 28.386L26.7398 28.3619H26.7879L26.812 28.3379L26.8601 28.3138L26.8841 28.2897L26.9323 28.2657L26.9563 28.2416H27.0044V28.2176ZM25.3205 28.8671C25.4648 28.843 25.5851 28.9152 25.6092 29.0355C25.6332 29.1798 25.5611 29.3001 25.4408 29.3241L25.3927 29.3482H25.3446L25.2724 29.3723H25.2243L25.1521 29.3963H25.0799L25.0318 29.4204H24.9597C24.8394 29.4444 24.7191 29.3723 24.695 29.252C24.671 29.1076 24.7672 28.9874 24.8875 28.9633H24.9356L25.0078 28.9393H25.0559L25.1281 28.9152H25.1762L25.2243 28.8911H25.2964L25.3205 28.8671ZM23.5163 29.1558C23.6366 29.1317 23.7569 29.2279 23.7569 29.3723C23.7809 29.4925 23.6847 29.6128 23.5644 29.6128H23.5163H23.4682L23.4201 29.6369H23.396H23.3479H23.2998H23.2517H23.2036L23.1555 29.6609H23.1314H23.0833C22.963 29.6609 22.8427 29.5647 22.8427 29.4444C22.8187 29.3241 22.9149 29.2039 23.0352 29.1798H23.0833H23.1314H23.1795H23.2036H23.2517H23.2998L23.3479 29.1558H23.396H23.4201H23.4682H23.5163ZM21.6399 29.3001C21.7843 29.3001 21.8805 29.3963 21.9046 29.5166C21.9046 29.6609 21.8083 29.7572 21.6881 29.7812H21.6399H21.5918H21.5437H21.4956H21.4475L21.3994 29.8053H21.3513H21.3032H21.2551H21.2069C21.0867 29.8293 20.9664 29.709 20.9664 29.5888C20.9664 29.4685 21.0626 29.3482 21.1829 29.3482H21.231L21.2791 29.3241H21.3272H21.3753H21.4234H21.4716H21.5197H21.5678L21.6159 29.3001H21.6399ZM19.7876 29.4444C19.9079 29.4204 20.0282 29.5166 20.0282 29.6609C20.0282 29.7812 19.932 29.9015 19.8117 29.9015H19.7636H19.7155H19.6674H19.6193L19.5471 29.9255H19.499H19.4509H19.4027H19.3546H19.3306C19.2103 29.9255 19.09 29.8293 19.09 29.709C19.09 29.5647 19.1862 29.4685 19.3065 29.4685H19.3306L19.3787 29.4444H19.4268H19.4749H19.523H19.5711H19.6433H19.6914H19.7395H19.7876ZM17.9113 29.5166C18.0316 29.5166 18.1518 29.6128 18.1518 29.7572C18.1518 29.8774 18.0556 29.9977 17.9353 29.9977H17.9113H17.8632H17.8151H17.7669H17.7188H17.6707H17.6226H17.5504H17.5023H17.4542C17.3339 30.0218 17.2137 29.9015 17.2137 29.7812C17.2137 29.6609 17.3099 29.5406 17.4542 29.5406H17.5023H17.5504H17.5986H17.6467H17.6948H17.7429H17.791L17.8391 29.5166H17.9113ZM16.0349 29.5647C16.1793 29.5647 16.2755 29.685 16.2755 29.8053C16.2755 29.9255 16.1793 30.0458 16.059 30.0458H15.9868H15.9387H15.8906H15.8425H15.7944H15.7462H15.6981H15.65H15.6019H15.5779C15.4576 30.0458 15.3373 29.9496 15.3373 29.8053C15.3373 29.685 15.4576 29.5647 15.5779 29.5647H15.6019H15.65H15.6981H15.7462H15.7944H15.8425H15.8906H15.9387H15.9868H16.0349ZM14.1826 29.5647C14.3029 29.5647 14.3991 29.6609 14.3991 29.8053C14.3991 29.9255 14.3029 30.0218 14.1586 30.0218H14.1345H14.0864H14.0623H14.0142H13.9661H13.918H13.8699L13.8218 29.9977H13.7977H13.7496H13.7015C13.5572 29.9977 13.4609 29.8774 13.4609 29.7572C13.485 29.6369 13.5812 29.5166 13.7256 29.5406H13.7737H13.7977H13.8458H13.8939H13.9421H13.9902H14.0142H14.0623H14.1104L14.1586 29.5647H14.1826Z"
                                            fill="#FF190B"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_321_31">
                                            <rect width="33" height="30" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <span class="text-main">Checkout Beautiful Places Arround the World.</span>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- Widget About Us -->

        <!-- Widget activities -->
        <section class="populer-activities-section bg-1">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-30 center">
                            <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Populer
                                Activities</span>
                            <h2 class="title-heading wow fadeInUp animated">Explore Real Adventure</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 relative populer-activities-slide">
                        <div class="swiper populer-activities overflow-hidden">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb1.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-Group"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Couple camping</a></h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb2.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-Group-1"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Trailers and rv
                                                    spots</a></h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb3.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-bicyclist-1"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Mountain Biking</a></h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb4.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-fishing-2"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Fishing & Swimming</a>
                                            </h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb1.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-Group"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Couple camping</a></h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb2.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-Group-1"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Trailers and rv
                                                    spots</a></h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb3.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-bicyclist-1"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Mountain Biking</a></h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="tf-widget-populer">
                                        <div class="image relative">
                                            <img src="./assets/images/image-box/imb4.jpg" alt="Image">
                                            <img src="./assets/images/image-box/mask-box.png" alt="Image"
                                                class="mask-populer">
                                        </div>
                                        <div class="content relative center">
                                            <div class="icon flex-five">
                                                <i class="icon-fishing-2"></i>
                                            </div>
                                            <h5 class="title-populer mb-18"><a href="#">Fishing & Swimming</a>
                                            </h5>
                                            <p class="des-populer">Welcome to our Print 128 website company that
                                                offers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Widget activities -->

        <!-- Widget Video -->
        <section class="widget-video-style2">
            <div class="tf-container">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="video-h4-widget relative overflow-hidden mb--14em video-wrap">
                            <a href="https://www.youtube.com/watch?v=n9LgeoJE4EI"
                                class="video-box widget-videos flex-five z-index3 relative">
                                <i class="icon-Polygon-4"></i>
                            </a>
                            <P class="font-yes text-white center text-video z-index3 relative">Watch Video</P>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Widget Video -->

        <!-- Widget feature -->
        <section class="widget-feature3 bg-1">
            <div class="tf-container">
                <div class="row al-i-end mb-22">
                    <div class="col-md-6">
                        <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Populer
                            Activities</span>
                        <h2 class="title-heading wow fadeInUp animated">Extras features</h2>
                    </div>
                    <div class="col-md-6 wow fadeInUp animated">
                        <p class="des">Welcome to our Print 128 website! We are a professional and reliable
                            printing
                            company that offers a wide range of printing services to</p>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-lg-4">
                        <div class="image-feature3">
                            <div class="image-feature relative">
                                <img src="./assets/images/feature/ft1.jpg" alt="image">
                                <span class="text font-yes text-white">Never stop Exploring</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 box-feature-wrap">
                        <div class="row">
                            <div class="col-md-6 mb-32 wow fadeInUp animated " data-wow-delay="0.1s">
                                <div class="tf-icon-box icon-box-style2 flex relative">
                                    <div class="icon">
                                        <i class="icon-Travel_insurance"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title-icon"><a href="#">Safety first always</a></h6>
                                        <p class="des-icon">Welcome to our Print 128 web
                                            company that offers a wide </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-32 wow fadeInUp animated " data-wow-delay="0.2s">
                                <div class="tf-icon-box icon-box-style2 flex relative">
                                    <div class="icon">
                                        <i class="icon-plane-1-1"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title-icon"><a href="#">Trusted travel guide</a></h6>
                                        <p class="des-icon">Welcome to our Print 128 web
                                            company that offers a wide </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-32 wow fadeInUp animated " data-wow-delay="0.3s">
                                <div class="tf-icon-box icon-box-style2 flex relative">
                                    <div class="icon">
                                        <i class="icon-destination"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title-icon"><a href="#">Pesonalized Trips</a></h6>
                                        <p class="des-icon">Welcome to our Print 128 web
                                            company that offers a wide </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-32 wow fadeInUp animated " data-wow-delay="0.4s">
                                <div class="tf-icon-box icon-box-style2 flex relative">
                                    <div class="icon">
                                        <i class="icon-climbing-1-1"></i>
                                    </div>
                                    <div class="content">
                                        <h6 class="title-icon"><a href="#">Adventure &amp; Climbing</a></h6>
                                        <p class="des-icon">Welcome to our Print 128 web
                                            company that offers a wide </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Widget feature -->

        <!-- Widget destination -->
        <section class="top-destination2 pd-main">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-50 center">
                            <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Populer
                                Activities</span>
                            <h2 class="title-heading wow fadeInUp animated">Provide Top Destination</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-2 wow fadeInUp animated " data-wow-delay="0.1s">
                        <div class="tf-image-box center">
                            <a href="single-destination.html" class="image">
                                <img src="./assets/images/tour/tour4-1.jpg" alt="Image">
                            </a>
                            <h6><a href="single-destination.html">North America</a></h6>
                            <span class="text-main">(3 Tour)</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 wow fadeInUp animated " data-wow-delay="0.2s">
                        <div class="tf-image-box center pt-25">
                            <a href="single-destination.html" class="image">
                                <img src="./assets/images/tour/tour4-2.jpg" alt="Image">
                            </a>
                            <h6><a href="single-destination.html">Sweden</a></h6>
                            <span class="text-main">(3 Tour)</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 wow fadeInUp animated " data-wow-delay="0.3s">
                        <div class="tf-image-box center">
                            <a href="single-destination.html" class="image">
                                <img src="./assets/images/tour/tour4-3.jpg" alt="Image">
                            </a>
                            <h6><a href="single-destination.html">North America</a></h6>
                            <span class="text-main">(3 Tour)</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 wow fadeInUp animated " data-wow-delay="0.4s">
                        <div class="tf-image-box center pt-25">
                            <a href="single-destination.html" class="image">
                                <img src="./assets/images/tour/tour4-4.jpg" alt="Image">
                            </a>
                            <h6><a href="single-destination.html">Canada</a></h6>
                            <span class="text-main">(3 Tour)</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 wow fadeInUp animated " data-wow-delay="0.5s">
                        <div class="tf-image-box center">
                            <a href="single-destination.html" class="image">
                                <img src="./assets/images/tour/tour4-5.jpg" alt="Image">
                            </a>
                            <h6><a href="single-destination.html">North America</a></h6>
                            <span class="text-main">(3 Tour)</span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-2 wow fadeInUp animated " data-wow-delay="0.6s">
                        <div class="tf-image-box center pt-25">
                            <a href="single-destination.html" class="image">
                                <img src="./assets/images/tour/tour4-6.jpg" alt="Image">
                            </a>
                            <h6><a href="single-destination.html">North America</a></h6>
                            <span class="text-main">(3 Tour)</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 center wow fadeInUp animated ">
                        <p class="tour-des-top mt-53">Explore our top destinations voted by more than <span
                                class="text-main">100,000+</span> customers around the world.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Widget destination -->

        <section class="mb--93 z-index3 relative ">
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
                        <a href="{{ route('login')}}" class="get-call">Let,s get started</a>
                    </div>
                </div>
            </div>

        </section>

        <!-- Widget impressino -->
        <section class="impressino relative overflow-hidden">
            <img src="./assets/images/page/mask-counter.png" alt="image" class="mask-impression">
            <div class="tf-container">
                <div class="row z-index3 relative">
                    <div class="col-md-6">
                        <div class="impressino-counter">
                            <div class="counter-item center tf-countto">
                                <span>Satsified Clients</span>
                                <div class="number-counter plus" data-to="250" data-speed="2000"
                                    data-waypoint-active="yes">250</div>
                            </div>
                            <div class="counter-item center tf-countto">
                                <span>Total Rent cars</span>
                                <div class="number-counter number" data-to="1538" data-speed="2000"
                                    data-waypoint-active="yes">1538</div>
                            </div>
                            <div class="counter-item center tf-countto">
                                <span>Years of build</span>
                                <div class="number-counter number plus" data-to="28" data-speed="2000"
                                    data-waypoint-active="yes">28</div>
                            </div>
                            <div class="counter-item center tf-countto">
                                <span>Total Tourist</span>
                                <div class="number-counter number kare" data-to="386" data-speed="2000"
                                    data-waypoint-active="yes">386</div>
                            </div>
                            <div class="icon-fly">
                                <i class="icon-Vector-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-impressino">
                            <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Populer
                                Activities</span>
                            <h2 class="title-heading text-white wow fadeInUp animated">Company Impression</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Widget impressino -->

        <!-- Widget Top this Week -->
        <section class="top-this-week pd-main">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-37 center">
                            <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Featured
                                Tour</span>
                            <h2 class="title-heading wow fadeInUp animated">Our top this week</h2>
                        </div>
                    </div>
                    <div class="col-lg-12 relative top-this-week-slide">
                        <div class="swiper populer-activities overflow-hidden">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
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
                                            <span class="map"><i class="icon-Vector4"></i>United States
                                                USA</span>
                                            <h3 class="title-tour-list"><a href="tour-single.html">6 nights From
                                                    Moscow</a>
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
                                                    <svg width="21" height="16" viewBox="0 0 21 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M17.1035 15.1797V9.02734" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M20.1797 12.1035H14.0273" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                <div class="swiper-slide">
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
                                            <span class="map"><i class="icon-Vector4"></i>United States
                                                USA</span>
                                            <h3 class="title-tour-list"><a href="tour-single.html">6 nights From
                                                    Moscow</a>
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
                                                    <svg width="21" height="16" viewBox="0 0 21 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M17.1035 15.1797V9.02734" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M20.1797 12.1035H14.0273" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                <div class="swiper-slide">
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
                                            <span class="map"><i class="icon-Vector4"></i>United States
                                                USA</span>
                                            <h3 class="title-tour-list"><a href="tour-single.html">6 nights From
                                                    Moscow</a>
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
                                                    <svg width="21" height="16" viewBox="0 0 21 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M17.1035 15.1797V9.02734" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M20.1797 12.1035H14.0273" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                <div class="swiper-slide">
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
                                            <span class="map"><i class="icon-Vector4"></i>United States
                                                USA</span>
                                            <h3 class="title-tour-list"><a href="tour-single.html">6 nights From
                                                    Moscow</a>
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
                                                    <svg width="21" height="16" viewBox="0 0 21 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M17.1035 15.1797V9.02734" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M20.1797 12.1035H14.0273" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
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
                                <div class="swiper-slide">
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
                                            <span class="map"><i class="icon-Vector4"></i>United States
                                                USA</span>
                                            <h3 class="title-tour-list"><a href="tour-single.html">6 nights From
                                                    Moscow</a>
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
                                                    <svg width="21" height="16" viewBox="0 0 21 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path
                                                            d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                            stroke="#4DA528" stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M17.1035 15.1797V9.02734" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M20.1797 12.1035H14.0273" stroke="#4DA528"
                                                            stroke-width="1.7" stroke-miterlimit="10"
                                                            stroke-linecap="round" stroke-linejoin="round" />
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
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Widget Top this Week -->

        <!-- Widget why chose us -->
        <section class="widget-feature2">
            <div class="tf-container full">
                <div class="row">
                    <div class="col-md-5 relative">
                        <div class="image-feature2 relative">
                            <img src="./assets/images/page/travelling2.jpg" alt="">
                        </div>
                        <div class="exploring flex-five center">
                            <span class="font-yes text-white ">Never stop
                                Exploring</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="content-feature2">
                            <div class="mb-60">
                                <span class="sub-title-heading text-main font-yes fs-28-46 wow fadeInUp animated">Explore
                                    the
                                    world</span>
                                <h2 class="title-heading mb-18 wow fadeInUp animated">Why you Choose us for
                                    <span class="text-gray font-yes">adventure</span> & travelling
                                </h2>
                                <p class="des wow fadeInUp animated">Welcome to our Print 128 website! We are a
                                    professional and
                                    reliable printing
                                    company that offers a wide range of printing services to</p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="cheackmark flex mb-70">
                                        <div class="icon flex-five">
                                            <i class="icon-plane-1"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="mb-15 wow fadeInUp animated"><a href="#">Safety first
                                                    always</a></h5>
                                            <p class="des wow fadeInUp animated">Welcome to our Print 128 web
                                                company that offers a wide </p>
                                        </div>
                                    </div>
                                    <div class="cheackmark flex">
                                        <div class="icon flex-five">
                                            <i class="icon-hiking-1-1"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="mb-15 wow fadeInUp animated"><a href="#">Adventure &
                                                    Climbing</a></h5>
                                            <p class="des wow fadeInUp animated">Welcome to our Print 128 web
                                                company that offers a wide </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="cheackmark flex mb-70">
                                        <div class="icon flex-five">
                                            <i class="icon-price-tag-1"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="mb-15 wow fadeInUp animated"><a href="#">Low price &
                                                    friendly</a></h5>
                                            <p class="des wow fadeInUp animated">Welcome to our Print 128 web
                                                company that offers a wide </p>
                                        </div>
                                    </div>
                                    <div class="cheackmark flex">
                                        <div class="icon flex-five">
                                            <i class="icon-guide-1-1"></i>
                                        </div>
                                        <div class="content">
                                            <h5 class="mb-15 wow fadeInUp animated"><a href="#">Trusted travel
                                                    guide</a></h5>
                                            <p class="des wow fadeInUp animated">Welcome to our Print 128 web
                                                company that offers a wide </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- Widget why chose us -->

        <!-- Widget places -->
        <section class="pd-main">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12 mb-30">
                        <div class="center m0-auto w-text-heading">
                            <span class="sub-title-heading text-main font-yes fs-28-46 mb-15 wow fadeInUp animated">Populer
                                Activities</span>
                            <h2 class="title-heading wow fadeInUp animated">Amazing tour places around the <span
                                    class="text-gray font-yes">world</span></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-3 wow fadeInUp animated " data-wow-delay="0.1s">
                        <div class="tf-widget-place">
                            <a href="#" class="place-image relative">
                                <span class="feature">Featured</span>
                                <img src="./assets/images/feature/feature1.jpg" alt="">
                            </a>
                            <div class="content">
                                <p class="price-place">From <span class="price">$169.00</span></p>
                                <div class="place-content">
                                    <span class="map"><i class="icon-Vector-15"></i>United States USA</span>
                                    <h4 class="title-place"><a href="#">Days and 6 nights From</a></h4>
                                    <ul class="flex-three meta-place">
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 17 18"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_265_23)">
                                                        <path
                                                            d="M10.1092 15.9207C9.97052 15.9545 9.82911 15.9845 9.68875 16.0098C9.32183 16.0766 9.07926 16.422 9.14713 16.7815C9.18064 16.9584 9.28325 17.1057 9.42257 17.2018C9.56614 17.3007 9.74888 17.3454 9.93508 17.3115C10.1022 17.2811 10.2707 17.2454 10.436 17.205C10.7983 17.1168 11.0191 16.7575 10.9287 16.403C10.8385 16.0482 10.4718 15.8323 10.1092 15.9207Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.1093 7.0493C15.1567 7.18903 15.2471 7.30309 15.3613 7.38191C15.5307 7.49867 15.7523 7.53795 15.9638 7.4695C16.3183 7.35427 16.5104 6.98004 16.3931 6.63318C16.3397 6.47505 16.2804 6.31643 16.2172 6.16198C16.0785 5.82258 15.6852 5.65734 15.3383 5.7931C14.9917 5.92879 14.8229 6.31388 14.9617 6.65339C15.0147 6.7832 15.0645 6.91645 15.1093 7.0493Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M12.3064 14.976C12.1871 15.0531 12.064 15.1277 11.94 15.1976C11.6164 15.3803 11.5056 15.7851 11.6922 16.1017C11.7428 16.1878 11.8103 16.2582 11.888 16.312C12.0966 16.4556 12.3798 16.4771 12.6157 16.3441C12.7631 16.2609 12.9098 16.1723 13.0518 16.0804C13.3633 15.879 13.449 15.4683 13.2431 15.1633C13.0373 14.8582 12.6179 14.7744 12.3064 14.976Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M16.8137 8.8981C16.799 8.53279 16.4847 8.24846 16.1113 8.26272C15.7385 8.27713 15.4478 8.58492 15.4624 8.95009C15.468 9.0897 15.4695 9.23141 15.4662 9.37089C15.461 9.59997 15.5754 9.80418 15.7533 9.92692C15.8593 9.99996 15.9879 10.0442 16.1274 10.0473C16.5006 10.0554 16.8099 9.76564 16.8181 9.40015C16.8219 9.2335 16.8204 9.06465 16.8137 8.8981Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M14.9989 13.2347C14.6996 13.0149 14.2762 13.0746 14.0521 13.367C13.9662 13.4789 13.8759 13.5895 13.7833 13.696C13.5414 13.9742 13.5756 14.392 13.8598 14.629C13.876 14.6424 13.8923 14.6548 13.9093 14.6664C14.1919 14.8614 14.5845 14.8166 14.813 14.5542C14.9235 14.4271 15.0312 14.295 15.1338 14.1613C15.358 13.8689 15.2973 13.4541 14.9989 13.2347Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.9931 10.842C15.6368 10.7327 15.2573 10.9268 15.1456 11.2756C15.1029 11.4088 15.0555 11.5427 15.0044 11.6738C14.8921 11.9625 14.9997 12.2801 15.2463 12.4503C15.2915 12.4814 15.3414 12.5078 15.3955 12.5278C15.7444 12.6581 16.135 12.4868 16.268 12.1451C16.3287 11.9892 16.385 11.83 16.436 11.6715C16.5475 11.3227 16.3493 10.9514 15.9931 10.842Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.15894 16.016C6.5544 15.9097 5.97449 15.7288 5.42458 15.4765C5.41807 15.4731 5.41225 15.4694 5.40542 15.4663C5.27583 15.4066 5.14647 15.3427 5.02108 15.2758C5.02064 15.2753 5.01985 15.275 5.01916 15.2747C4.78909 15.1507 4.56456 15.0135 4.34643 14.8632C1.16567 12.67 0.400889 8.35274 2.64165 5.23935C3.1289 4.5626 3.71854 3.998 4.3759 3.55052C4.384 3.545 4.3921 3.53951 4.40012 3.53395C6.71656 1.97165 9.86193 1.86636 12.3216 3.47177L11.7933 4.21891C11.6465 4.42687 11.7368 4.57842 11.9939 4.55577L14.2887 4.35467C14.5461 4.33202 14.7001 4.11405 14.6308 3.8707L14.0146 1.69748C13.9456 1.45384 13.769 1.42468 13.622 1.6326L13.0925 2.38151C11.2874 1.19545 9.12238 0.74319 6.97349 1.10793C6.75706 1.1446 6.54366 1.18947 6.33319 1.24171C6.33157 1.24199 6.33027 1.24217 6.32896 1.24245C6.32083 1.2444 6.31258 1.24698 6.30467 1.24914C4.45165 1.71492 2.83491 2.7728 1.68126 4.28216C1.67154 4.29345 1.66152 4.30449 1.65234 4.31677C1.61398 4.36734 1.5759 4.41909 1.53863 4.47083C1.47767 4.55562 1.41757 4.64255 1.36009 4.72947C1.35289 4.73994 1.34739 4.75059 1.3411 4.76118C0.389103 6.20517 -0.070085 7.87457 0.00866385 9.57412C0.00884463 9.57971 0.00851922 9.58534 0.00866385 9.59107C0.0162929 9.75709 0.0297431 9.92541 0.0480021 10.0911C0.0489783 10.1018 0.0514008 10.1119 0.0532448 10.1226C0.0721185 10.2892 0.095801 10.4562 0.125485 10.6232C0.427175 12.3269 1.24822 13.8599 2.47851 15.0528C2.48137 15.0556 2.48434 15.0586 2.48723 15.0615C2.48824 15.0626 2.48936 15.0632 2.49034 15.0642C2.82088 15.3833 3.18042 15.6785 3.56755 15.9454C4.58065 16.6441 5.70877 17.106 6.9203 17.3188C7.28791 17.3835 7.63906 17.144 7.70501 16.7843C7.77092 16.4244 7.52643 16.0804 7.15894 16.016Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.99505 3.86963C7.69268 3.86963 7.44775 4.10958 7.44775 4.40513V9.74023L12.4326 12.2626C12.5129 12.3033 12.5988 12.3224 12.6833 12.3224C12.8813 12.3224 13.0725 12.2169 13.1698 12.0327C13.3084 11.7699 13.2035 11.447 12.935 11.3113L8.54174 9.08812V4.40513C8.5417 4.10958 8.29707 3.86963 7.99505 3.86963Z"
                                                            fill="currentColor"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_265_33">
                                                            <rect width="16.82" height="16.4639" fill="white"
                                                                transform="translate(0 0.925293)"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <span>5 days</span>
                                        </li>
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 13"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3.57959 3.89694C3.57959 2.4 4.81937 1.18646 6.34869 1.18646C7.87801 1.18646 9.11779 2.4 9.11779 3.89694C9.11779 5.39389 7.87801 6.60742 6.34869 6.60742C4.81937 6.60742 3.57959 5.39389 3.57959 3.89694Z"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path
                                                        d="M7.90165 12.2642H2.02575C1.10962 12.2642 0.459183 11.3904 0.739707 10.5367C1.4849 8.26878 3.7688 6.62765 6.33346 6.62765C7.55689 6.62765 8.69118 7.0011 9.62389 7.6379"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M14.0815 12.2642V7.30596" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path d="M16.6147 9.7832H11.5493" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                            <span>12 Person</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3 wow fadeInUp animated " data-wow-delay="0.2s">
                        <div class="tf-widget-place">
                            <a href="#" class="place-image relative">
                                <span class="feature">Featured</span>
                                <img src="./assets/images/feature/feature2.jpg" alt="">
                            </a>
                            <div class="content">
                                <p class="price-place">From <span class="price">$169.00</span></p>
                                <div class="place-content">
                                    <span class="map"><i class="icon-Vector-15"></i>United States USA</span>
                                    <h4 class="title-place"><a href="#">Days and 6 nights From</a></h4>
                                    <ul class="flex-three meta-place">
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 17 18"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_265_23)">
                                                        <path
                                                            d="M10.1092 15.9207C9.97052 15.9545 9.82911 15.9845 9.68875 16.0098C9.32183 16.0766 9.07926 16.422 9.14713 16.7815C9.18064 16.9584 9.28325 17.1057 9.42257 17.2018C9.56614 17.3007 9.74888 17.3454 9.93508 17.3115C10.1022 17.2811 10.2707 17.2454 10.436 17.205C10.7983 17.1168 11.0191 16.7575 10.9287 16.403C10.8385 16.0482 10.4718 15.8323 10.1092 15.9207Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.1093 7.0493C15.1567 7.18903 15.2471 7.30309 15.3613 7.38191C15.5307 7.49867 15.7523 7.53795 15.9638 7.4695C16.3183 7.35427 16.5104 6.98004 16.3931 6.63318C16.3397 6.47505 16.2804 6.31643 16.2172 6.16198C16.0785 5.82258 15.6852 5.65734 15.3383 5.7931C14.9917 5.92879 14.8229 6.31388 14.9617 6.65339C15.0147 6.7832 15.0645 6.91645 15.1093 7.0493Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M12.3064 14.976C12.1871 15.0531 12.064 15.1277 11.94 15.1976C11.6164 15.3803 11.5056 15.7851 11.6922 16.1017C11.7428 16.1878 11.8103 16.2582 11.888 16.312C12.0966 16.4556 12.3798 16.4771 12.6157 16.3441C12.7631 16.2609 12.9098 16.1723 13.0518 16.0804C13.3633 15.879 13.449 15.4683 13.2431 15.1633C13.0373 14.8582 12.6179 14.7744 12.3064 14.976Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M16.8137 8.8981C16.799 8.53279 16.4847 8.24846 16.1113 8.26272C15.7385 8.27713 15.4478 8.58492 15.4624 8.95009C15.468 9.0897 15.4695 9.23141 15.4662 9.37089C15.461 9.59997 15.5754 9.80418 15.7533 9.92692C15.8593 9.99996 15.9879 10.0442 16.1274 10.0473C16.5006 10.0554 16.8099 9.76564 16.8181 9.40015C16.8219 9.2335 16.8204 9.06465 16.8137 8.8981Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M14.9989 13.2347C14.6996 13.0149 14.2762 13.0746 14.0521 13.367C13.9662 13.4789 13.8759 13.5895 13.7833 13.696C13.5414 13.9742 13.5756 14.392 13.8598 14.629C13.876 14.6424 13.8923 14.6548 13.9093 14.6664C14.1919 14.8614 14.5845 14.8166 14.813 14.5542C14.9235 14.4271 15.0312 14.295 15.1338 14.1613C15.358 13.8689 15.2973 13.4541 14.9989 13.2347Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.9931 10.842C15.6368 10.7327 15.2573 10.9268 15.1456 11.2756C15.1029 11.4088 15.0555 11.5427 15.0044 11.6738C14.8921 11.9625 14.9997 12.2801 15.2463 12.4503C15.2915 12.4814 15.3414 12.5078 15.3955 12.5278C15.7444 12.6581 16.135 12.4868 16.268 12.1451C16.3287 11.9892 16.385 11.83 16.436 11.6715C16.5475 11.3227 16.3493 10.9514 15.9931 10.842Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.15894 16.016C6.5544 15.9097 5.97449 15.7288 5.42458 15.4765C5.41807 15.4731 5.41225 15.4694 5.40542 15.4663C5.27583 15.4066 5.14647 15.3427 5.02108 15.2758C5.02064 15.2753 5.01985 15.275 5.01916 15.2747C4.78909 15.1507 4.56456 15.0135 4.34643 14.8632C1.16567 12.67 0.400889 8.35274 2.64165 5.23935C3.1289 4.5626 3.71854 3.998 4.3759 3.55052C4.384 3.545 4.3921 3.53951 4.40012 3.53395C6.71656 1.97165 9.86193 1.86636 12.3216 3.47177L11.7933 4.21891C11.6465 4.42687 11.7368 4.57842 11.9939 4.55577L14.2887 4.35467C14.5461 4.33202 14.7001 4.11405 14.6308 3.8707L14.0146 1.69748C13.9456 1.45384 13.769 1.42468 13.622 1.6326L13.0925 2.38151C11.2874 1.19545 9.12238 0.74319 6.97349 1.10793C6.75706 1.1446 6.54366 1.18947 6.33319 1.24171C6.33157 1.24199 6.33027 1.24217 6.32896 1.24245C6.32083 1.2444 6.31258 1.24698 6.30467 1.24914C4.45165 1.71492 2.83491 2.7728 1.68126 4.28216C1.67154 4.29345 1.66152 4.30449 1.65234 4.31677C1.61398 4.36734 1.5759 4.41909 1.53863 4.47083C1.47767 4.55562 1.41757 4.64255 1.36009 4.72947C1.35289 4.73994 1.34739 4.75059 1.3411 4.76118C0.389103 6.20517 -0.070085 7.87457 0.00866385 9.57412C0.00884463 9.57971 0.00851922 9.58534 0.00866385 9.59107C0.0162929 9.75709 0.0297431 9.92541 0.0480021 10.0911C0.0489783 10.1018 0.0514008 10.1119 0.0532448 10.1226C0.0721185 10.2892 0.095801 10.4562 0.125485 10.6232C0.427175 12.3269 1.24822 13.8599 2.47851 15.0528C2.48137 15.0556 2.48434 15.0586 2.48723 15.0615C2.48824 15.0626 2.48936 15.0632 2.49034 15.0642C2.82088 15.3833 3.18042 15.6785 3.56755 15.9454C4.58065 16.6441 5.70877 17.106 6.9203 17.3188C7.28791 17.3835 7.63906 17.144 7.70501 16.7843C7.77092 16.4244 7.52643 16.0804 7.15894 16.016Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.99505 3.86963C7.69268 3.86963 7.44775 4.10958 7.44775 4.40513V9.74023L12.4326 12.2626C12.5129 12.3033 12.5988 12.3224 12.6833 12.3224C12.8813 12.3224 13.0725 12.2169 13.1698 12.0327C13.3084 11.7699 13.2035 11.447 12.935 11.3113L8.54174 9.08812V4.40513C8.5417 4.10958 8.29707 3.86963 7.99505 3.86963Z"
                                                            fill="currentColor"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_265_22">
                                                            <rect width="16.82" height="16.4639" fill="white"
                                                                transform="translate(0 0.925293)"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <span>5 days</span>
                                        </li>
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 13"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3.57959 3.89694C3.57959 2.4 4.81937 1.18646 6.34869 1.18646C7.87801 1.18646 9.11779 2.4 9.11779 3.89694C9.11779 5.39389 7.87801 6.60742 6.34869 6.60742C4.81937 6.60742 3.57959 5.39389 3.57959 3.89694Z"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path
                                                        d="M7.90165 12.2642H2.02575C1.10962 12.2642 0.459183 11.3904 0.739707 10.5367C1.4849 8.26878 3.7688 6.62765 6.33346 6.62765C7.55689 6.62765 8.69118 7.0011 9.62389 7.6379"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M14.0815 12.2642V7.30596" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path d="M16.6147 9.7832H11.5493" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                            <span>12 Person</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3 wow fadeInUp animated " data-wow-delay="0.3s">
                        <div class="tf-widget-place">
                            <a href="#" class="place-image relative">
                                <span class="feature">Featured</span>
                                <img src="./assets/images/feature/feature3.jpg" alt="">
                            </a>
                            <div class="content">
                                <p class="price-place">From <span class="price">$169.00</span></p>
                                <div class="place-content">
                                    <span class="map"><i class="icon-Vector-15"></i>United States USA</span>
                                    <h4 class="title-place"><a href="#">Days and 6 nights From</a></h4>
                                    <ul class="flex-three meta-place">
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 17 18"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_265_23)">
                                                        <path
                                                            d="M10.1092 15.9207C9.97052 15.9545 9.82911 15.9845 9.68875 16.0098C9.32183 16.0766 9.07926 16.422 9.14713 16.7815C9.18064 16.9584 9.28325 17.1057 9.42257 17.2018C9.56614 17.3007 9.74888 17.3454 9.93508 17.3115C10.1022 17.2811 10.2707 17.2454 10.436 17.205C10.7983 17.1168 11.0191 16.7575 10.9287 16.403C10.8385 16.0482 10.4718 15.8323 10.1092 15.9207Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.1093 7.0493C15.1567 7.18903 15.2471 7.30309 15.3613 7.38191C15.5307 7.49867 15.7523 7.53795 15.9638 7.4695C16.3183 7.35427 16.5104 6.98004 16.3931 6.63318C16.3397 6.47505 16.2804 6.31643 16.2172 6.16198C16.0785 5.82258 15.6852 5.65734 15.3383 5.7931C14.9917 5.92879 14.8229 6.31388 14.9617 6.65339C15.0147 6.7832 15.0645 6.91645 15.1093 7.0493Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M12.3064 14.976C12.1871 15.0531 12.064 15.1277 11.94 15.1976C11.6164 15.3803 11.5056 15.7851 11.6922 16.1017C11.7428 16.1878 11.8103 16.2582 11.888 16.312C12.0966 16.4556 12.3798 16.4771 12.6157 16.3441C12.7631 16.2609 12.9098 16.1723 13.0518 16.0804C13.3633 15.879 13.449 15.4683 13.2431 15.1633C13.0373 14.8582 12.6179 14.7744 12.3064 14.976Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M16.8137 8.8981C16.799 8.53279 16.4847 8.24846 16.1113 8.26272C15.7385 8.27713 15.4478 8.58492 15.4624 8.95009C15.468 9.0897 15.4695 9.23141 15.4662 9.37089C15.461 9.59997 15.5754 9.80418 15.7533 9.92692C15.8593 9.99996 15.9879 10.0442 16.1274 10.0473C16.5006 10.0554 16.8099 9.76564 16.8181 9.40015C16.8219 9.2335 16.8204 9.06465 16.8137 8.8981Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M14.9989 13.2347C14.6996 13.0149 14.2762 13.0746 14.0521 13.367C13.9662 13.4789 13.8759 13.5895 13.7833 13.696C13.5414 13.9742 13.5756 14.392 13.8598 14.629C13.876 14.6424 13.8923 14.6548 13.9093 14.6664C14.1919 14.8614 14.5845 14.8166 14.813 14.5542C14.9235 14.4271 15.0312 14.295 15.1338 14.1613C15.358 13.8689 15.2973 13.4541 14.9989 13.2347Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.9931 10.842C15.6368 10.7327 15.2573 10.9268 15.1456 11.2756C15.1029 11.4088 15.0555 11.5427 15.0044 11.6738C14.8921 11.9625 14.9997 12.2801 15.2463 12.4503C15.2915 12.4814 15.3414 12.5078 15.3955 12.5278C15.7444 12.6581 16.135 12.4868 16.268 12.1451C16.3287 11.9892 16.385 11.83 16.436 11.6715C16.5475 11.3227 16.3493 10.9514 15.9931 10.842Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.15894 16.016C6.5544 15.9097 5.97449 15.7288 5.42458 15.4765C5.41807 15.4731 5.41225 15.4694 5.40542 15.4663C5.27583 15.4066 5.14647 15.3427 5.02108 15.2758C5.02064 15.2753 5.01985 15.275 5.01916 15.2747C4.78909 15.1507 4.56456 15.0135 4.34643 14.8632C1.16567 12.67 0.400889 8.35274 2.64165 5.23935C3.1289 4.5626 3.71854 3.998 4.3759 3.55052C4.384 3.545 4.3921 3.53951 4.40012 3.53395C6.71656 1.97165 9.86193 1.86636 12.3216 3.47177L11.7933 4.21891C11.6465 4.42687 11.7368 4.57842 11.9939 4.55577L14.2887 4.35467C14.5461 4.33202 14.7001 4.11405 14.6308 3.8707L14.0146 1.69748C13.9456 1.45384 13.769 1.42468 13.622 1.6326L13.0925 2.38151C11.2874 1.19545 9.12238 0.74319 6.97349 1.10793C6.75706 1.1446 6.54366 1.18947 6.33319 1.24171C6.33157 1.24199 6.33027 1.24217 6.32896 1.24245C6.32083 1.2444 6.31258 1.24698 6.30467 1.24914C4.45165 1.71492 2.83491 2.7728 1.68126 4.28216C1.67154 4.29345 1.66152 4.30449 1.65234 4.31677C1.61398 4.36734 1.5759 4.41909 1.53863 4.47083C1.47767 4.55562 1.41757 4.64255 1.36009 4.72947C1.35289 4.73994 1.34739 4.75059 1.3411 4.76118C0.389103 6.20517 -0.070085 7.87457 0.00866385 9.57412C0.00884463 9.57971 0.00851922 9.58534 0.00866385 9.59107C0.0162929 9.75709 0.0297431 9.92541 0.0480021 10.0911C0.0489783 10.1018 0.0514008 10.1119 0.0532448 10.1226C0.0721185 10.2892 0.095801 10.4562 0.125485 10.6232C0.427175 12.3269 1.24822 13.8599 2.47851 15.0528C2.48137 15.0556 2.48434 15.0586 2.48723 15.0615C2.48824 15.0626 2.48936 15.0632 2.49034 15.0642C2.82088 15.3833 3.18042 15.6785 3.56755 15.9454C4.58065 16.6441 5.70877 17.106 6.9203 17.3188C7.28791 17.3835 7.63906 17.144 7.70501 16.7843C7.77092 16.4244 7.52643 16.0804 7.15894 16.016Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.99505 3.86963C7.69268 3.86963 7.44775 4.10958 7.44775 4.40513V9.74023L12.4326 12.2626C12.5129 12.3033 12.5988 12.3224 12.6833 12.3224C12.8813 12.3224 13.0725 12.2169 13.1698 12.0327C13.3084 11.7699 13.2035 11.447 12.935 11.3113L8.54174 9.08812V4.40513C8.5417 4.10958 8.29707 3.86963 7.99505 3.86963Z"
                                                            fill="currentColor"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_265_44">
                                                            <rect width="16.82" height="16.4639" fill="white"
                                                                transform="translate(0 0.925293)"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <span>5 days</span>
                                        </li>
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 13"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3.57959 3.89694C3.57959 2.4 4.81937 1.18646 6.34869 1.18646C7.87801 1.18646 9.11779 2.4 9.11779 3.89694C9.11779 5.39389 7.87801 6.60742 6.34869 6.60742C4.81937 6.60742 3.57959 5.39389 3.57959 3.89694Z"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path
                                                        d="M7.90165 12.2642H2.02575C1.10962 12.2642 0.459183 11.3904 0.739707 10.5367C1.4849 8.26878 3.7688 6.62765 6.33346 6.62765C7.55689 6.62765 8.69118 7.0011 9.62389 7.6379"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M14.0815 12.2642V7.30596" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path d="M16.6147 9.7832H11.5493" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                            <span>12 Person</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3 wow fadeInUp animated " data-wow-delay="0.4s">
                        <div class="tf-widget-place">
                            <a href="#" class="place-image relative">
                                <span class="feature">Featured</span>
                                <img src="./assets/images/feature/feature4.jpg" alt="">
                            </a>
                            <div class="content">
                                <p class="price-place">From <span class="price">$169.00</span></p>
                                <div class="place-content">
                                    <span class="map"><i class="icon-Vector-15"></i>United States USA</span>
                                    <h4 class="title-place"><a href="#">Days and 6 nights From</a></h4>
                                    <ul class="flex-three meta-place">
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 17 18"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_265_23)">
                                                        <path
                                                            d="M10.1092 15.9207C9.97052 15.9545 9.82911 15.9845 9.68875 16.0098C9.32183 16.0766 9.07926 16.422 9.14713 16.7815C9.18064 16.9584 9.28325 17.1057 9.42257 17.2018C9.56614 17.3007 9.74888 17.3454 9.93508 17.3115C10.1022 17.2811 10.2707 17.2454 10.436 17.205C10.7983 17.1168 11.0191 16.7575 10.9287 16.403C10.8385 16.0482 10.4718 15.8323 10.1092 15.9207Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.1093 7.0493C15.1567 7.18903 15.2471 7.30309 15.3613 7.38191C15.5307 7.49867 15.7523 7.53795 15.9638 7.4695C16.3183 7.35427 16.5104 6.98004 16.3931 6.63318C16.3397 6.47505 16.2804 6.31643 16.2172 6.16198C16.0785 5.82258 15.6852 5.65734 15.3383 5.7931C14.9917 5.92879 14.8229 6.31388 14.9617 6.65339C15.0147 6.7832 15.0645 6.91645 15.1093 7.0493Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M12.3064 14.976C12.1871 15.0531 12.064 15.1277 11.94 15.1976C11.6164 15.3803 11.5056 15.7851 11.6922 16.1017C11.7428 16.1878 11.8103 16.2582 11.888 16.312C12.0966 16.4556 12.3798 16.4771 12.6157 16.3441C12.7631 16.2609 12.9098 16.1723 13.0518 16.0804C13.3633 15.879 13.449 15.4683 13.2431 15.1633C13.0373 14.8582 12.6179 14.7744 12.3064 14.976Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M16.8137 8.8981C16.799 8.53279 16.4847 8.24846 16.1113 8.26272C15.7385 8.27713 15.4478 8.58492 15.4624 8.95009C15.468 9.0897 15.4695 9.23141 15.4662 9.37089C15.461 9.59997 15.5754 9.80418 15.7533 9.92692C15.8593 9.99996 15.9879 10.0442 16.1274 10.0473C16.5006 10.0554 16.8099 9.76564 16.8181 9.40015C16.8219 9.2335 16.8204 9.06465 16.8137 8.8981Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M14.9989 13.2347C14.6996 13.0149 14.2762 13.0746 14.0521 13.367C13.9662 13.4789 13.8759 13.5895 13.7833 13.696C13.5414 13.9742 13.5756 14.392 13.8598 14.629C13.876 14.6424 13.8923 14.6548 13.9093 14.6664C14.1919 14.8614 14.5845 14.8166 14.813 14.5542C14.9235 14.4271 15.0312 14.295 15.1338 14.1613C15.358 13.8689 15.2973 13.4541 14.9989 13.2347Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M15.9931 10.842C15.6368 10.7327 15.2573 10.9268 15.1456 11.2756C15.1029 11.4088 15.0555 11.5427 15.0044 11.6738C14.8921 11.9625 14.9997 12.2801 15.2463 12.4503C15.2915 12.4814 15.3414 12.5078 15.3955 12.5278C15.7444 12.6581 16.135 12.4868 16.268 12.1451C16.3287 11.9892 16.385 11.83 16.436 11.6715C16.5475 11.3227 16.3493 10.9514 15.9931 10.842Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.15894 16.016C6.5544 15.9097 5.97449 15.7288 5.42458 15.4765C5.41807 15.4731 5.41225 15.4694 5.40542 15.4663C5.27583 15.4066 5.14647 15.3427 5.02108 15.2758C5.02064 15.2753 5.01985 15.275 5.01916 15.2747C4.78909 15.1507 4.56456 15.0135 4.34643 14.8632C1.16567 12.67 0.400889 8.35274 2.64165 5.23935C3.1289 4.5626 3.71854 3.998 4.3759 3.55052C4.384 3.545 4.3921 3.53951 4.40012 3.53395C6.71656 1.97165 9.86193 1.86636 12.3216 3.47177L11.7933 4.21891C11.6465 4.42687 11.7368 4.57842 11.9939 4.55577L14.2887 4.35467C14.5461 4.33202 14.7001 4.11405 14.6308 3.8707L14.0146 1.69748C13.9456 1.45384 13.769 1.42468 13.622 1.6326L13.0925 2.38151C11.2874 1.19545 9.12238 0.74319 6.97349 1.10793C6.75706 1.1446 6.54366 1.18947 6.33319 1.24171C6.33157 1.24199 6.33027 1.24217 6.32896 1.24245C6.32083 1.2444 6.31258 1.24698 6.30467 1.24914C4.45165 1.71492 2.83491 2.7728 1.68126 4.28216C1.67154 4.29345 1.66152 4.30449 1.65234 4.31677C1.61398 4.36734 1.5759 4.41909 1.53863 4.47083C1.47767 4.55562 1.41757 4.64255 1.36009 4.72947C1.35289 4.73994 1.34739 4.75059 1.3411 4.76118C0.389103 6.20517 -0.070085 7.87457 0.00866385 9.57412C0.00884463 9.57971 0.00851922 9.58534 0.00866385 9.59107C0.0162929 9.75709 0.0297431 9.92541 0.0480021 10.0911C0.0489783 10.1018 0.0514008 10.1119 0.0532448 10.1226C0.0721185 10.2892 0.095801 10.4562 0.125485 10.6232C0.427175 12.3269 1.24822 13.8599 2.47851 15.0528C2.48137 15.0556 2.48434 15.0586 2.48723 15.0615C2.48824 15.0626 2.48936 15.0632 2.49034 15.0642C2.82088 15.3833 3.18042 15.6785 3.56755 15.9454C4.58065 16.6441 5.70877 17.106 6.9203 17.3188C7.28791 17.3835 7.63906 17.144 7.70501 16.7843C7.77092 16.4244 7.52643 16.0804 7.15894 16.016Z"
                                                            fill="currentColor"></path>
                                                        <path
                                                            d="M7.99505 3.86963C7.69268 3.86963 7.44775 4.10958 7.44775 4.40513V9.74023L12.4326 12.2626C12.5129 12.3033 12.5988 12.3224 12.6833 12.3224C12.8813 12.3224 13.0725 12.2169 13.1698 12.0327C13.3084 11.7699 13.2035 11.447 12.935 11.3113L8.54174 9.08812V4.40513C8.5417 4.10958 8.29707 3.86963 7.99505 3.86963Z"
                                                            fill="currentColor"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_265_55">
                                                            <rect width="16.82" height="16.4639" fill="white"
                                                                transform="translate(0 0.925293)"></rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <span>5 days</span>
                                        </li>
                                        <li class="flex-three">
                                            <div class="icon">
                                                <svg width="18" height="18" viewBox="0 0 18 13"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M3.57959 3.89694C3.57959 2.4 4.81937 1.18646 6.34869 1.18646C7.87801 1.18646 9.11779 2.4 9.11779 3.89694C9.11779 5.39389 7.87801 6.60742 6.34869 6.60742C4.81937 6.60742 3.57959 5.39389 3.57959 3.89694Z"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path
                                                        d="M7.90165 12.2642H2.02575C1.10962 12.2642 0.459183 11.3904 0.739707 10.5367C1.4849 8.26878 3.7688 6.62765 6.33346 6.62765C7.55689 6.62765 8.69118 7.0011 9.62389 7.6379"
                                                        stroke="currentColor" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M14.0815 12.2642V7.30596" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path d="M16.6147 9.7832H11.5493" stroke="currentColor"
                                                        stroke-miterlimit="10" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                            <span>12 Person</span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Widget places -->

        <!-- Widget Testimonial -->
        <section class="testimonial-section-h4 bg-1">
            <div class="tf-container full">
                <div class="row">
                    <div class="col-md-7">
                        <div class="content">
                            <div class="mb-30">
                                <span class="sub-title-heading text-main fs-28-46 font-yes  wow fadeInUp animated">Explore
                                    the
                                    world</span>
                                <h2 class="title-heading  wow fadeInUp animated">Our Clients Amazing <span
                                        class="font-yes text-gray">Feedback</span> Here</h2>
                            </div>
                            <div class="swiper mySwiper222 overflow-hidden relative">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="widget-testimonial-style5">
                                            <p class="des">Denouncing <span class="text-main">pleasure</span>
                                                and praising pain was born and I will
                                                give you a complete account of the system, and expound
                                                the actual teachings of the great explorer of truth the
                                                master builder Denouncing pleasure and praising pain
                                                Denouncing pleasure and praising pain
                                            </p>
                                            <div class="flex-two">
                                                <div class="flex-three relative">
                                                    <div class="image-avata">
                                                        <img src="./assets/images/testimonial/avt4-3.jpg"
                                                            alt="image">
                                                    </div>
                                                    <div class="content-testimonial">
                                                        <h6 class="title">Cameron Williamson</h6>
                                                        <span class="job">Medical Worker</span>
                                                    </div>

                                                </div>
                                                <div class="start">
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="widget-testimonial-style5">
                                            <p class="des">Denouncing <span class="text-main">pleasure</span>
                                                and praising pain was born and I will
                                                give you a complete account of the system, and expound
                                                the actual teachings of the great explorer of truth the
                                                master builder Denouncing pleasure and praising pain
                                                Denouncing pleasure and praising pain
                                            </p>
                                            <div class="flex-two">
                                                <div class="flex-three relative">
                                                    <div class="image-avata">
                                                        <img src="./assets/images/testimonial/avt4-4.jpg"
                                                            alt="image">
                                                    </div>
                                                    <div class="content-testimonial">
                                                        <h6 class="title">Cameron Williamson</h6>
                                                        <span class="job">Medical Worker</span>
                                                    </div>

                                                </div>
                                                <div class="start">
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="widget-testimonial-style5">
                                            <p class="des">Denouncing <span class="text-main">pleasure</span>
                                                and praising pain was born and I will
                                                give you a complete account of the system, and expound
                                                the actual teachings of the great explorer of truth the
                                                master builder Denouncing pleasure and praising pain
                                                Denouncing pleasure and praising pain
                                            </p>
                                            <div class="flex-two">
                                                <div class="flex-three relative">
                                                    <div class="image-avata">
                                                        <img src="./assets/images/testimonial/avt4-5.jpg"
                                                            alt="image">
                                                    </div>
                                                    <div class="content-testimonial">
                                                        <h6 class="title">Cameron Williamson</h6>
                                                        <span class="job">Medical Worker</span>
                                                    </div>

                                                </div>
                                                <div class="start">
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                    <i class="icon-Star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-5">
                        <div class="gallery-testimonial-h4 relative">
                            <div thumbsSlider="" class="swiper mySwiperGalllery overflow-hidden">
                                <div class="swiper-pagination"></div>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="image">
                                            <img src="./assets/images/testimonial/avt4-3.jpg" alt="image">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="image">
                                            <img src="./assets/images/testimonial/avt4-4.jpg" alt="image">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="image">
                                            <img src="./assets/images/testimonial/avt4-5.jpg" alt="image">
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>

        </section>
        <!-- Widget Testimonial -->

        <!-- Widget Blog -->
        <section class="section-blog pd-main relative">
            <div class="bg-blog-h4 bg-1"></div>
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12 mb-40">
                        <div class="center m0-auto w-text-heading">
                            <span class="sub-title-heading text-main font-yes fs-28-46  wow fadeInUp animated">Explore
                                the world</span>
                            <h2 class="title-heading  wow fadeInUp animated">Latest news & articles from the
                                blog</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="tf-widget-blog blog-style2">
                            <a href="blog-details.html" class="blog-image">
                                <img src="./assets/images/blog/bl-h4.jpg" alt="">
                                <div class="category-blog">
                                    <i class="icon-Group-8"></i>
                                    <span>Business</span>
                                </div>
                            </a>
                            <div class="blog-content">
                                <ul class="meta-list flex-three">
                                    <li>
                                        <i class="icon-profile-user-1"></i>
                                        <span>Mehedii .H</span>
                                    </li>
                                    <li>
                                        <i class="icon-7"></i>
                                        <span>Coments (03)</span>
                                    </li>
                                </ul>
                                <h3 class="entry-title"><a href="#">How to Prepare for your First Track his
                                        consumer-focused </a></h3>
                                <a href="blog-details.html" class="btn-read-more">Read More <i
                                        class="icon-Vector-4"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tf-widget-blog flex-three blog-style3 wow fadeInUp animated">
                            <a href="blog-details.html" class="blog-image">
                                <img src="./assets/images/blog/bl-h4-1.jpg" alt="">
                            </a>
                            <div class="blog-content">
                                <ul class="meta-list flex-three">
                                    <li>
                                        <i class="icon-profile-user-1"></i>
                                        <span>Mehedii .H</span>
                                    </li>
                                    <li>
                                        <i class="icon-7"></i>
                                        <span>Coments (03)</span>
                                    </li>
                                </ul>
                                <h3 class="entry-title"><a href="blog-details.html">Get Best Advertiser In Your
                                        Side Pocket</a>
                                </h3>
                                <a href="blog-details.html" class="btn-read-more">Read More <i
                                        class="icon-Vector-4"></i></a>
                            </div>
                        </div>
                        <div class="tf-widget-blog flex-three blog-style3 wow fadeInUp animated">
                            <a href="blog-details.html" class="blog-image">
                                <img src="./assets/images/blog/bl-h4-2.jpg" alt="">
                            </a>
                            <div class="blog-content">
                                <ul class="meta-list flex-three">
                                    <li>
                                        <i class="icon-profile-user-1"></i>
                                        <span>Mehedii .H</span>
                                    </li>
                                    <li>
                                        <i class="icon-7"></i>
                                        <span>Coments (03)</span>
                                    </li>
                                </ul>
                                <h3 class="entry-title"><a href="blog-details.html">Get Best Advertiser In Your
                                        Side Pocket</a>
                                </h3>
                                <a href="blog-details.html" class="btn-read-more">Read More <i
                                        class="icon-Vector-4"></i></a>
                            </div>
                        </div>
                        <div class="tf-widget-blog flex-three blog-style3 wow fadeInUp animated">
                            <a href="blog-details.html" class="blog-image">
                                <img src="./assets/images/blog/bl-h4-3.jpg" alt="">
                            </a>
                            <div class="blog-content">
                                <ul class="meta-list flex-three">
                                    <li>
                                        <i class="icon-profile-user-1"></i>
                                        <span>Mehedii .H</span>
                                    </li>
                                    <li>
                                        <i class="icon-7"></i>
                                        <span>Coments (03)</span>
                                    </li>
                                </ul>
                                <h3 class="entry-title"><a href="blog-details.html">Get Best Advertiser In Your
                                        Side Pocket</a>
                                </h3>
                                <a href="blog-details.html" class="btn-read-more">Read More <i
                                        class="icon-Vector-4"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- Widget Blog -->

        <!-- Widget Brand logo -->
        <section class="relative bg-1 brand-logo-h4">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12 relative center line-brand-logo wow fadeInUp animated">
                        <div class="line"></div>
                        <p class="line-text">We’ve been mentioned in Below Brands</p>
                    </div>
                    <div class="col-lg-12 widget-brand-logo">
                        <div class="swiper brand-logo overflow-hidden">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="./assets/images/page/brand-logo.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./assets/images/page/brand-logo.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./assets/images/page/brand-logo.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./assets/images/page/brand-logo.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./assets/images/page/brand-logo.png" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./assets/images/page/brand-logo.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Widget Brand logo -->

    </main>


@endsection
