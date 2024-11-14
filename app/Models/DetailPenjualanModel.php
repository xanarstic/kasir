<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenjualanModel extends Model
{
    protected $table = 'detailpenjualan';
    protected $primaryKey = 'DetailID';
    protected $allowedFields = ['PenjualanID', 'ProdukID', 'JumlahProduk', 'Subtotal'];
}
