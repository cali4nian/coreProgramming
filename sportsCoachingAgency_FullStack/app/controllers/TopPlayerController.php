<?php

namespace App\Controllers;

require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/email.php';

use App\Models\TopPlayerModel;

class TopPlayerController extends BaseController
{
  private TopPlayerModel $topPlayerModel;

  // Constructor to initialize the TopPlayerModel
  public function __construct()
  {
    $this->topPlayerModel = new TopPlayerModel();
  }

  // Method to display the top players page
  public function index()
  {

    // Check if the user is logged in and session is started
    $this->isSessionOrStart();
    $this->isNotLoggedIn();
    isAdminOrSuper();

    // Generate CSRF token
    $csrfToken = $this->generateOrValidateCsrfToken();
    
    $data = [
        'csrf_token' => $csrfToken,
        'players' => $this->topPlayerModel->getAllTopPlayers() ?? [],
        'header_title' => 'Top Players',
        'page_css_url' => '/assets/css/top-players.css',
        'page_js_url' => '/assets/js/backend/top_players/top_players.js',
        'pageName' => 'Top Players Management',
        'pageDescription' => 'Manage the top players on your website.',
    ];

    renderTemplate('back_pages/top_players.php', $data);
  
  }

  // Method to create a new player
  public function create()
  {
    // Check if the user is logged in and session is started
    $this->isSessionOrStart();
    $this->isNotLoggedIn();
    isAdminOrSuper();

    // Validate CSRF token
    $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/top-players?error=invalid_request', true);

    // Initialize an empty array for errors and to retain form data
    $errors = [];
    $formData = [];

    // Check if the form is submitted via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Gather form data
        $formData['first_name'] = $this->sanitizeString($_POST['first_name']) ?? '';
        $formData['last_name'] = $this->sanitizeString($_POST['last_name']) ?? '';
        $formData['position'] = $this->sanitizeString($_POST['position']) ?? '';
        $formData['team'] = $this->sanitizeString($_POST['team']) ?? '';
        $formData['height_ft'] = $this->sanitizeInteger($_POST['height_ft']) ?? '';
        $formData['height_in'] = $this->sanitizeInteger($_POST['height_in']) ?? '';
        $formData['weight_lbs'] = $this->sanitizeFloat($_POST['weight_lbs']) ?? '';
        $formData['points_per_game'] = $this->sanitizeFloat($_POST['points_per_game']) ?? '';
        $formData['assists_per_game'] = $this->sanitizeFloat($_POST['assists_per_game']) ?? '';
        $formData['rebounds_per_game'] = $this->sanitizeFloat($_POST['rebounds_per_game']) ?? '';
        $formData['field_goal_percentage'] = $this->sanitizeFloat($_POST['field_goal_percentage']) ?? '';
        $formData['three_point_percentage'] = $this->sanitizeFloat($_POST['three_point_percentage']) ?? '';

        // Validate each field
        foreach ($formData as $field => $value) {
            if (empty($value)) {
                $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
            }
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Check file type (image validation)
            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array($_FILES['image']['type'], $allowedTypes)) $errors['image'] = 'Only JPG and PNG images are allowed.';

            // Check file size (max 2MB)
            if ($_FILES['image']['size'] > 2 * 1024 * 1024) $errors['image'] = 'Image size should be less than 2MB.';

            // Move the uploaded file if no errors
            if (empty($errors)) {
                $uploadDir = __DIR__ . '/../../public_html/uploads/players/';
                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;

                // Create the directory if not exists
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) $formData['image_url'] = '/uploads/players/' . $fileName;else $errors['image'] = 'Failed to upload the image.';
            }
        } else {
            $errors['image'] = 'Player image is required.';
        }

        // If there are no errors, insert data into the database
        if (empty($errors)) {
            // Prepare data for insertion
            $this->topPlayerModel->addTopPlayer([
                'first_name' => $formData['first_name'],
                'last_name' => $formData['last_name'],
                'position' => $formData['position'],
                'team' => $formData['team'],
                'height_ft' => $formData['height_ft'],
                'height_in' => $formData['height_in'],
                'weight_lbs' => $formData['weight_lbs'],
                'points_per_game' => $formData['points_per_game'],
                'assists_per_game' => $formData['assists_per_game'],
                'rebounds_per_game' => $formData['rebounds_per_game'],
                'field_goal_percentage' => $formData['field_goal_percentage'],
                'three_point_percentage' => $formData['three_point_percentage'],
                'image_url' => $formData['image_url']
            ]);

            // Redirect to the player listing page after successful creation
            $this->redirect('/admin/top-players');
        }
      }

      // Render the template with errors and form data
      $data = [
        'players' => $this->topPlayerModel->getAllTopPlayers() ?? [],
        'errors' => $errors,
        'formData' => $formData,
        'header_title' => 'Add Top Player',
        'page_css_url' => '/assets/css/top-players.css',
        'page_js_url' => '/assets/js/backend/top_players/top_players.js',
        'pageName' => 'Add Top Player',
        'pageDescription' => 'Add a new top player to the database.',
      ];
      renderTemplate('back_pages/top_players.php', $data);

  }

  // Method to show the edit form for a player
  public function edit() {
    // Check if the user is logged in and session is started
    $this->isSessionOrStart();
    $this->isNotLoggedIn();
    isAdminOrSuper();
    
    // Validate CSRF token
    $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/top-players?error=invalid_request', true);

    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the player ID from the POST data
        $playerId = $_POST['id'] ?? null;

        // Validate the player ID
        if ($playerId) {
            // Fetch player data from the model
            $player = $this->topPlayerModel->getTopPlayerById($playerId);

            // Check if player exists
            if ($player) {
                // Render the edit form with player data
                $data = [
                    'player' => $player,
                    'header_title' => 'Edit Top Player',
                    'page_css_url' => '/assets/css/top-players.css',
                    'page_js_url' => '/assets/js/backend/top_players/top_players.js',
                    'pageName' => 'Edit Top Player',
                    'pageDescription' => 'Edit the details of a top player.',
                ];

                // Set session variable to retain player ID for redirect on form submission
                $_SESSION['edit_top_player_id'] = $playerId;

                renderTemplate('back_pages/edit_top_player.php', $data);
            } else {
                // Handle error: Player not found
                $this->redirect('/admin/top-players?error=player_not_found');
            }
        } else {
            // Handle error: Player ID is missing
            $this->redirect('/admin/top-players?error=missing_id');
        }
    } else {
        // Handle error: Invalid request method
        $this->redirect('/admin/top-players?error=invalid_request');
    }

  }

  // Method to update a player
  public function update() {
    // Check if the user is logged in and session is started
    $this->isSessionOrStart();
    $this->isNotLoggedIn();
    isAdminOrSuper();

    // Validate CSRF token
    $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/top-players?error=invalid_request', true);

    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the player ID from the POST data
        $playerId = $_SESSION['edit_top_player_id'] ?? null;

        // Validate the player ID
        if ($playerId) {
            // Gather form data
            $formData = [
                'first_name' => $this->sanitizeString($_POST['first_name']) ?? '',
                'last_name' => $this->sanitizeString($_POST['last_name']) ?? '',
                'position' => $this->sanitizeString($_POST['position']) ?? '',
                'team' => $this->sanitizeString($_POST['team']) ?? '',
                'height_ft' => $this->sanitizeInteger($_POST['height_ft']) ?? '',
                'height_in' => $this->sanitizeInteger($_POST['height_in']) ?? '',
                'weight_lbs' => $this->sanitizeFloat($_POST['weight_lbs']) ?? '',
                'points_per_game' => $this->sanitizeFloat($_POST['points_per_game']) ?? '',
                'assists_per_game' => $this->sanitizeFloat($_POST['assists_per_game']) ?? '',
                'rebounds_per_game' => $this->sanitizeFloat($_POST['rebounds_per_game']) ?? '',
                'field_goal_percentage' => $this->sanitizeFloat($_POST['field_goal_percentage']) ?? '',
                'three_point_percentage' => $this->sanitizeFloat($_POST['three_point_percentage']) ?? ''
            ];

            // Validate each field
            foreach ($formData as $field => $value) {
                if (empty($value)) $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
            }

            // Handle image upload if provided
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Check file type (image validation)
                $allowedTypes = ['image/jpeg', 'image/png'];
                if (!in_array($_FILES['image']['type'], $allowedTypes)) $errors['image'] = 'Only JPG and PNG images are allowed.';

                // Check file size (max 2MB)
                if ($_FILES['image']['size'] > 2 * 1024 * 1024) $errors['image'] = 'Image size should be less than 2MB.';

                // Move the uploaded file if no errors
                if (empty($errors)) {
                    $uploadDir = __DIR__ . '/../../public_html/uploads/players/';
                    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . $fileName;
                    // Move the new image file
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                }
            }
        }
    }
    // If there are no errors, update data in the database
    if (empty($errors)) {
        // Prepare data for update
        $updateData = [
            'first_name' => $formData['first_name'],
            'last_name' => $formData['last_name'],
            'position' => $formData['position'],
            'team' => $formData['team'],
            'height_ft' => $formData['height_ft'],
            'height_in' => $formData['height_in'],
            'weight_lbs' => $formData['weight_lbs'],
            'points_per_game' => $formData['points_per_game'],
            'assists_per_game' => $formData['assists_per_game'],
            'rebounds_per_game' => $formData['rebounds_per_game'],
            'field_goal_percentage' => $formData['field_goal_percentage'],
            'three_point_percentage' => $formData['three_point_percentage']
        ];

        // If a new image is uploaded, add it to the update data
        if (isset($targetFile)) {
            // Check if the old image file exists and delete it
            $player = $this->topPlayerModel->getTopPlayerById($playerId);
            if ($player && !empty($player['image_url']) && file_exists(__DIR__ . '/../../public_html' . $player['image_url'])) {
                unlink(__DIR__ . '/../../public_html' . $player['image_url']); // Delete the old image file
            }

            $updateData['image_url'] = '/uploads/players/' . $fileName;
        }

        // Call the model method to update the player
        $this->topPlayerModel->updateTopPlayer($playerId, $updateData);

        // Destroy the session variable for player ID
        unset($_SESSION['edit_top_player_id']);

        // Redirect to the player listing page after successful update
        $this->redirect('/admin/top-players?success=top_player_updated&player_name=' . urlencode($formData['first_name'] . ' ' . $formData['last_name']));
    } else {
        // Handle error: Validation errors exist
        renderTemplate('back_pages/edit_top_player.php', ['errors' => $errors, 'formData' => $_POST]);
    }  
  }

  // Method to delete a player
  public function delete() {
    // Check if the user is logged in and session is started
    $this->isSessionOrStart();
    $this->isNotLoggedIn();
    isAdminOrSuper();

    // Validate CSRF token
    $this->generateOrValidateCsrfToken($_POST['csrf_token'], '/admin/top-players?error=invalid_request', true);

    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the player ID from the POST data
        $playerId = $_POST['id'] ?? null;

        // Validate the player ID
        if ($playerId) {
            // Check if image file exists and delete it
            $player = $this->topPlayerModel->getTopPlayerById($playerId);
            if ($player && !empty($player['image_url']) && file_exists(__DIR__ . '/../../public_html' . $player['image_url'])) {
                $imagePath = __DIR__ . '/../../public_html' . $player['image_url'];
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the image file
                }
            }

            // Call the model method to delete the player
            $this->topPlayerModel->deleteTopPlayer($playerId);

            // Redirect to the player listing page after successful deletion
            $this->redirect('/admin/top-players?success=top_player_deleted');

        } else {
            // Handle error: Player ID is missing
            $this->redirect('/admin/top-players?error=missing_id');
        }
    } else {
        // Handle error: Invalid request method
        $this->redirect('/admin/top-players?error=invalid_request');
    }

  }
  
}