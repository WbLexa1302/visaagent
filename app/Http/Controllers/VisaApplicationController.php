<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Product;
use App\Models\VisaType;
use App\Models\Country;
use App\Models\Customer; // Di-import untuk fitur Customer::firstOrCreate
use App\Models\Order;    // Di-import untuk pembuatan data Order Filament
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Di-import untuk keamanan database transaction
use Illuminate\Support\Str; // Ditambahkan untuk generate kode unik tracking
use Illuminate\Support\Facades\Http; // Ditambahkan untuk fetch API Behold
use Illuminate\Support\Facades\Cache; // Ditambahkan untuk caching feed Instagram

class VisaApplicationController extends Controller
{
    /**
     * Helper method untuk mengambil data negara dari database secara berurutan (A-Z)
     */
    private function getCountries()
    {
        return Country::orderBy('name', 'asc')->get();
    }

    /**
     * Menampilkan daftar jenis visa dan negara di halaman utama
     */
    public function index()
    {
        // 1. DATA EXISTING (Eager loading optimal)
        $products = Product::with('category')->get();
        $visaTypes = VisaType::all();
        $countries = Country::orderBy('name', 'asc')->get();

        // Ubah data products menjadi array/JSON terformat untuk di-passing ke JavaScript
        $productsJson = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'duration' => $product->duration ?? '60',
                'visa_type' => $product->visa_type,
                'category_slug' => $product->category->slug ?? ''
            ];
        });

        // 2. LOGIKA BARU: Fetch Instagram dari Behold.so dengan Cache 4 Jam
        $apiUrl = env('BEHOLD_INSTAGRAM_URL', 'https://feeds.behold.so/eNwmrD0OFJUtadyROgep');

        $instagramPosts = Cache::remember('behold_instagram_posts', 60 * 4, function () use ($apiUrl) {
            try {
                $response = Http::get($apiUrl);
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                logger('Instagram Fetch Error: ' . $e->getMessage());
            }
            return [];
        });

        // Ambil info profil (username, biography, followers, dll)
        $igProfile = [
            'username' => $instagramPosts['username'] ?? 'balieasevisa',
            'biography' => $instagramPosts['biography'] ?? '',
            'profilePictureUrl' => $instagramPosts['profilePictureUrl'] ?? null,
            'followersCount' => $instagramPosts['followersCount'] ?? 0,
            'followsCount' => $instagramPosts['followsCount'] ?? 0,
        ];

        // Ambil maksimal 6 postingan teratas
        $posts = isset($instagramPosts['posts']) 
            ? collect($instagramPosts['posts'])->take(6) 
            : collect([]);

        // 3. DATA FAQ UNTUK SCHEMA & KOMPONEN
        // Silakan ubah teks di bawah ini sesuai dengan pertanyaan yang sering diajukan klien Bali Ease
        $faqs = [
            [
                'question' => 'Berapa lama proses pembuatan KITAS di Bali?',
                'answer' => 'Proses pengurusan KITAS standar umumnya memakan waktu sekitar 7-14 hari kerja setelah seluruh dokumen lengkap diserahkan.'
            ],
            [
                'question' => 'Apakah Bali Ease melayani perpanjangan Visa On Arrival (VOA)?',
                'answer' => 'Ya, kami melayani jasa perpanjangan VOA secara cepat, transparan, dan tanpa antre lama bagi warga negara asing di Bali.'
            ],
            [
                'question' => 'Apa keunggulan mengurus legalitas PMA lewat Bali Ease?',
                'answer' => 'Kami menyediakan konsultan hukum imigrasi ahli yang memastikan seluruh legalitas perusahaan penanaman modal asing (PMA) Anda diproses sesuai regulasi terbaru secara aman.'
            ]
        ];

        // 4. PASSING DATA: Menambahkan $faqs ke dalam fungsi compact
        return view('welcome', compact('products', 'visaTypes', 'countries', 'productsJson', 'posts', 'igProfile', 'faqs'));
    }

    /**
     * Menampilkan detail jenis visa
     */
    public function show($id)
    {
        $visa = VisaType::findOrFail($id);
        return view('visa.detail', compact('visa'));
    }

    /**
     * Menampilkan form pendaftaran dengan pilihan negara
     */
    public function create()
    {
        $products = Product::all();
        $visaTypes = VisaType::all();
        $countries = $this->getCountries();

        return view('apply', compact('products', 'visaTypes', 'countries'));
    }

    /**
     * Menyimpan data aplikasi baru dengan GENERATE KODE TRACKING
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Form (Menggunakan 'product_id' sesuai form premium Anda)
        $request->validate([
            'product_id'      => 'required|exists:products,id',
            'process_type'    => 'required|in:regular,express',
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'passport_number' => 'required|string|max:50',
            'country_code'    => 'nullable|string|max:10', // Jika form Anda mengirimkan kode/id negara
        ]);

        // Ambil data produk untuk mendapatkan nominal harga asli
        $product = Product::findOrFail($request->product_id);

        // 2. Gunakan DB Transaction agar proses insert ke 3 tabel aman & sinkron
        DB::beginTransaction();

        try {
            // A. Simpan / Cari data Pelanggan di tabel 'customers'
            $customer = Customer::firstOrCreate(
                ['email' => $request->email],
                [
                    'name' => $request->full_name,
                    // 'passport_number' => strtoupper($request->passport_number) // Buka comment ini jika tabel customer punya kolom paspor
                ]
            );

            // B. Generate KODE TRACKING UNIK (Contoh hasil: BE-2605-XYZ12)
            $bookingCode = 'BE-' . date('ym') . '-' . strtoupper(Str::random(5));

            // C. Masukkan data ke tabel 'orders' agar muncul di panel Filament Admin beserta booking_code
            $order = Order::create([
                'customer_id'     => $customer->id,
                'product_id'      => $product->id,
                'booking_code'    => $bookingCode, // Kolom tracking baru
                'process_type'    => $request->process_type,
                'total_price'     => $product->price,        // Diambil otomatis dari tabel 'products'
                'status'          => 'pending',              // Status awal di Filament
                'passport_number' => strtoupper($request->passport_number),
                'country_code'    => $request->country_code ?? 'ID',
            ]);

            // D. Jalankan backup record ke tabel 'applications'
            Application::create([
                'visa_type_id'    => $request->product_id,   // Menyesuaikan struktur relasi produk/visa Anda
                'process_type'    => $request->process_type,
                'full_name'       => $request->full_name,
                'email'           => $request->email,
                'passport_number' => strtoupper($request->passport_number),
            ]);

            // Jika semua query sukses tanpa error, simpan permanen ke database
            DB::commit();

            // Kembalikan ke halaman dengan pesan sukses + KODE TRACKING-NYA
            return back()->with('success', "Aplikasi Anda berhasil dikirim! KODE TRACKING ANDA: {$bookingCode}. Gunakan kode ini dan nomor paspor untuk cek status.");

        } catch (\Exception $e) {
            // Jika ada satu saja yang gagal, batalkan semua pendaftaran demi keamanan/konsistensi data
            DB::rollback();

            return back()->withErrors(['error' => 'Gagal memproses pendaftaran: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * TAMPILAN HALAMAN LAKUKAN TRACKING
     */
    public function trackForm()
    {
        return view('track'); // Menampilkan form pencarian tracking
    }

    /**
     * PROSES VALIDASI & CARI STATUS VISA
     */
    public function trackStatus(Request $request)
    {
        $request->validate([
            'passport_number' => 'required|string',
            'booking_code'    => 'required|string',
        ]);

        // Cari order yang booking_code DAN passport_number-nya cocok di database
        $order = Order::where('booking_code', strtoupper($request->booking_code))
            ->where('passport_number', strtoupper($request->passport_number))
            ->with(['customer', 'product'])
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Data aplikasi tidak ditemukan. Silakan periksa kembali Nomor Paspor dan Kode Tracking Anda.')->withInput();
        }

        return view('track', compact('order'));
    }
}