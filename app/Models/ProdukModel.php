<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'ProdukID';
    protected $allowedFields = ['NamaProduk', 'Harga', 'Stok'];
}
