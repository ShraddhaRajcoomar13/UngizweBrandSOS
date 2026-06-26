<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Ungizwe Listing</title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts & CSS (unchanged) -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="page-404">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Ungizwe?</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#team">Team</a></li>
          <li><a href="#pricing">Pricing</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="#about">Get Started</a>
    </div>
  </header>

  <main class="main">
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Listing</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Main Content Area - Database Display -->
    <section class="error-404 section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="text-center">

          <?php
          // Database Connection
          $servername = "localhost";
          $username   = "root";
          $password   = "";
          $dbname     = "ungizwedb";

          $conn = new mysqli($servername, $username, $password, $dbname);

          if ($conn->connect_error) {
              echo '<div style="color:red; font-size:1.2rem;">Connection failed: ' . $conn->connect_error . '</div>';
          } else {
              $sql = "SELECT brand, topic, score, id FROM brand_topic_scores ORDER BY id DESC LIMIT 1";
              $result = $conn->query($sql);

              if ($result && $result->num_rows > 0) {
                  $row = $result->fetch_assoc();
          ?>
                  <div class="mb-5">
                    <h1 class="display-3 fw-bold text-primary"><?= htmlspecialchars($row['brand']) ?></h1>
                    <h2 class="text-muted"><?= htmlspecialchars($row['topic']) ?></h2>
                    <div class="mt-4">
                      <h3>Score: <span class="badge bg-success fs-1"><?= htmlspecialchars($row['score']) ?></span></h3>
                    </div>
                  </div>

          <?php
              } else {
                  echo '<h2>No records found in the database.</h2>';
              }
              $conn->close();
          }
          ?>

        </div>
      </div>
    </section>
  </main>

  <!-- Footer (kept as is) -->
  <footer id="footer" class="footer">
    <!-- Your existing footer content here -->
    <div class="container copyright text-center mt-4">
      <p>© <strong>Ungizwe</strong> All Rights Reserved</p>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Scripts -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
