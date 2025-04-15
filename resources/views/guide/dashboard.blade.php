@extends('guide.template')
@section('title', 'Dashboard | Guide')

@section('content')

    <!-- End Main Header -->
    <main id="main">
        <section class="profile-dashboard">
            <div class="inner-header mb-40">
                <h3 class="title">Add Tour</h3>
                <p class="des">There are many variations of passages of Lorem Ipsum</p>
            </div>
            <form action="/" id="form-add-tour" class="form-add-tour">
                <div class="widget-dash-board pr-256 mb-75">
                    <h4 class="title-add-tour mb-30">1. information</h4>
                    <div class="grid-input-2 mb-45">
                        <div class="input-wrap">
                            <label>Enter your tittle</label>
                            <input type="text" placeholder="Switzerland city tour">
                        </div>
                        <div class="input-wrap">
                            <label>Enter your tittle</label>
                            <div class="nice-select" tabindex="0">
                                <span class="current">Catagory</span>
                                <ul class="list">
                                    <li data-value="" class="option selected focus">Catagory</li>
                                    <li data-value="category 1" class="option">Catagory 1</li>
                                    <li data-value="category 2" class="option">Catagory 2</li>
                                    <li data-value="category 3" class="option">Catagory 3</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="input-wrap mb-45">
                        <label>Enter Keyword</label>
                        <input type="text" placeholder="Keyword">
                    </div>
                    <div class="input-wrap mb-45">
                        <label>Description</label>
                        <textarea name="description" rows="12" cols="50" placeholder="Write content"></textarea>
                    </div>
                    <div class="input-wrap">
                        <label>Upload Photo</label>
                        <div class="upload-image-add-car mb-30">
                            <div class="upload-image">
                                <label for="photoLoad" class="uploadLabel">
                                    <i class="icon-Group-10"></i>
                                    <span>Add a Photo</span>
                                    <input type="file" id="photoLoad" class="photoLoad" accept="image/*">
                                </label>
                            </div>
                            <div class="upload-image">
                                <label for="photoLoad1" class="uploadLabel">
                                    <i class="icon-Group-10"></i>
                                    <span>Add a Photo</span>
                                    <input type="file" id="photoLoad1" class="photoLoad" accept="image/*">
                                </label>
                            </div>
                            <div class="upload-image">
                                <label for="photoLoad2" class="uploadLabel">
                                    <i class="icon-Group-10"></i>
                                    <span>Add a Photo</span>
                                    <input type="file" id="photoLoad2" class="photoLoad" accept="image/*">
                                </label>
                            </div>
                            <div class="upload-image">
                                <label for="photoLoad3" class="uploadLabel">
                                    <i class="icon-Group-10"></i>
                                    <span>Add a Photo</span>
                                    <input type="file" id="photoLoad3" class="photoLoad" accept="image/*">
                                </label>
                            </div>
                        </div>
                        <p><span class="text-main">*</span>Supported <span class="text-main">Png</span> &
                            Jpg Not more than 2 Mb</p>
                    </div>

                </div>
                <div class="widget-dash-board pr-256 mb-75">
                    <h4 class="title-add-tour mb-30">2. Tour Planing</h4>

                    <div class="input-wrap mb-45">
                        <div class="flex-two mb-70">
                            <input type="text" placeholder="Enter Tittle">
                            <div class="icon-delete-title flex-five">
                                <i class="icon-delete-1"></i>
                            </div>
                        </div>
                        <textarea class="textarea-tinymce" name="area"></textarea>

                    </div>
                    <div class="input-wrap text-end">
                        <button type="button" class="button-add"> <i class="icon-uniE914"></i>Add</button>

                    </div>


                </div>
                <div class="widget-dash-board pr-256 mb-75">
                    <h4 class="title-add-tour mb-30">2. Location</h4>
                    <div class="grid-input-2 mb-45">
                        <div class="input-wrap">
                            <label>Select City</label>
                            <div class="nice-select" tabindex="0">
                                <span class="current">London</span>
                                <ul class="list">
                                    <li data-value="" class="option selected focus">London</li>
                                    <li data-value="tokyo" class="option">Tokyo</li>
                                    <li data-value="hanoi" class="option">Ha noi</li>
                                    <li data-value="taiwan" class="option">Taiwan</li>
                                </ul>
                            </div>
                        </div>
                        <div class="input-wrap">
                            <label>Select State</label>
                            <div class="nice-select" tabindex="0">
                                <span class="current">state</span>
                                <ul class="list">
                                    <li data-value="" class="option selected focus">state</li>
                                    <li data-value="category 1" class="option">state 1</li>
                                    <li data-value="category 2" class="option">state 2</li>
                                    <li data-value="category 3" class="option">state 3</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="input-wrap mb-40">
                        <label>Address Details</label>
                        <div class="flex-two ">
                            <input type="text" placeholder="2464 Royal Ln. Mesa, New Jersey 45463">
                            <div class="icon-delete-title flex-five">
                                <i class="icon-Vector5"></i>
                            </div>
                        </div>
                    </div>
                    <div class="input-wrap mb-40">
                        <div class="map3 relative">
                            <div id="map3"></div>
                        </div>

                    </div>
                    <div class="grid-input-2 mb-45">
                        <div class="input-wrap">
                            <label>Zip Code</label>
                            <input type="text" placeholder="3462">
                        </div>
                        <div class="input-wrap">
                            <label>Country</label>
                            <input type="text" placeholder="United Kingdom">
                        </div>
                    </div>
                    <div class="input-wrap ">
                        <button type="button" class="button-add"> Save changes </button>

                    </div>


                </div>
                <div class="widget-dash-board pr-256 mb-75">
                    <h4 class="title-add-tour mb-30">2. What’s Include?</h4>
                    <div class="row mb-60">
                        <div class="col-lg-3">
                            <div class="checkbox">
                                <input id="check" type="checkbox" name="check" value="check">
                                <label for="check">Laundry Service</label>
                            </div>
                            <div class="checkbox">
                                <input id="check1" type="checkbox" name="check" value="check">
                                <label for="check1">Food & Drinks</label>
                            </div>
                            <div class="checkbox">
                                <input id="check2" type="checkbox" name="check" value="check">
                                <label for="check2">Swimming Pool</label>
                            </div>
                            <div class="checkbox">
                                <input id="check3" type="checkbox" name="check" value="check">
                                <label for="check3">Alarm System</label>
                            </div>
                            <div class="checkbox">
                                <input id="check4" type="checkbox" name="check" value="check">
                                <label for="check4">Navigation</label>
                            </div>
                            <div class="checkbox">
                                <input id="check5" type="checkbox" name="check" value="check">
                                <label for="check5">Window Coverings</label>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="checkbox">
                                <input id="conditioning" type="checkbox" name="check" value="check">
                                <label for="conditioning">Air Conditioning</label>
                            </div>
                            <div class="checkbox">
                                <input id="microwave" type="checkbox" name="check" value="check">
                                <label for="microwave">Microwave</label>
                            </div>
                            <div class="checkbox">
                                <input id="outdoor" type="checkbox" name="check" value="check">
                                <label for="outdoor">Outdoor Shower</label>
                            </div>
                            <div class="checkbox">
                                <input id="alarm" type="checkbox" name="check" value="check">
                                <label for="alarm">Alarm System</label>
                            </div>
                            <div class="checkbox">
                                <input id="navigation" type="checkbox" name="check" value="check">
                                <label for="navigation">Navigation</label>
                            </div>
                            <div class="checkbox">
                                <input id="covering" type="checkbox" name="check" value="check">
                                <label for="covering">Window Covering</label>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="checkbox">
                                <input id="check13" type="checkbox" name="check" value="check">
                                <label for="check13">Laundry Service</label>
                            </div>
                            <div class="checkbox">
                                <input id="check88" type="checkbox" name="check" value="check">
                                <label for="check88">Food & Drinks</label>
                            </div>
                            <div class="checkbox">
                                <input id="check99" type="checkbox" name="check" value="check">
                                <label for="check99">Swimming Pool</label>
                            </div>
                            <div class="checkbox">
                                <input id="check43" type="checkbox" name="check" value="check">
                                <label for="check43">Alarm System</label>
                            </div>
                            <div class="checkbox">
                                <input id="check53" type="checkbox" name="check" value="check">
                                <label for="check53">Navigation</label>
                            </div>
                            <div class="checkbox">
                                <input id="check63" type="checkbox" name="check" value="check">
                                <label for="check63">Window Coverings</label>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="checkbox">
                                <input id="check41" type="checkbox" name="check" value="check">
                                <label for="check41">Laundry Service</label>
                            </div>
                            <div class="checkbox">
                                <input id="check42" type="checkbox" name="check" value="check">
                                <label for="check42">Food & Drinks</label>
                            </div>
                            <div class="checkbox">
                                <input id="check77" type="checkbox" name="check" value="check">
                                <label for="check77">Swimming Pool</label>
                            </div>
                            <div class="checkbox">
                                <input id="check66" type="checkbox" name="check" value="check">
                                <label for="check66">Alarm System</label>
                            </div>
                            <div class="checkbox">
                                <input id="check44" type="checkbox" name="check" value="check">
                                <label for="check44">Navigation</label>
                            </div>
                            <div class="checkbox">
                                <input id="check54" type="checkbox" name="check" value="check">
                                <label for="check54">Window Coverings</label>
                            </div>

                        </div>
                    </div>

                    <div class="input-wrap ">
                        <button type="button" class="button-add"> Save changes </button>

                    </div>


                </div>
                <div class="widget-dash-board pr-256 mb-75">
                    <h4 class="title-add-tour mb-30">3. Pricing</h4>

                    <div class="grid-input-2 mb-45">
                        <div class="input-wrap">
                            <label>Tour Price</label>
                            <input type="text" placeholder="$3215">
                        </div>
                        <div class="input-wrap">
                            <label>Tour Price</label>
                            <input type="text" placeholder="$3215">
                        </div>
                    </div>
                    <div class="input-wrap">
                        <label>Extra Price</label>
                        <div class="flex-two mb-32">
                            <div class="grid-input-3">
                                <input type="text" placeholder="Add Service Per Booking">
                                <input type="text" placeholder="Description">
                                <input type="text" placeholder="$27">
                            </div>
                            <div class="icon-delete-price">
                                <i class="icon-delete-1"></i>
                            </div>
                        </div>
                        <div class="flex-two">
                            <div class="grid-input-3">
                                <input type="text" placeholder="Add Service Per Booking">
                                <input type="text" placeholder="Description">
                                <input type="text" placeholder="$27">
                            </div>
                            <div class="icon-delete-price">
                                <i class="icon-delete-1"></i>
                            </div>

                        </div>


                    </div>

                </div>
                <div class="widget-dash-board pr-256">
                    <h4 class="title-add-tour mb-30">3. Tour date & Time</h4>

                    <div class="grid-input-2 mb-25">
                        <div class="input-wrap">
                            <label>Tour duration</label>
                            <div class="nice-select" tabindex="0">
                                <span class="current">2-4 days tour</span>
                                <ul class="list">
                                    <li data-value="" class="option selected focus">2-4 days tour</li>
                                    <li data-value="3-6" class="option">3-6 days tour</li>
                                    <li data-value="4-8" class="option">4-8 days tour</li>
                                    <li data-value="5-10" class="option">5-10 days tour</li>
                                </ul>
                            </div>
                        </div>
                        <div class="input-wrap">
                            <label>Start date</label>
                            <input type="date">
                        </div>
                    </div>
                    <div class="grid-input-2 mb-45">
                        <div class="input-wrap">
                            <label>Return Date</label>
                            <input type="date">
                        </div>
                        <div class="input-wrap">

                        </div>
                    </div>
                    <div class="input-wrap">
                        <button type="button" class="button-add"> Save changes</button>
                    </div>

                </div>

            </form>


        </section>
    </main>
    
@endsection
