@extends('admin.template')
@section('title', 'Admin | Dashboard')

@section('content')

    <!-- End Main Header -->
    <main id="main">
        <section class="profile-dashboard">
            <div class="inner-header mb-40">
                <h3 class="title">Dashboard</h3>
                <p class="des">There are many variations of passages of Lorem Ipsum</p>
            </div>
            <div class="counter-grid-dashboard mb-70">
                <div class="counter-dashboard flex-three tf-countto">
                    <div class="icon flex-five">
                        <i class="icon-earnings-1"></i>
                    </div>
                    <div class="content">
                        <span>Total Earning</span>
                        <div class="number-counter money" data-to="43216" data-speed="2000" data-waypoint-active="yes">43216
                        </div>
                    </div>
                </div>
                <div class="counter-dashboard flex-three tf-countto">
                    <div class="icon flex-five">
                        <i class="icon-heart-1"></i>
                    </div>
                    <div class="content">
                        <span>My Wishlist</span>
                        <div class="number-counter plus" data-to="2351" data-speed="2000" data-waypoint-active="yes">2351
                        </div>
                    </div>
                </div>
                <div class="counter-dashboard flex-three tf-countto">
                    <div class="icon flex-five">
                        <i class="icon-Group-1000003085"></i>
                    </div>
                    <div class="content">
                        <span>Total Listing</span>
                        <div class="number-counter" data-to="43216" data-speed="2000" data-waypoint-active="yes">43216</div>
                    </div>
                </div>
                <div class="counter-dashboard flex-three tf-countto">
                    <div class="icon flex-five">
                        <i class="icon-feedback"></i>
                    </div>
                    <div class="content">
                        <span>Total Listing</span>
                        <div class="number-counter plus" data-to="2351" data-speed="2000" data-waypoint-active="yes">2351
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-8 col-xl-12">
                    <div class="page-insight">
                        <!-- chart -->
                        <div class="wg-box">
                            <div class="flex-two">
                                <h5>Total page view</h5>
                                <div class="group-select">
                                    <div class="nice-select" tabindex="0">
                                        <span class="current">This Week</span>
                                        <ul class="list">
                                            <li data-value class="option selected">This Week</li>
                                            <li data-value="Last day" class="option">Last Day</li>
                                            <li data-value="Last Week" class="option">Last Week</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="line-chart-1"></div>
                        </div>
                        <!-- /chart -->
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-12">
                    <div class="tfcl-card dashboard-message mb-25">
                        <h4 class="title mb-30">What,s New?</h4>
                        <ul class="message">
                            <li class="flex-three">
                                <div class="icon">
                                    <i class="icon-Group4"></i>
                                </div>
                                <p>Congratulation Your <span class="text-main">23</span> Listing has been
                                    approved Today</p>
                            </li>
                            <li class="flex-three">
                                <div class="icon">
                                    <i class="icon-Vector-131"></i>
                                </div>
                                <p>Someone is saved your listing</p>
                            </li>
                            <li class="flex-three">
                                <div class="icon">
                                    <div class="icon-Vector-141"></div>
                                </div>
                                <p>You have unread <span class="text-main">21</span> Message</p>
                            </li>
                            <li class="flex-three">
                                <div class="icon">
                                    <i class="icon-Vector-131"></i>
                                </div>
                                <p>Congratulation Your <span class="text-main">22</span> Listing has
                                    been</p>
                            </li>
                            <li class="flex-three">
                                <div class="icon">
                                    <i class="icon-Vector-131"></i>
                                </div>
                                <p>Mehedii Added Favorites Your listing “Mercedez Benz 2.3”</p>
                            </li>
                            <li class="flex-three">
                                <div class="icon">
                                    <i class="icon-Vector-141"></i>
                                </div>
                                <p>You have unread <span class="text-main">21</span> Message</p>
                            </li>
                            <li class="flex-three">
                                <div class="icon">
                                    <i class="icon-Vector-131"></i>
                                </div>
                                <p>Congratulation Your <span class="text-main">22</span> Listing has been
                                </p>
                            </li>
                        </ul>
                    </div>
                    <div class="tfcl-card dashboard-reviews">
                        <h4 class="title mb-30">Recent Reviews</h4>
                        <ul>
                            <li class="comment-by-user flex-three">
                                <div class="group-author">
                                    <img src="./assets/images/avata/avt-review.jpg" alt="image">
                                </div>
                                <div class="content">
                                    <div class="group-name flex-one">
                                        <div class="review-name">Rohan De Spond</div>
                                        <div class="rating-wrap">
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, con covered many vulputate ves
                                    </p>
                                </div>
                            </li>
                            <li class="comment-by-user flex-three">
                                <div class="group-author">
                                    <img src="./assets/images/avata/avt-review2.jpg" alt="image">
                                </div>
                                <div class="content">
                                    <div class="group-name flex-one">
                                        <div class="review-name">Mehedii. Has</div>
                                        <div class="rating-wrap">
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, con covered many vulputate ves
                                    </p>
                                </div>
                            </li>
                            <li class="comment-by-user flex-three">
                                <div class="group-author">
                                    <img src="./assets/images/avata/avt-review.jpg" alt="image">
                                </div>
                                <div class="content">
                                    <div class="group-name flex-one">
                                        <div class="review-name">Rohan De Spond</div>
                                        <div class="rating-wrap">
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, con covered many vulputate ves
                                    </p>
                                </div>
                            </li>
                            <li class="comment-by-user flex-three">
                                <div class="group-author">
                                    <img src="./assets/images/avata/avt-review3.jpg" alt="image">
                                </div>
                                <div class="content">
                                    <div class="group-name flex-one">
                                        <div class="review-name">Mehedii. Has</div>
                                        <div class="rating-wrap">
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                            <i class="icon-Star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, con covered many vulputate ves
                                    </p>
                                </div>
                            </li>

                        </ul>

                    </div>

                </div>
            </div>

        </section>

    </main>

@endsection
