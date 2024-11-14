<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'PelangganID';
    protected $allowedFields = ['NamaPelanggan', 'Alamat', 'NomorTelepon'];
}
