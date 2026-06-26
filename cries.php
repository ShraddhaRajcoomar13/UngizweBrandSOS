<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>UngizweForm</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
<body class="blog-details-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">Ungizwe?</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
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
    <div class="page-title" data-aos="fade">
      <div class="container">
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Cry Out</li>
          </ol>
        </nav>
        <h1>Mzanzi Cries for Help</h1>
      </div>
    </div>

    <div class="container">
      <div class="row">

        <!-- Form -->
        <div class="col-lg-8">
          <section id="cry-form" class="blog-comment-form section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
              <form action="submit_cry.php" method="post" role="form">
                <div class="form-header">
                  <h3>Submit a Cry for Help</h3>
                  <p>Share your experience anonymously.</p>
                </div>
                <div class="row gy-3">
                  <div class="col-md-12">
                    <label for="brand">Brand *</label>
                    <input type="text" name="brand" id="brand" class="form-control" placeholder="e.g. Vodacom, Shoprite" required>
                  </div>
                  <div class="col-12">
                    <label for="cry">Your Experience *</label>
                    <textarea name="cry" id="cry" class="form-control" rows="6" placeholder="Describe what happened..." required></textarea>
                  </div>
                  <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Send Cry</button>
                  </div>
                </div>
              </form>
            </div>
          </section>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 sidebar">
          <div class="widgets-container" data-aos="fade-up" data-aos-delay="200">

            <!-- Search Widget -->
            <div class="search-widget widget-item">
              <h3 class="widget-title">Search Brands</h3>
              <form action="" method="GET" id="brand-search-form">
                <div class="input-group">
                  <input type="text" name="q" id="search-input" class="form-control" placeholder="Search brands..." autocomplete="off">
                  <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
              </form>
              <div id="search-results" class="mt-3"></div>
            </div>

            <!-- Recent Brands Widget -->
            <div class="recent-posts-widget widget-item">
              <h3 class="widget-title">Recently Updated Brands</h3>

              <?php
              $recent_brands = [];

              // Try Redis first
              try {
                  $redis = new Redis();
                  if ($redis->connect('127.0.0.1', 6379, 1)) {
                      $redis->select(0);
                      $cached = $redis->get("recent_brands");
                      if ($cached) {
                          $decoded = json_decode($cached, true);
                          if (is_array($decoded) && !empty($decoded)) {
                              $recent_brands = $decoded;
                          }
                      }
                  }
              } catch (Exception $e) {
                  // Redis unavailable - fall through
              }

              // Fallback to MySQL
              if (empty($recent_brands)) {
                  $conn = new mysqli("localhost", "root", "", "ungizwedb");
                  if (!$conn->connect_error) {
                      $sql = "SELECT brand, topic, score, MAX(id) AS last_updated
                              FROM brand_topic_scores
                              GROUP BY brand, topic
                              ORDER BY last_updated DESC
                              LIMIT 5";
                      $result = $conn->query($sql);
                      if ($result && $result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              $recent_brands[] = $row;
                          }
                      }
                      $conn->close();
                  }
              }

              // Render
              if (!empty($recent_brands)) {
                  foreach ($recent_brands as $item) {
                      echo '<div class="post-item mb-3">';
                      echo '<div>';
                      echo '<h4><a href="#">' . htmlspecialchars($item['brand'] ?? '') . '</a></h4>';
                      echo '<p class="mb-1 text-muted">' . htmlspecialchars($item['topic'] ?? '') . '</p>';
                      echo '<span class="badge bg-success">Score: ' . htmlspecialchars($item['score'] ?? '') . '</span>';
                      echo '</div></div>';
                  }
              } else {
                  echo '<p>No recent brands found yet.</p>';
              }
              ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>

  <footer id="footer" class="footer">
    <div class="container copyright text-center mt-4">
      <p>© <strong>Ungizwe</strong> All Rights Reserved</p>
    </div>
  </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>

</body>
</html>
