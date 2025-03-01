<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" href="https://i.postimg.cc/fyZ0fqZK/proteamhub-logo.png" type="image/png">

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ProTeamHub - Build and Form Teams with Experts</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="proteamhub-logo.png" type="image/svg+xml">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Source+Sans+Pro:wght@600;700&display=swap"
    rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>

<body id="top">

  <!-- HEADER -->
  <header class="header" data-header>
    <div class="container">
      <div class="overlay" data-overlay></div>

      <a href="#">
        <h1 class="logo">ProTeamHub</h1>
      </a>

      <nav class="navbar" data-navbar>
        <div class="navbar-top">
          <a href="#" class="logo">ProTeamHub</a>
          <button class="nav-close-btn" aria-label="Close Menu" data-nav-close-btn>
            <ion-icon name="close-outline"></ion-icon>
          </button>
        </div>

        <ul class="navbar-list">
          <li class="navbar-item">
            <a href="#home" class="navbar-link" data-navbar-link>Home</a>
          </li>
          <li class="navbar-item">
            <a href="#about" class="navbar-link" data-navbar-link>About Us</a>
          </li>
          <li class="navbar-item">
            <a href="#services" class="navbar-link" data-navbar-link>Services</a>
          </li>
          <li class="navbar-item">
            <a href="#features" class="navbar-link" data-navbar-link>Features</a>
          </li>
          <li class="navbar-item">
            <a href="#blog" class="navbar-link" data-navbar-link>Blog</a>
          </li>
          <!-- <li class="navbar-item">
            <a href="#contact" class="navbar-link" data-navbar-link>Contact</a>
          </li> -->
        </ul>
      </nav>

      <a href="web/" class="btn">
        <ion-icon name="chevron-forward-outline" aria-hidden="true"></ion-icon>
        <span>Get Started</span>
      </a>

      <button class="nav-open-btn" aria-label="Open Menu" data-nav-open-btn>
        <ion-icon name="menu-outline"></ion-icon>
      </button>
    </div>
  </header>

  <main>
    <article>

      <!-- HERO SECTION -->
      <section class="hero" id="home">
        <div class="container">
          <div class="hero-content">
            <p class="hero-subtitle">Connecting you with teams and experts</p>
            <h2 class="h2 hero-title">Build Your Ideal Team with ProTeamHub</h2>
            <p class="hero-text">
              Whether you're looking to join a team or form your own, ProTeamHub is the perfect platform for
              professionals to connect, collaborate, and succeed together.
            </p>
            <a href="web/"><button class="btn">Get Started</button></a>
          </div>
          <figure class="hero-banner">
            <img src="./assets/images/hero-banner.png" width="694" height="529" loading="lazy" alt="Hero Banner"
              class="w-100 banner-animation">
          </figure>
        </div>
      </section>

      <!-- ABOUT SECTION -->
      <section class="section about" id="about">
        <div class="container">
          <figure class="about-banner">
            <img src="./assets/images/about-banner.png" width="700" height="532" loading="lazy" alt="About Banner"
              class="w-100 banner-animation">
          </figure>
          <div class="about-content">
            <h2 class="h2 section-title underline">Why Choose ProTeamHub</h2>
            <p class="about-text">
              At ProTeamHub, we believe in the power of building strong, successful teams. Whether you're a member
              seeking a team or an expert looking for opportunities, we provide the tools you need to make it happen.
            </p>
            <p class="about-text">
              Our platform connects you with diverse teams, offers expert consultations, and facilitates collaboration
              across industries.
            </p>
            <ul class="stats-list">
              <li class="stats-card">
                <p class="h3 stats-title">10,000+</p>
                <p class="stats-text">Members and Experts</p>
              </li>
              <li class="stats-card">
                <p class="h3 stats-title">1,500+</p>
                <p class="stats-text">Teams Created</p>
              </li>
              <li class="stats-card">
                <p class="h3 stats-title">50+</p>
                <p class="stats-text">Expert Consultations</p>
              </li>
            </ul>
          </div>
        </div>
      </section>

      <!-- SERVICES SECTION -->
      <section class="section service" id="services">
        <div class="container">
          <h2 class="h2 section-title underline">Our Services</h2>
          <ul class="service-list">
            <li>
              <div class="service-card">
                <div class="card-icon">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB0klEQVR4nO2WPUvDUBSGH5E2qJuIi/on/ABnHbp2cdPVScU/oJO/QOggDtZRsJP4sblZndTBRV0cOkhpBxWxoEYCpxBukybtNdbAeeCFcO99zzlJ7hcoiqIoipIuHGANuATeRN7zqvQl7bdiDLgB3BBdy5ik/FY4Ecn9RTgJ+K1Zi5G8qZUE/NZcGUmOgXHRidFXTsBvzauRxEvcZMLoe0nAb03qX+DKSHIiiT2ddjGFOvXHZgYoAndA3de+arkIbf2xWAc+fYEefH2ObHFxtsFsQGxbfySzwLcRbMcYMxZRRJyDzMbfll0j2BcwHTAuK7+4LAvT04W0xflytv5QHo3ivemUKp6Be5k2QV9eUSwYBHLAFlCSM6IKfAANoAbcAofAJjAHDPj8A9K2IWNuxdOQGFWJWZIcOclpRQbIA0eSyO1Q3u5yIDKvEXHUkNx5qSU2fcCCsSv1Wk/AMtAfVfwwcPYPCnZDdA6MhhU/JPMwzFwB9oBFYBIYkV+bkWevbUnGVNrEeQfmpRCnC/+d1NpCIWQeFiV4p0wB+yHrZ9vSXwgy1AOuu/47e7cEXZdrSfhdQx2t/AgyAfF/3e+mTC30uiBXX4CUTyFFURRFUfhjfgCIuVLk1g8U3gAAAABJRU5ErkJggg==" alt="user-group-man-woman">
                </div>
                <h3 class="h3 title">Team Formation</h3>
                <p class="text">
                  Easily form teams with experts and members, customize your team based on project needs, and start
                  collaborating.
                </p>
                <!-- <button class="card-btn" aria-label="Show More">
                  <ion-icon name="chevron-forward-outline"></ion-icon>
                </button> -->
              </div>
            </li>
            <li>
              <div class="service-card">
                <div class="card-icon">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADIklEQVR4nO2abWiOURjHfzNEI6Us8pYPiqxQW3lJyqaerJSEtrKaRDZK3pb44Auh1chL7YO8JCXvttIwlHzAYu2LrJiRFKG81DJMR9eT0+l5uc95zrN7T+5/XR/2dP//5/zvc+5zruucQYQIEbKFIUAZcBhoBh4D94HzQC0wOQV3LnBGOG0W8Qg4DczxYWAQUAV0A30pohc4B0wy+FuB32m4fWlC8bdkYmIkcN2y0c9AsfAXeTDRp5lZ6GKiQKaCLtYDXAI2AcuBtcCBBKM1XTT0l/AcqJDpGTQqhBfXuOpi5ILRucvAxCTP5gNrgG/y7DD5XTe4xKUTQLmm8SoTsooGIC8Arwj4qP39XtMowQ0lmobSs8JTjXxTPvigiA0UI9OMD2wG7gjVyGaNqNZxctVIg0Y8RA4bOasRd5HDRo5oxHpy2EidRrxD+EbKXfeRYiN/mkB2jKjVMN3OXgl0ahpXbBpXG99LjayyVhvMTGOkELjomGstsOwL1YZITUDeGOBFCiOrgA8OJn7JtmANlTs9MN7GfmB4mprjtTyfyIiZgKroDFCPnMzg+/qLsVrH4vEG2CvpucoA5sno3TbS9URG9PgKbAiYv3mBqvraHaZBKiOtwBRCQAGwD/gewMQToyztCnMUkmGcFFQt0sEeqQY7gONAaQLOOknrm8IahQgRIvzDfMfDM5e4C2wHRuAZdR7PnWziGTDel4mykEzEQ42OFzQZOU+l5eGZbcSMMlrFbB9G9MMzVbz0F/TksdqHoI/qzQXNWru1PgTfaYLWBUsGaNXaXe9DsN33mwmAPKOwWupD9KixHA4l+6gyzgMKfYjOMpbfY1lOsYuM0VB1uzc0GsvhKbnc8Y1SY3H5Akz12YCaTvcMM91ySDDYg76qQU4YI99rnNh7w2jgVoKdVxVPu2UK2mAUsFKmzk9DU1WJK8gi8oE9wI8k6cRb4AZwENgIrAaWSadUFbhTbl/bUmh0aFdy/XLY0CjD7yun6hKzPqaqNdQV8zbgoWPnP8m3EQvLQLLTw8XADlnVrskC0SZGW+SfBuplyhUNpM5HiPC/4g8kIy4Pf2D5fgAAAABJRU5ErkJggg==" alt="consultation">
                </div>
                <h3 class="h3 title">Expert Consultation</h3>
                <p class="text">
                  Gain insights and advice from professionals across various industries. Our experts are ready to guide
                  you.
                </p>
                <!-- <button class="card-btn" aria-label="Show More">
                  <ion-icon name="chevron-forward-outline"></ion-icon>
                </button> -->
              </div>
            </li>
            <li>
              <div class="service-card">
                <div class="card-icon">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADiElEQVR4nO2aSWgUQRSGv7hvcUs0UcEFRKInLx6CCRgX0IPiFvWsKII7uOFBgksSMehRRE8qiBcPHvRiDlExiBAjuCF4iGYORnBfsqgtD15D0XY7VT3dOob54RGqe17V++etNQQK6H8YCFQDTUAr8BroBb4CnUALcDJCtwgoDXk+PGWbfztsvxruWYiJycAh4AXwHBhmvBsEtAF3gPXA4DRJrAVeGkY+AxqBRUAFMBIYAUwFlgINhu4RoC9AUp752Bd4J17dlDQBCYU64Kcech9Y6LjHsRBv9QBzgOnA55D3EraJYQBwWTeWHNimxFyxyjIUPUNWJ0nkuG76FqjJYZ9pMYiUJ5kTP9UTNTG+gGb9u0LFD00b6QOqgCnqmROaR7Gqk5/YEk4uKAbex/CAF5AfgfUHYJQrkQNGYrvmxI4ESHgRstG12fl9wrU6CemnFgaJt9eo94qBlVrOs+lJ87VGtdEnXCFN7qIFifEhuuMCfSpMHrhMAE2qJM0uLpYBHRHGiCeiUBuh8w7YrtFijVZVXkxukJD5HmKUPI/C6IiknxjHgC7dYBa5oSKi5P6JyJgIIpPiGNATOPCeY5KNBU5p/wkLE0nsKKyL0JFyvkuHS2t0q/LQADGbGl5uMRk/08QOogR4lUW3XYdTp9Dy7wy+YTMt9R9blt9azYnR6olsJETu4oB2VZqn6xbH5N+TQiP0VDa4EPH7wGZdH9X1GUv9EiM8/bnJXNvKp8Cok3G9cG1Rxau6nq3VR2p5meUeO7XuV2oDW+pIoheYr4bX6LV5K44o1/rfbZS9S3rAtZj3kSWORH5kKdPWuBIIp1Ij6WWkdkVdjNCqSoKIhNM3DSl/cFxgxPpyx/1uhhgqX8wEPSus50h4JoKDumGH/gKClswnGvsuaND7RFRjPB14163XgUQgXfSW0Yik3ueCYi0A0hAvhEwDXcAjYLdWvkRRYtwvmo1uLzgPnIuxZ1FgHx+2FTE2ZhiJftZ43ulw+RLDr2tvCiPx11Cpye9pKRUcDiGXrds/dB380sBeNeaGrufqWkIvG9r0s3Lh+ucoU2PeGMkr648Wul/0s86/gqQFvzz6uK2VzVXvn8OLaVCBSFooeIQ8zREvpuQNvAIRCh5JBf0mtDI5kJBpOW/QkAORevIIQ5RMxtET9aqb18jkexjZojGEiPlfD/8NhiiZjErj/xBGBZACfgHD9nCDYHCjXAAAAABJRU5ErkJggg==" alt="project-management">
                </div>
                <h3 class="h3 title">Project Management Tools</h3>
                <p class="text">
                  Get a suite of project management tools to streamline communication, task assignment, and progress
                  tracking.
                </p>
                <!-- <button class="card-btn" aria-label="Show More">
                  <ion-icon name="chevron-forward-outline"></ion-icon>
                </button> -->
              </div>
            </li>
          </ul>
        </div>
      </section>

      <section class="section features" id="features">
        <div class="container">
    
            <h2 class="h2 section-title underline">ProTeamHub Features</h2>
    
            <ul class="features-list">
    
                <li>
                    <div class="features-card">
    
                        <div class="icon">
                            <ion-icon name="bulb-outline"></ion-icon>
                        </div>
    
                        <div class="content">
                            <h3 class="h3 title">Ideas and Insights</h3>
    
                            <p class="text">
                                ProTeamHub provides tools to analyze teams and projects, identifying the best opportunities available.
                            </p>
                        </div>
    
                    </div>
                </li>
    
                <li>
                    <div class="features-card">
    
                        <div class="icon">
                            <ion-icon name="color-palette-outline"></ion-icon>
                        </div>
    
                        <div class="content">
                            <h3 class="h3 title">Custom Design</h3>
    
                            <p class="text">
                                ProTeamHub offers the ability to customize the user interface to fit your team's unique needs.
                            </p>
                        </div>
    
                    </div>
                </li>
    
            </ul>
    
            <figure class="features-banner">
                <img src="./assets/images/feautres-banner.png" width="369" height="318" loading="lazy" alt="Features Banner"
                    class="w-100 banner-animation">
            </figure>
    
            <ul class="features-list">
    
                <li>
                    <div class="features-card">
    
                        <div class="icon">
                            <ion-icon name="code-slash-outline"></ion-icon>
                        </div>
    
                        <div class="content">
                            <h3 class="h3 title">Continuous Development</h3>
    
                            <p class="text">
                                ProTeamHub ensures continuous platform improvements to deliver the best user experience.
                            </p>
                        </div>
    
                    </div>
                </li>
    
                <li>
                    <div class="features-card">
    
                        <div class="icon">
                            <ion-icon name="rocket-outline"></ion-icon>
                        </div>
    
                        <div class="content">
                            <h3 class="h3 title">Testing and Launch</h3>
    
                            <p class="text">
                                ProTeamHub offers a thorough testing environment to ensure top-notch performance before any feature launch.
                            </p>
                        </div>
    
                    </div>
                </li>
    
            </ul>
    
        </div>
    </section>
    
    
    <!-- 
        - #BLOG
    -->
    
    <section class="section blog" id="blog">
        <div class="container">
    
            <h2 class="h2 section-title underline">ProTeamHub Blog</h2>
    
            <ul class="blog-list">
    
                <li>
                    <div class="blog-card">
    
                        <figure class="banner">
                            <a href="#">
                                <img src="./assets/images/blog-1.jpg" width="750" height="350" loading="lazy"
                                    alt="Latest Updates on ProTeamHub" class="img-cover">
                            </a>
                        </figure>
    
                        <div class="content">
    
                            <h3 class="h3 title">
                                <a href="#">
                                    Latest News and Updates from ProTeamHub
                                </a>
                            </h3>
    
                            <p class="text">
                                Here we share the latest information on updates and new features added to ProTeamHub.
                            </p>
    
                            <div class="meta">
    
                                <div class="publish-date">
                                    <ion-icon name="time-outline"></ion-icon>
    
                                    <time datetime="2022-03-07">March 7, 2022</time>
                                </div>
    
                                <button class="comment" aria-label="Comment">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
    
                                    <data value="15">15</data>
                                </button>
    
                                <button class="share" aria-label="Share">
                                    <ion-icon name="share-social-outline"></ion-icon>
                                </button>
    
                            </div>
    
                        </div>
    
                    </div>
                </li>
    
                <li>
                    <div class="blog-card">
    
                        <figure class="banner">
                            <a href="#">
                                <img src="./assets/images/blog-2.jpg" width="750" height="350" loading="lazy"
                                    alt="How ProTeamHub Helps Build High-Performance Teams" class="img-cover">
                            </a>
                        </figure>
    
                        <div class="content">
    
                            <h3 class="h3 title">
                                <a href="#">
                                    How ProTeamHub Helps Build High-Performance Teams
                                </a>
                            </h3>
    
                            <p class="text">
                                Discover how ProTeamHub helps companies and groups create high-performing teams.
                            </p>
    
                            <div class="meta">
    
                                <div class="publish-date">
                                    <ion-icon name="time-outline"></ion-icon>
    
                                    <time datetime="2022-03-07">March 7, 2022</time>
                                </div>
    
                                <button class="comment" aria-label="Comment">
                                    <ion-icon name="chatbubble-outline"></ion-icon>
    
                                    <data value="15">15</data>
                                </button>
    
                                <button class="share" aria-label="Share">
                                    <ion-icon name="share-social-outline"></ion-icon>
                                </button>
    
                            </div>
    
                        </div>
    
                    </div>
                </li>
    
            </ul>
    
        </div>
    </section>
    

      

      <!-- CONTACT SECTION -->
      


  <!-- FOOTER -->
  <footer class="footer">

    <div class="footer-top section">
      <div class="container">

        <div class="footer-brand">

          <a href="#" class="logo">Desinic</a>

          <p class="text">
            Maecenas pellentesque placerat quam, in finibus nisl tincidunt sed. Aliquam magna augue, malesuada ut
            feugiat eget,
            cursus eget felis.
          </p>

          <ul class="social-list">

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>

            <li>
              <a href="#" class="social-link">
                <ion-icon name="logo-twitter"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Our links</p>
          </li>

          <li>
            <a href="#" class="footer-link">Home</a>
          </li>

          <li>
            <a href="#" class="footer-link">About Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Services</a>
          </li>

          <li>
            <a href="#" class="footer-link">Team</a>
          </li>

          <li>
            <a href="#" class="footer-link">Blog</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Our Services</p>
          </li>

          <li>
            <a href="#" class="footer-link">Strategy & Research</a>
          </li>

          <li>
            <a href="#" class="footer-link">Web Development</a>
          </li>

          <li>
            <a href="#" class="footer-link">Web Solution</a>
          </li>

          <li>
            <a href="#" class="footer-link">Digital Marketing</a>
          </li>

          <li>
            <a href="#" class="footer-link">App Design</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Other links</p>
          </li>

          <li>
            <a href="#" class="footer-link">FAQ</a>
          </li>

          <li>
            <a href="#" class="footer-link">Portfolio</a>
          </li>

          <li>
            <a href="#" class="footer-link">Privacy Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms & Conditions</a>
          </li>

          <li>
            <a href="#" class="footer-link">Support</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Contact Us</p>
          </li>

          <li class="footer-item">

            <div class="footer-item-icon">
              <ion-icon name="call"></ion-icon>
            </div>

            <div>
              <a href="tel:+2484214313" class="footer-item-link">+201040922321</a>
              <a href="tel:+2486871365" class="footer-item-link">+201069514698</a>
            </div>

          </li>

          <li class="footer-item">

            <div class="footer-item-icon">
              <ion-icon name="mail"></ion-icon>
            </div>

            <div>
              <a href="mailto:proteamhub44@gmail.com" class="footer-item-link">proteamhub44@gmail.com</a>
            </div>

          </li>

          <li class="footer-item">

            <div class="footer-item-icon">
              <ion-icon name="location"></ion-icon>
            </div>

            <address class="footer-item-link">
              Egypt - New Domitta
            </address>

          </li>

        </ul>

      </div>
    </div>
    <footer class="footer">
      <div class="container">
        <p>© 2024 ProTeamHub | All Rights Reserved</p>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="./assets/js/script.js"></script>
    <script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="MgsacowUVEfErnjwaOmBS";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>

</html>