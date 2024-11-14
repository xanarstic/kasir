<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'penjualan';
    protected $primaryKey = 'PenjualanID';
    protected $allowedFields = ['TanggalPenjualan', 'PelangganID'];
    protected $useTimestamps = false;
}
