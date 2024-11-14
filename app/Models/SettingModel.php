<?php

namespace App\Models;
use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id_logo';
    protected $allowedFields = ['nama_logo', 'logos', 'icon', 'nama_menu'];

    public function getSettings()
    {
        return $this->first(); // Assuming single row for simplicity
    }

    public function updateSettings($data)
    {
        return $this->update(1, $data); // Update first row only
    }
}
