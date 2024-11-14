<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PelangganModel;
use App\Models\ProdukModel;
use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;
use App\Models\SettingModel;

class Home extends BaseController
{
	public function index()
	{
		echo view('welcome_message');
	}

	public function login()
	{
		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();
		echo view('header', $data);
		echo view('login', $data);
	}

	public function aksi_login()
	{
		$session = session();
		$userModel = new UserModel();

		$username = $this->request->getVar('username');
		$password = md5($this->request->getVar('password')); // Enkripsi MD5

		// Ambil data user berdasarkan username
		$user = $userModel->where('username', $username)->first();

		// Cek apakah user ditemukan dan password cocok
		if ($user && $user['password'] === $password) {
			// Set session data
			$sessionData = [
				'id_user' => $user['id_user'],
				'username' => $user['username'],
				'nama' => $user['nama'],
				'level' => $user['level'],
				'isLoggedIn' => true
			];
			$session->set($sessionData);

			// Redirect ke halaman dashboard
			return redirect()->to('/home/dashboard');
		} else {
			// Jika login gagal, kembali ke halaman login dengan pesan error
			$session->setFlashdata('error', 'Username atau password salah');
			return redirect()->to('/home/login');
		}
	}

	public function logout()
	{
		session()->destroy();
		return redirect()->to('/home/login');
	}

	public function dashboard()
	{
		// Pastikan user sudah login
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}

		$produkModel = new \App\Models\ProdukModel();
		$penjualanModel = new \App\Models\PenjualanModel();
		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		$this->logActivity('Accessed Dashboard View');

		// Hitung total produk
		$totalProduk = $produkModel->countAll();

		// Hitung total penjualan
		$totalPenjualan = $penjualanModel->countAll();

		echo view('header', $data);
		echo view('menu', $data);
		echo view('dashboard', [
			'totalProduk' => $totalProduk,
			'totalPenjualan' => $totalPenjualan,
		]);
		echo view('footer');
	}

	// Fungsi lainnya
	public function pelanggan()
	{
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}

		$model = new PelangganModel();
		$data['pelanggan'] = $model->findAll();
		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		$this->logActivity('Accessed Pelanggan View');

		echo view('header', $data);
		echo view('menu', $data);
		echo view('pelanggan', $data);
		echo view('footer');
	}

	public function tambahp()
	{
		$model = new PelangganModel();

		$this->logActivity('Added Pelanggan');
		$data = [
			'NamaPelanggan' => $this->request->getPost('NamaPelanggan'),
			'Alamat' => $this->request->getPost('Alamat'),
			'NomorTelepon' => $this->request->getPost('NomorTelepon')
		];
		$model->save($data);
		return redirect()->to('home/pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan.');
	}

	public function editp($id)
	{
		$model = new PelangganModel();

		$this->logActivity('Edited Pelanggan');

		// Jika form di-submit
		if ($this->request->getMethod() == 'post') {
			$data = [
				'NamaPelanggan' => $this->request->getPost('NamaPelanggan'),
				'Alamat' => $this->request->getPost('Alamat'),
				'NomorTelepon' => $this->request->getPost('NomorTelepon')
			];
			$model->update($id, $data);
			return redirect()->to('home/pelanggan')->with('success', 'Data pelanggan berhasil diupdate.');
		}

	}

	public function deletep($id)
	{
		$model = new PelangganModel();
		$model->delete($id);

		$this->logActivity('Deleted Pelanggan');

		return redirect()->to('home/pelanggan')->with('success', 'Data pelanggan berhasil dihapus.');
	}

	public function produk()
	{
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}

		$model = new ProdukModel();
		$data['produk'] = $model->findAll();
		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		$this->logActivity('Accessed Produk View');

		echo view('header', $data);
		echo view('menu', $data);
		echo view('produk', $data);
		echo view('footer');
	}
	// Menambah produk baru
	public function tambahProduk()
	{
		$model = new ProdukModel();

		$this->logActivity('Added Produk');
		$data = [
			'NamaProduk' => $this->request->getPost('NamaProduk'),
			'Harga' => $this->request->getPost('Harga'),
			'Stok' => $this->request->getPost('Stok')
		];

		$model->save($data);
		return redirect()->to('home/produk')->with('success', 'Data produk berhasil ditambahkan.');
	}

	// Mengedit produk berdasarkan ID
	public function editProduk($id)
	{
		$model = new ProdukModel();

		$this->logActivity('Edited Produk');

		// Jika form di-submit
		if ($this->request->getMethod() === 'post') {
			$data = [
				'NamaProduk' => $this->request->getPost('NamaProduk'),
				'Harga' => $this->request->getPost('Harga'),
				'Stok' => $this->request->getPost('Stok')
			];

			$model->update($id, $data);
			return redirect()->to('home/produk')->with('success', 'Data produk berhasil diupdate.');
		}
	}

	// Menghapus produk berdasarkan ID
	public function deleteProduk($id)
	{
		$model = new ProdukModel();
		$model->delete($id);

		$this->logActivity('Deleted Produk');

		return redirect()->to('home/produk')->with('success', 'Data produk berhasil dihapus.');
	}

	public function penjualan()
	{
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}

		$penjualanModel = new PenjualanModel();
		$pelangganModel = new PelangganModel();
		$detailPenjualanModel = new DetailPenjualanModel();
		$produkModel = new ProdukModel(); // Add this line
		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		$this->logActivity('Accessed Penjualan View');

		$penjualan = $penjualanModel->findAll();
		$pelangganData = [];
		foreach ($penjualan as $p) {
			$pelangganData[$p['PelangganID']] = $pelangganModel->find($p['PelangganID']);
		}

		$produk = $produkModel->findAll(); // Retrieve all products

		echo view('header', $data);
		echo view('menu', $data);
		echo view('penjualan', [
			'penjualan' => $penjualan,
			'pelangganData' => $pelangganData,
			'detailPenjualanModel' => $detailPenjualanModel,
			'produk' => $produk // Pass the products to the view
		]);
		echo view('footer');
	}

	public function tambahpenjualan()
	{
		$penjualanModel = new \App\Models\PenjualanModel();
		$detailPenjualanModel = new \App\Models\DetailPenjualanModel();
		$produkModel = new \App\Models\ProdukModel();
		$pelangganModel = new \App\Models\PelangganModel(); // Tambahkan ini

		// Ambil input form
		$namaPelanggan = $this->request->getPost('NamaPelanggan'); // Nama pelanggan input bebas
		$produkID = $this->request->getPost('ProdukID');
		$jumlahProduk = $this->request->getPost('JumlahProduk');

		// Cari pelanggan berdasarkan nama
		$pelanggan = $pelangganModel->where('NamaPelanggan', $namaPelanggan)->first();

		$this->logActivity('Added Penjualan');

		if (!$pelanggan) {
			// Buat pelanggan baru jika belum ada
			$pelangganModel->save(['NamaPelanggan' => $namaPelanggan]);
			$pelangganID = $pelangganModel->insertID();
		} else {
			// Gunakan ID pelanggan yang sudah ada
			$pelangganID = $pelanggan['PelangganID'];
		}

		// Hitung total harga
		$produk = $produkModel->find($produkID);
		if (!$produk) {
			return redirect()->back()->with('error', 'Produk tidak ditemukan.');
		}

		$subtotal = $produk['Harga'] * $jumlahProduk;
		$totalHarga = $subtotal;

		// Simpan data penjualan
		$penjualanModel->save([
			'PelangganID' => $pelangganID,
			'TanggalPenjualan' => date('Y-m-d'),
			'TotalHarga' => $totalHarga,
		]);

		// Simpan data detail penjualan
		$penjualanID = $penjualanModel->insertID();
		$detailPenjualanModel->save([
			'PenjualanID' => $penjualanID,
			'ProdukID' => $produkID,
			'JumlahProduk' => $jumlahProduk,
			'Subtotal' => $subtotal,
		]);

		return redirect()->back()->with('success', 'Penjualan berhasil ditambahkan.');
	}
	public function editpenjualan($id)
	{
		$model = new PenjualanModel();

		$this->logActivity('Edited Penjualan');

		if ($this->request->getMethod() == 'post') {
			$data = [
				'TanggalPenjualan' => $this->request->getPost('TanggalPenjualan'),
				'TotalHarga' => $this->request->getPost('TotalHarga'),
				'PelangganID' => $this->request->getPost('PelangganID'),
			];

			if ($model->update($id, $data)) {
				return redirect()->to('home/penjualan')->with('success', 'Data penjualan berhasil diupdate.');
			} else {
				return redirect()->to('home/penjualan')->with('error', 'Gagal mengupdate data penjualan.');
			}
		}
	}

	// Fungsi untuk menghapus data penjualan
	public function deletepenjualan($id)
	{
		$model = new PenjualanModel();

		$this->logActivity('Deleted Penjualan');

		if ($model->delete($id)) {
			return redirect()->to('home/penjualan')->with('success', 'Data penjualan berhasil dihapus.');
		} else {
			return redirect()->to('home/penjualan')->with('error', 'Gagal menghapus data penjualan.');
		}
	}
	public function getProductPrice($produkID)
	{
		$produkModel = new \App\Models\ProdukModel();
		$produk = $produkModel->find($produkID);

		if ($produk) {
			return $this->response->setJSON(['harga' => $produk['Harga']]);
		} else {
			return $this->response->setJSON(['error' => 'Produk tidak ditemukan'], 404);
		}
	}

	public function getPenjualanDetail($penjualanID)
	{
		$detailPenjualanModel = new DetailPenjualanModel();
		$produkModel = new ProdukModel();

		// Ambil data detail penjualan berdasarkan PenjualanID
		$details = $detailPenjualanModel->where('PenjualanID', $penjualanID)->findAll();

		// Ambil nama produk dan gabungkan dengan detail
		foreach ($details as &$detail) {
			$produk = $produkModel->find($detail['ProdukID']);
			$detail['NamaProduk'] = $produk['NamaProduk'] ?? 'Produk Tidak Ditemukan';
		}

		return $this->response->setJSON(['details' => $details]);
	}

	public function user()
	{
		// Pastikan user sudah login
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}
		if (session()->get('level') !== 'admin') {
			return redirect()->to('home/dashboard')->with('error', 'Access denied');
		}

		$userModel = new UserModel();
		$data['users'] = $userModel->findAll();
		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		$this->logActivity('Accessed User View');

		echo view('header', $data);
		echo view('menu', $data);
		echo view('user', $data);
		echo view('footer');
	}

	public function tambahuser()
	{
		$userModel = new UserModel();

		$data = [
			'nama' => $this->request->getPost('nama'),
			'username' => $this->request->getPost('username'),
			'password' => md5($this->request->getPost('password')), // Hash dengan MD5
			'level' => $this->request->getPost('level'),
		];

		$this->logActivity('Added User');

		$userModel->insert($data);
		session()->setFlashdata('success', 'User berhasil ditambahkan.');
		return redirect()->to(base_url('home/user'));
	}

	public function edituser($id)
	{
		$userModel = new UserModel();

		$data = [
			'nama' => $this->request->getPost('nama'),
			'username' => $this->request->getPost('username'),
			'level' => $this->request->getPost('level'),
		];

		$this->logActivity('Edited User');

		if ($this->request->getPost('password')) {
			$data['password'] = md5($this->request->getPost('password')); // Hash dengan MD5
		}

		$userModel->update($id, $data);
		session()->setFlashdata('success', 'User berhasil diperbarui.');
		return redirect()->to(base_url('home/user'));
	}

	public function deleteuser($id)
	{
		$userModel = new UserModel();

		$this->logActivity('Deleted User');

		$userModel->delete($id);
		session()->setFlashdata('success', 'User berhasil dihapus.');
		return redirect()->to(base_url('home/user'));
	}
	public function logActivity($activity = 'Unspecified Activity', $description = '')
	{
		// Check if the user is logged in
		if (!session()->get('isLoggedIn')) {
			return;
		}

		// Get user ID from session
		$id_user = session()->get('id_user');

		// Load the ActivityLogModel
		$activityLogModel = new \App\Models\ActivityLogModel();

		// Insert the activity log entry
		$activityLogModel->insert([
			'id_user' => $id_user,
			'activity' => $activity,
			'description' => $description,
			'timestamp' => date('Y-m-d H:i:s')
		]);
	}

	public function activity()
	{
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}
		if (session()->get('level') !== 'admin') {
			return redirect()->to('home/dashboard')->with('error', 'Access denied');
		}

		// Load the model
		$activityLogModel = new \App\Models\ActivityLogModel();

		// Get search parameters from the request
		$search = $this->request->getVar('search');
		$userId = $this->request->getVar('id_user');
		$startDate = $this->request->getVar('start_date');
		$endDate = $this->request->getVar('end_date');

		// Set pagination configuration
		$perPage = $this->request->getVar('limit') ?? 10;  // Default to 10 if no limit is set
		$currentPage = $this->request->getVar('page') ?? 1;

		// Build the query with filters
		$query = $activityLogModel->orderBy('timestamp', 'DESC');

		if ($search) {
			$query->like('activity', $search);
		}
		if ($userId) {
			$query->where('id_user', $userId);
		}
		if ($startDate) {
			$query->where('timestamp >=', $startDate . ' 00:00:00');
		}
		if ($endDate) {
			$query->where('timestamp <=', $endDate . ' 23:59:59');
		}

		// Clone the query for pagination counting
		$totalResults = clone $query;

		// Fetch paginated results
		$activity_logs = $query->paginate($perPage, 'default', $currentPage);
		$data['activity_logs'] = $activity_logs;
		$data['pager'] = $query->pager;

		// Pass the search filters back to the view for display
		$data['search'] = $search;
		$data['userId'] = $userId;
		$data['startDate'] = $startDate;
		$data['endDate'] = $endDate;
		$data['limit'] = $perPage;

		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		// Log the view access
		$this->logActivity('Accessed Log Activity View');

		// Load the views with logs
		echo view('header', $data);
		echo view('menu', $data);
		echo view('logactivity', $data);
		echo view('footer');
	}

	public function setting()
	{
		// Pastikan user sudah login
		if (!session()->get('isLoggedIn')) {
			return redirect()->to('/home/login');
		}
		if (session()->get('level') !== 'admin') {
			return redirect()->to('home/dashboard')->with('error', 'Access denied');
		}

		$settingModel = new SettingModel();
		$data['settings'] = $settingModel->getSettings();

		echo view('header', $data);
		echo view('menu', $data);
		echo view('setting', $data);
		echo view('footer');
	}

	public function updatesetting()
	{
		$settingModel = new \App\Models\SettingModel();

		$data = [
			'nama_logo' => $this->request->getPost('nama_logo'),
			'nama_menu' => $this->request->getPost('nama_menu')
		];

		// Handle the logo upload
		$logo = $this->request->getFile('logos');
		if ($logo->isValid() && !$logo->hasMoved()) {
			$logoName = $logo->getRandomName();
			$logo->move(FCPATH . 'public/img', $logoName);
			$data['logos'] = $logoName;
		}

		// Handle the icon upload
		$icon = $this->request->getFile('icon');
		if ($icon->isValid() && !$icon->hasMoved()) {
			$iconName = $icon->getRandomName();
			$icon->move(FCPATH . 'public/img', $iconName);
			$data['icon'] = $iconName;
		}

		$settingModel->updateSettings($data);
		return redirect()->to('home/setting')->with('success', 'Settings updated successfully.');
	}
}
