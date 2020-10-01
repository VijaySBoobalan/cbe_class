<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TrioTendSolutions Virtual Learning Environment</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">
  <!-- Favicons -->
  <link href="{{ url('website/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ url('website/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ url('website/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
  <link href="{{ url('website/assets/vendor/aos/aos.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ url('website/assets/css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Selecao - v2.1.0
  * Template URL: https://bootstrapmade.com/selecao-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="{{ url('/') }}">TTS-VLE</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{ url('/') }}"></a>
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="#hero">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <!-- <li><a href="#portfolio">Portfolio</a></li>-->

          <li><a href="#contact">Contact</a></li>
          @if(Auth::guard('student')->check())
          @auth
          <li><a href="{{ url('/home') }}">Back To App</a></li>
          @else
          <li><a href="{{ route('student/login') }}">App Login</a></li>
          @endauth
          @else
          @auth
          <li><a href="{{ url('/home') }}">Back To App</a></li>
          @else
          <li><a href="{{ route('login') }}">App Login</a></li>
          @endauth
          @endif

          {{-- @if(Auth::guard('web')->check())
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::guard('web')->user()->name }} <span class="caret"></span>
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a href="{{route('home')}}" class="dropdown-item">Dashboard</a>
            <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                document.querySelector('#logout-form').submit();">
              Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
          </li>
          @endif
          @if(Auth::guard('student')->check())
          <li class="nav-item dropdown">
            <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::guard('admin')->user()->name }} (ADMIN) <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
              <a href="{{route('admin.home')}}" class="dropdown-item">Dashboard</a>
              <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                document.querySelector('#admin-logout-form').submit();">
                Logout
              </a>

              <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
          @endif --}}


        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
    <div id="heroCarousel" class="container carousel carousel-fade" data-ride="carousel">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="carousel-container">

          <h2 class="animated fadeInDown">Welcome to TrioTendSolutions </h2>
          <p>
            <img src="{{ url('website/assets/img/logo.png') }}" alt="" class="hero-image "> <span>
          </p>
          <a href="https://ttsvle.in/apks/ttsvle.apk" class="btn-get-started animated fadeInUp scrollto">
            <h3>Download Student APK</h3>
          </a>
        </div>
      </div>






    </div>


    </div>

    <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
      <defs>
        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
      </defs>
      <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
      </g>
      <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
      </g>
      <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
      </g>
    </svg>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>About</h2>
          <p>Who we are</p>
        </div>

        <div class="row content" data-aos="fade-up">

          <ul>
            <li><i class="ri-check-double-line"></i>
              <p align="justify"> Virtual Learning Environment is an integral part of the Learning Management System.</p>
            </li>
            <li><i class="ri-check-double-line"></i>
              <p align="justify"> TrioTendSolutions Virtual Learning Environment Provides a complete solution to Schools to deliver live online classes.</p>
            </li>
            <li><i class="ri-check-double-line"></i>
              <p align="justify"> TrioTendSolutions Virtual Learning Environment offers an intuitive, seamless virtual classroom for teachers and online schools wanting purpose-built features, better insights into the class.
                Our virtual classroom includes: - Reliable live video + high quality audio - Interactive online whiteboard, note-taking, screen-sharing, Attendance.
                Students attain overall a better experience than being in a physical classroom.</p>
            </li>

            <li><i class="ri-check-double-line"></i>
              <p align="justify"> A flexible web-based solution for creating and managing online and blended learning services.
            </li>
            <li><i class="ri-check-double-line"></i>
              <p align="justify">A virtual classroom is an online learning environment that allows teachers and students to communicate, interact, collaborate and explain ideas.</p>
            </li>
            <li><i class="ri-check-double-line"></i>
              <p align="justify">Our virtual classroom includes: - Reliable live video + high quality audio - Interactive online whiteboard, note-taking, screen-sharing, Attendance.</p>
            </li>
          </ul>
          </p>


        </div>
    </section><!-- End About Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
      <div class="container">

        <ul class="nav nav-tabs row d-flex">
          <li class="nav-item col-3" data-aos="zoom-in">
            <a class="nav-link active show" data-toggle="tab" href="#tab-1">
              <i class="ri-computer-line"></i>
              <h4 class="d-none d-lg-block">Screen sharing</h4>
            </a>
          </li>
          <li class="nav-item col-3" data-aos="zoom-in" data-aos-delay="100">
            <a class="nav-link" data-toggle="tab" href="#tab-2">
              <i class="ri-window-fill"></i>
              <h4 class="d-none d-lg-block">White board</h4>
            </a>
          </li>
          <li class="nav-item col-3" data-aos="zoom-in" data-aos-delay="200">
            <a class="nav-link" data-toggle="tab" href="#tab-3">
              <i class="ri-tools-line"></i>
              <h4 class="d-none d-lg-block">Mathematical Tool</h4>
            </a>
          </li>
          <li class="nav-item col-3" data-aos="zoom-in" data-aos-delay="300">
            <a class="nav-link" data-toggle="tab" href="#tab-4">
              <i class="ri-character-recognition-line"></i>
              <h4 class="d-none d-lg-block">Attendance</h4>
            </a>
          </li>
        </ul>

        <div class="tab-content" data-aos="fade-up">
          <div class="tab-pane active show" id="tab-1">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Share and discuss files in real time!</h3>
                <p class="justify">
                  Screen sharing Feature helps your students follow along in your online virtual classroom. When you share anything on your computer screen, actions you take in the shared region are visible to all students in the live stream.
                  Students follow the progress of your cursor as you move it across your screen and you can answer their questions in real time with screen sharing.TTSVLE provides a text editor for teachers so that they can type important notes while sharing the screen that’s visible to the student.

                </p>

              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="{{ url('website/assets/img/features-1.png') }}" alt="" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab-2">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Online Whiteboard </h3>
                <p align="justify">
                  The online whiteboard is the primary interactive element of the Virtual Classroom
                  Collaborate simply with a modern online whiteboard for teaching.Fully engage in your digital learning experience on your favourite mobile device.
                  Learn with no limits.Effortless real-time collaboration: draw, write, sketch ideas in real-time Draw and write together on a digital whiteboard in your online virtual classroom.

                  Tools available in the whiteboard are brush tool, fill color, eraser, undo, redo, close and download (the written content).

                </p>

              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="{{ url('website/assets/img/features-2.png') }}" alt="" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab-3">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>TTS-VLE Mathematical tools </h3>
                <p>
                  TTSVLE provides mathematical tools such as Calculator, Geometry,
                  Graph and Logbook.The out-of-the-box advanced geometric shapes and graphs make it easy to teach math and statistics.
                </p>
                <ul>
                  <li><i class="ri-check-double-line"></i> Calculator Solves expressions and counts the number of significant figures.</li>
                  <li><i class="ri-check-double-line"></i> Interactive geometry tool to create triangles, circles, angles, transformations and much more.</li>
                  <li><i class="ri-check-double-line"></i> TTSVLE Graph provides Graph functions, plot points, visualize algebraic equations, add sliders, animate graphs.</li>
                </ul>
                <p class="font-italic">
                  Teachers can use these tools to teach math in live stream.
                </p>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="{{ url('website/assets/img/features-3.png') }}" alt="" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="tab-pane" id="tab-4">
            <div class="row">
              <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                <h3>Instinctive attendance of each student is maintained based on their presence in online class.</h3>
                <ul>
                  <li><i class="ri-check-double-line"></i> Accurately track and total the hours of students presence.</li>
                  <li><i class="ri-check-double-line"></i> Attendance of a student for each class is calculated from the login time to logout time.</li>
                  <li><i class="ri-check-double-line"></i> Attendance report is generated as class wise and students wise.</li>
                </ul>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 text-center">
                <img src="{{ url('website/assets/img/features-4.png') }}" alt="" class="img-fluid">
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Features Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container">

        <div class="row" data-aos="zoom-out">
          <div class="col-lg-9 text-center text-lg-left">
            <div class="section-title" data-aos="zoom-out">
              <h2>Free Estimation</h2>
              <p>REQUEST FOR A DEMO</p>
            </div>
          </div>
          <div class="col-lg-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="#contact">Call To Action</a>
          </div>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Services</h2>
          <p>What we do offer</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="icon-box" data-aos="zoom-in-left">
              <div class=""><i class="ri-admin-fill" style="color: #ff689b;"></i></div>
              <h4 class="title"><a href="">Admin</a></h4>
              <p class="description">Admin can access all the modules, schedule the online classes for staffs and students, trackthe online classes
                Also can access all the login and payment details.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-5 mt-md-0">
            <div class="icon-box" data-aos="zoom-in-left" data-aos-delay="100">
              <div class=""><i class="ri-parent-line" style="color: #e9bf06;"></i></div>
              <h4 class="title"><a href="">Student and parents</a></h4>
              <p class="description">Students can view the schedule for the online classes and attend their classes in live stream based on the schedule.
                They can analyse their test reports.
                Students have the accessibility to view the videos of previous classes.
              </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-5 mt-lg-0 ">
            <div class="icon-box" data-aos="zoom-in-left" data-aos-delay="200">
              <div class=""><i class="ri-user-fill" style="color: #3fcdc7;"></i></div>
              <h4 class="title"><a href="">Staff</a></h4>
              <p class="description">Staffs can teach their classes in live stream based on the schedule.
                They can upload the study material and practice mode documents .
                They can prepare the test questions for online tests.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-5">
            <div class="icon-box" data-aos="zoom-in-left" data-aos-delay="300">
              <div class=""><i class="las la-book" style="color:#41cf2e;"></i></div>
              <h4 class="title"><a href="">Digital Library </a></h4>
              <p class="description">TTSVLE provide digital library for staff and student. Books are available in Pdf documents.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-5">
            <div class="icon-box" data-aos="zoom-in-left" data-aos-delay="400">
              <div class=""><i class="ri-edit-box-fill" style="color: #d6ff22;"></i></div>
              <h4 class="title"><a href="">Online test</a></h4>
              <p class="description">Create Unlimited online practice tests and conduct exams through online in secure manner and comprehensive set of real-time reports allowing you to measure accurately the effectiveness of all exams.</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mt-5">
            <div class="icon-box" data-aos="zoom-in-left" data-aos-delay="500">
              <div class=""><i class="ri-file-list-fill" style="color: #4680ff;"></i></div>
              <h4 class="title"><a href="">Study Materials</a></h4>
              <p class="description">Admin and staffs can upload the study materials which can be viewed by the students.
                All type of files can be uploaded as a study material.
              </p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Portfolio Section =======
    <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Portfolio</h2>
          <p>What we've done</p>
        </div>

        <ul id="portfolio-flters" class="d-flex justify-content-end" data-aos="fade-up">
          <li data-filter="*" class="filter-active">All</li>
          <li data-filter=".filter-app">Web-App</li>
          <li data-filter=".filter-web">Mobile-App</li>
        </ul>

        <div class="row portfolio-container" data-aos="fade-up">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>App 1</h4>
              <p>App</p>
              <a href="assets/img/portfolio/portfolio-1.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>



          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>App 2</h4>
              <p>App</p>
              <a href="assets/img/portfolio/portfolio-3.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Card 2</h4>
              <p>Card</p>
              <a href="assets/img/portfolio/portfolio-4.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Web 2</h4>
              <p>Web</p>
              <a href="assets/img/portfolio/portfolio-5.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>App 3</h4>
              <p>App</p>
              <a href="assets/img/portfolio/portfolio-6.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Card 1</h4>
              <p>Card</p>
              <a href="assets/img/portfolio/portfolio-7.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Card 3</h4>
              <p>Card</p>
              <a href="assets/img/portfolio/portfolio-8.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt=""></div>
            <div class="portfolio-info">
              <h4>Web 3</h4>
              <p>Web</p>
              <a href="assets/img/portfolio/portfolio-9.jpg" data-gall="portfolioGallery" class="venobox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
              <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Section -->





    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4" data-aos="fade-right">
            <div class="info">
              <div class="address">
                <i class="icofont-google-map"></i>
                <h4>Location:</h4>
                <p>386, II Floor, MRG Tower, Sathy Main Road, Ganapathy coimbatore-641006</p>
              </div>

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p>trio@ttsvle.in</p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Call:</h4>
                <p>+91-422-4957467</p>
                <p>+91-9994785467</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">
            <div class="section-title" data-aos="zoom-out">
              <h2>Free Estimation</h2>
              <p>REQUEST FOR A DEMO</p>
            </div>
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>TrioTendSolutions</h3>
      <p>We Work For Your Bussiness Needs!</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
      <div class="copyright">
        &copy; Copyright <strong><span>TrioTendSolutions</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/selecao-bootstrap-template/ -->

      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ url('website/assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ url('website/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ url('website/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
  <script src="{{ url('website/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ url('website/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ url('website/assets/vendor/venobox/venobox.min.js') }}"></script>
  <script src="{{ url('website/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ url('website/assets/vendor/aos/aos.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ url('website/assets/js/main.js') }}"></script>

</body>

</html>