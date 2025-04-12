@extends('auth.template')
@section('title', 'Sign Up')

@section('content')
    <main id="main">

        <section class="breadcumb-section">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12 center z-index1">
                        <h1 class="title">user sign up</h1>
                        <ul class="breadcumb-list flex-five">
                            <li><a href="#">Home</a></li>
                            <li><span>user sign up</span></li>
                        </ul>
                        <img class="bcrumb-ab" src="{{ url('/assets/images/page/mask-bcrumb.png') }}" alt="">
                    </div>
                </div>
            </div>
        </section>

        <div>
            @if ($errors->any())
                <div class="col-12">
                    @foreach ($errors->all() as $error)
                        <div class="d-flex justify-content-center alert alert-danger">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session()->has('Error'))
                <div class="d-flex justify-content-center alert alert-danger">{{ session('Error') }}</div>
            @endif

            @if (session()->has('Success'))
                <div class="d-flex justify-content-center alert alert-success">{{ session('Success') }}</div>
            @endif
        </div>

        <section class="login">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-wrap flex">
                            <div class="image">
                                <img src="{{ url('/assets/images/page/sign-up.jpg') }}" alt="image">
                            </div>
                            <div class="content">
                                <div class="inner-header-login">
                                    <h3 class="title">Create an account to get started</h3>
                                </div>
                                <form action="{{ route('register.post') }}" method="POST" id="sign-up"
                                    class="login-user">
                                    @csrf
                                    <input type="hidden" name="status" id="status" value="inavtive">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-wrap">
                                                <label>First Name</label>
                                                <input name="first_name" id="first_name" type="text"
                                                    placeholder="Enter your first name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrap">
                                                <label>Last Name</label>
                                                <input name="last_name" id="last_name" type="text"
                                                    placeholder="Enter your last name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrap">
                                                <label>Birthday</label>
                                                <input name="birthday" id="birthday" type="date"
                                                    placeholder="Enter your birthday" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-wrap">
                                                <label for="gender">Gender</label>
                                                <select class="nice-select" name="gender" id="gender" required>
                                                    <option class="option selected focus" value="">Choose your gender</option>
                                                    <option class="option" value="male">Male</option>
                                                    <option class="option" value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-wrap">
                                                <div class="flex-two">
                                                    <label>Role</label>
                                                </div>
                                                <select class="nice-select" name="role" id="role" required>
                                                    <option class="option selected focus" value="">Choose your account
                                                        type</option>
                                                    <option class="option" value="travler">Travler</option>
                                                    <option class="option" value="guide">Guide</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-wrap">
                                                <div class="flex-two">
                                                    <label>Phone Number</label>
                                                </div>
                                                <input name="phone" id="phone" type="tel"
                                                    placeholder="Enter your phone" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-wrap">
                                                <div class="flex-two">
                                                    <label>Email</label>
                                                </div>
                                                <input name="email" id="email" type="email"
                                                    placeholder="Enter your email" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="input-wrap">
                                                <div class="flex-two">
                                                    <label>Password</label>
                                                </div>
                                                <input name="password" id="password" type="password"
                                                    placeholder="Enter your Password" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-40">
                                            <div class="input-wrap-social ">
                                                <span class="or">or</span>
                                                <div class="flex-three">
                                                    <a href="#" class="login-social flex-three">
                                                        <img src="{{ url('/assets/images/page/gg.png') }}" alt="image">
                                                        <span>Sign in with Google</span>
                                                    </a>
                                                    <a href="#" class="login-social flex-three">
                                                        <img src="{{ url('/assets/images/page/fb.png') }}" alt="image">
                                                        <span>Sign in with facebook</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-30">
                                            <div class="checkbox">
                                                <input id="check-policy" type="checkbox" name="check" value="check" required>
                                                <label for="check-policy">By signing up, you agree to our 
                                                    Customers <a href="">Terms Of Service and Privacy Policy</a></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-30">
                                            <button type="submit" class="btn-submit">Sign Up</button>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="flex-three">
                                                <span class="account">Don,t you have an account?</span>
                                                <a href="{{ route('login') }}" class="link-login">Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="brand-logo-widget bg-1">
            <div class="tf-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="swiper brand-logo overflow-hidden">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="{{ url('/assets/images/page/brand-logo.png') }}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ url('/assets/images/page/brand-logo.png') }}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ url('/assets/images/page/brand-logo.png') }}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ url('/assets/images/page/brand-logo.png') }}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ url('/assets/images/page/brand-logo.png') }}" alt="">
                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ url('/assets/images/page/brand-logo.png') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <section class="mb--93 bg-1">
            <div class="tf-container">
                <div class="callt-to-action flex-two z-index3 relative">
                    <div class="callt-to-action-content flex-three">
                        <div class="image">
                            <img src="{{ url('/assets/images/page/ready.png') }}" alt="Image">
                        </div>
                        <div class="content">
                            <h2 class="title-call">Ready to adventure and enjoy natural</h2>
                            <p class="des">Lorem ipsum dolor sit amet, consectetur notted adipisicin</p>
                        </div>
                    </div>
                    <img src="{{ url('/assets/images/page/vector4.png') }}" alt="" class="shape-ab">
                    <div class="callt-to-action-button">
                        <a href="#" class="get-call">Let,s get started</a>
                    </div>
                </div>
            </div>

        </section>

    </main>
@endsection
