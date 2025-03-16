<?php
namespace App\Controllers;

class LegalPagesController extends BaseController
{
  public function privacy_policy()
  {    
      // Prepare data for the home page
      $data = [
          // CSS file URL
          'page_css_url' => '/assets/css/privacy-policy.css',
          // JS file URL
          'page_js_url' => '/assets/js/contact/privacy-policy.js',
          // Header title for the page
          'header_title' => 'Williams Coaching Privacy Policy Agreement',
      ];

      // Render the template and pass data
      renderTemplate('privacy-policy.php', $data);
  }

  public function terms_of_use()
  {    
      // Prepare data for the home page
      $data = [
          // CSS file URL
          'page_css_url' => '/assets/css/terms-of-use.css',
          // JS file URL
          'page_js_url' => '/assets/js/contact/terms-of-use.js',
          // Header title for the page
          'header_title' => 'Williams Coaching Terms Of Use Agreement',
      ];

      // Render the template and pass data
      renderTemplate('terms-of-use.php', $data);
  }
}