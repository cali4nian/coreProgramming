<?php
namespace App\Models;

use PDO;
use App\Config\Database;

class SettingModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllSettings(): array
    {
        $stmt = $this->db->query("SELECT key_name, value FROM settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function updateSetting($key, $value)
    {
        $stmt = $this->db->prepare("INSERT INTO settings (key_name, value) VALUES (:key_name, :value)
                              ON DUPLICATE KEY UPDATE value = :value");
        $stmt->execute(['key_name' => $key, 'value' => $value]);
    }

    public function handleFileUpload($key, $file)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public_html/uploads/';
            $fileName = basename($file['name']);
            $filePath = $uploadDir . $fileName;
            // delete old file if exists
            $oldFilePath = __DIR__ . '/../../public_html' . $this->getAllSettings()[$key];
            if (file_exists($oldFilePath)) unlink($oldFilePath);
            if (move_uploaded_file($file['tmp_name'], $filePath)) $this->updateSetting($key, '/uploads/' . $fileName);
        }
    }

    
}