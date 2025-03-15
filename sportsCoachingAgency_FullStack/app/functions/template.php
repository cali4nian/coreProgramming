<?php
function renderTemplate($template, $data = [])
{
    // Make sure that the template exists
    $file = __DIR__ . '/../../templates/' . $template;
    if (!file_exists($file)) {
        die("Template file not found: $template");
    }

    // Extract data variables into the current scope
    extract($data);

    // Include the template file
    include $file;
}
