<?php
namespace App\Controllers;

class BaseController
{
  // Method to redirect to a different URL
  protected function redirect($url)
  {
      header('Location: ' . $url);
      exit();
  }

}