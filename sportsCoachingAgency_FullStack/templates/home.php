<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="hero-section" style="background-image: url('<?= htmlspecialchars($settings['hero_image'] ?? '/assets/img/default_hero.jpg') ?>');">
    <aside class="hero-content">
        <h1 class="hero-title"><?= htmlspecialchars($settings['site_name'] ?? 'Welcome to Our Website') ?></h1>
        <p class="hero-subtitle">Discover amazing content and explore the possibilities.</p>
        <a href="tel:<?= htmlspecialchars($settings['call_now_phone'] ?? '559-777-9705') ?>" class="hero-button">Call Now</a>
    </aside>
</section>
<!-- END Hero Section -->

<!-- About Coach Section -->
<section class="about-coach">
    <aside class="content">
        <h2>Meet Coach Williams</h2>
        <p>Dedicated to helping athletes of all ages reach their full potential, our coach brings years of experience, passion, and expertise to every training session.</p>
        <ul class="qualities">
            <li>Motivational</li>
            <li>Experienced</li>
            <li>Passionate</li>
            <li>Supportive</li>
            <li>Encouraging</li>
            <li>Knowledgeable</li>
            <li>Disciplined</li>
            <li>Empowering</li>
        </ul>
        <aside class="image-container">
            <img src="<?= htmlspecialchars($settings['head_coach_image'] ?? '/assets/img/default_head_coach.jpg') ?>" alt="Coach Image" class="coach-image" />
        </aside>
    </aside>
</section>
<!-- END About Coach Section -->

<!-- Player Profiles Section -->
<section class="player-profiles">
    <div class="hero">
        <h1>Meet Our Top Players</h1>
        <p>Explore the stats and achievements of our elite players.</p>
    </div>
    <div class="profiles-container">
        <!-- Example Player Cards -->
        <div class="player-card">
            <img src="/assets/img/default_athlete_image.jpg" alt="Player 1" />
            <h2>John Doe</h2>
            <p>Point Guard | 25 Goals</p>
        </div>
        <div class="player-card">
            <img src="/assets/img/default_athlete_image.jpg" alt="Player 2" />
            <h2>Jane Smith</h2>
            <p>Shooting Guard | 18 Assists</p>
        </div>
    </div>
</section>
<!-- END Player Profiles Section -->

<!-- Subscribe Section -->
<section class="subscribe-section">
    <aside class="subscribe-section-inner-wrapper">
        <h2>Subscribe to Our Newsletter</h2>
        <p>Stay updated with the latest news and updates.</p>
        <form action="/subscribe" method="POST" class="subscribe-form" id="subscriberForm">
            <input type="email" name="email" placeholder="Enter your email" />
            <button type="submit">Subscribe</button>
        </form>
    </aside>
</section>
<!-- END Subscribe Section -->

<!-- Start Here Section -->
<section class="start-here-section">
    <aside class="content">
        <div class="text">
            <h2>Not Sure Where To Start?</h2>
            <p>Watch this intro video to see where you can start your personal sports journey and take the first step towards achieving your goals!</p>
        </div>
        <div class="video-container">
            <iframe width="90%" height="100%" src="<?= htmlspecialchars($settings['where_to_start_video'] ?? 'https://www.youtube.com/embed/oyjYgmsM00Q?si=hAyWSswVvDuyRZrl') ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </aside>
</section>
<!-- End Start Here Section -->

<!-- YouTube Section -->
<section class="youtube-section">
    <div class="content">
        <div class="video-container">
            <iframe width="90%" src="<?= htmlspecialchars($settings['main_youtube_video'] ?? 'https://www.youtube.com/embed/oyjYgmsM00Q?si=hAyWSswVvDuyRZrl') ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="text">
            <h2>Check Out Our YouTube Channel</h2>
            <p>We offer training videos designed for athletes of all ages and skill levels. Whether you're just starting or you're looking to improve your game, we have the resources you need to succeed!</p>
            <a href="<?= htmlspecialchars($settings['youtube_url'] ?? 'https://www.youtube.com') ?>" class="btn" target="_blank">Go to YouTube</a>
        </div>
    </div>
</section>
<!-- End YouTube Section -->

<!-- Instagram Section -->
<section class="instagram-section">
    <div class="content">
        <div class="text">
            <h2>Stay Inspired on Instagram</h2>
            <p>Follow us for exclusive training tips, behind-the-scenes content, and motivational stories to help you elevate your sports journey!</p>
            <a href="<?= htmlspecialchars($settings['instagram_url'] ?? 'https://www.instagram.com') ?>" class="btn" target="_blank">Follow on Instagram</a>
        </div>
        <div class="image-container">
            <img src="<?= htmlspecialchars($settings['main_instagram_photo'] ?? '/assets/img/default_instagram.jpg') ?>" alt="Instagram Sports Highlights" class="instagram-image" />
        </div>
    </div>
</section>
<!-- END Instagram Section -->

<!-- Facebook Section -->
<section class="facebook-section">
    <div class="content">
        <div class="image-container">
            <img src="<?= htmlspecialchars($settings['main_facebook_photo'] ?? '/assets/img/default_facebook.jpg') ?>" alt="Facebook Community" class="facebook-image" />
        </div>
        <div class="text">
            <h2>Join Our Community on Facebook</h2>
            <p>Be part of our growing sports community! Get updates, share your progress, and connect with fellow athletes on Facebook.</p>
            <a href="<?= htmlspecialchars($settings['facebook_url'] ?? 'https://www.facebook.com') ?>" class="btn" target="_blank">Like & Follow on Facebook</a>
        </div>
    </div>
</section>
<!-- END Facebook Section -->

<?php include 'partials/home/confirmation_messages.php'; ?>
<?php include 'footer.php'; ?>