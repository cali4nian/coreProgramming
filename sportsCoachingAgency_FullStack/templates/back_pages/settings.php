<?php include 'header.php'; ?>

<!-- Site Name and Customer Service Email Address -->
<section class="settings-form-container">
  <form action="/admin/update-site-settings" method="POST" enctype="multipart/form-data">
      <div class="form-group">
          <label for="site_name">Site Name:</label>
          <input type="text" id="site_name" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" placeholder="Enter site name" required>
      </div>

      <div class="form-group">
          <label for="customer_service_email">Customer Service Email Address:</label>
          <input type="email" id="customer_service_email" name="customer_service_email" value="<?= htmlspecialchars($settings['customer_service_email'] ?? '') ?>" placeholder="Enter customer service email" required>
      </div>

      <button type="submit" class="btn">Save Settings</button>
  </form>
</section>
<!-- END Site Name and Customer Service Email Address -->

<!-- Social Media URLs -->
<section class="settings-form-container">
  <form action="/admin/update-social-media-settings" method="POST">
      <h2>Social Media URLs</h2>
      <div class="form-group">
          <label for="facebook_url">Facebook URL:</label>
          <input type="url" id="facebook_url" name="facebook_url" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>" placeholder="Enter Facebook URL">
      </div>

      <div class="form-group">
          <label for="twitter_url">Twitter URL:</label>
          <input type="url" id="twitter_url" name="twitter_url" value="<?= htmlspecialchars($settings['twitter_url'] ?? '') ?>" placeholder="Enter Twitter URL">
      </div>

      <div class="form-group">
          <label for="instagram_url">Instagram URL:</label>
          <input type="url" id="instagram_url" name="instagram_url" value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>" placeholder="Enter Instagram URL">
      </div>

      <div class="form-group">
          <label for="linkedin_url">LinkedIn URL:</label>
          <input type="url" id="linkedin_url" name="linkedin_url" value="<?= htmlspecialchars($settings['linkedin_url'] ?? '') ?>" placeholder="Enter LinkedIn URL">
      </div>

      <div class="form-group">
          <label for="tiktok_url">TikTok URL:</label>
          <input type="url" id="tiktok_url" name="tiktok_url" value="<?= htmlspecialchars($settings['tiktok_url'] ?? '') ?>" placeholder="Enter TikTok URL">
      </div>

      <div class="form-group">
          <label for="youtube_url">YouTube URL:</label>
          <input type="url" id="youtube_url" name="youtube_url" value="<?= htmlspecialchars($settings['youtube_url'] ?? '') ?>" placeholder="Enter YouTube URL">
      </div>

      <div class="form-group">
          <label for="snapchat_url">Snapchat URL:</label>
          <input type="url" id="snapchat_url" name="snapchat_url" value="<?= htmlspecialchars($settings['snapchat_url'] ?? '') ?>" placeholder="Enter Snapchat URL">
      </div>

      <button type="submit" class="btn">Save Social Media URLs</button>
  </form>
</section>
<!-- END Social Media URLs -->

<!-- Home Page Settings -->
<section class="settings-form-container">
  <form action="/admin/update-home-page-settings" method="POST" enctype="multipart/form-data">
      <h2>Home Page Settings</h2>

      <div class="form-group">
          <label for="call_now_phone">Call Now Phone Number:</label>
          <input type="tel" id="call_now_phone" name="call_now_phone" value="<?= htmlspecialchars($settings['call_now_phone'] ?? '') ?>" placeholder="Enter phone number" required>
      </div>

      <div class="form-group">
          <label for="background_image">Background Image:</label>
          <input type="file" id="background_image" name="background_image" accept="image/*">
          <?php if (!empty($settings['background_image'])): ?>
              <p>Current: <a href="<?= htmlspecialchars($settings['background_image']) ?>" target="_blank">View Image</a></p>
          <?php endif; ?>
      </div>

      <div class="form-group">
          <label for="hero_image">Hero Image:</label>
          <input type="file" id="hero_image" name="hero_image" accept="image/*">
          <?php if (!empty($settings['hero_image'])): ?>
              <p>Current: <a href="<?= htmlspecialchars($settings['hero_image']) ?>" target="_blank">View Image</a></p>
          <?php endif; ?>
      </div>

      <div class="form-group">
          <label for="head_coach_image">Head Coach Image:</label>
          <input type="file" id="head_coach_image" name="head_coach_image" accept="image/*">
          <?php if (!empty($settings['head_coach_image'])): ?>
              <p>Current: <a href="<?= htmlspecialchars($settings['head_coach_image']) ?>" target="_blank">View Image</a></p>
          <?php endif; ?>
      </div>

      <div class="form-group">
          <label for="where_to_start_video">Where to Start YouTube Video URL:</label>
          <input type="url" id="where_to_start_video" name="where_to_start_video" value="<?= htmlspecialchars($settings['where_to_start_video'] ?? '') ?>" placeholder="Enter YouTube video URL">
      </div>

      <div class="form-group">
          <label for="main_youtube_video">Main YouTube Section Video URL:</label>
          <input type="url" id="main_youtube_video" name="main_youtube_video" value="<?= htmlspecialchars($settings['main_youtube_video'] ?? '') ?>" placeholder="Enter YouTube video URL">
      </div>

      <div class="form-group">
          <label for="main_instagram_photo">Main Instagram Photo:</label>
          <input type="file" id="main_instagram_photo" name="main_instagram_photo" accept="image/*">
          <?php if (!empty($settings['main_instagram_photo'])): ?>
              <p>Current: <a href="<?= htmlspecialchars($settings['main_instagram_photo']) ?>" target="_blank">View Image</a></p>
          <?php endif; ?>
      </div>

      <div class="form-group">
          <label for="main_facebook_photo">Main Facebook Photo:</label>
          <input type="file" id="main_facebook_photo" name="main_facebook_photo" accept="image/*">
          <?php if (!empty($settings['main_facebook_photo'])): ?>
              <p>Current: <a href="<?= htmlspecialchars($settings['main_facebook_photo']) ?>" target="_blank">View Image</a></p>
          <?php endif; ?>
      </div>

      <button type="submit" class="btn">Save Home Page Settings</button>
  </form>
</section>
<!-- END Home Page Settings -->

<!-- About Page Settings -->
<section class="settings-form-container">
  <form action="/admin/update-about-page-settings" method="POST" enctype="multipart/form-data">
      <h2>About Page Settings</h2>

      <div class="form-group">
          <label for="about_page_image">About Page Image:</label>
          <input type="file" id="about_page_image" name="about_page_image" accept="image/*">
          <?php if (!empty($settings['about_page_image'])): ?>
              <p>Current: <a href="<?= htmlspecialchars($settings['about_page_image']) ?>" target="_blank">View Image</a></p>
          <?php endif; ?>
      </div>

      <!-- paragraph one -->
        <div class="form-group">
            <label for="about_page_text_one">Paragraph One:</label>
            <textarea id="about_page_text_one" name="about_page_text_one" rows="5" maxlength="255" placeholder="Enter about page text for paragraph one"><?= htmlspecialchars($settings['about_page_text_one'] ?? '') ?></textarea>
            <p>Max 255 characters</p>
        </div>

        <!-- paragraph two -->
        <div class="form-group">
            <label for="about_page_text_two">Paragraph Two:</label>
            <textarea id="about_page_text_two" name="about_page_text_two" rows="5" placeholder="Enter about page text for paragraph two"><?= htmlspecialchars($settings['about_page_text_two'] ?? '') ?></textarea>
            <p>Max 255 characters</p>
        </div>

        <!-- paragraph three -->
        <div class="form-group">
            <label for="about_page_text_three">Paragraph Three:</label>
            <textarea id="about_page_text_three" name="about_page_text_three" rows="5" placeholder="Enter about page text for paragraph three"><?= htmlspecialchars($settings['about_page_text_three'] ?? '') ?></textarea>
            <p>Max 255 characters</p>
        </div>

      <button type="submit" class="btn">Save About Page Settings</button>
  </form>
</section>
<!-- END About Page Settings -->

<?php include 'footer.php'; ?>