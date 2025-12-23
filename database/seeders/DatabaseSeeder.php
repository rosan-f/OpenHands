<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Donation;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Share;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users (50 users)
        echo "Creating users...\n";
        $users = [];

        // Admin user
        $users[] = User::create([
            'name' => 'Admin OpenHands',
            'email' => 'admin@openhands.com',
            'password' => Hash::make('password'),
            'bio' => 'Administrator OpenHands Platform',
            'avatar' => 'users/user-1.png',
            'location' => 'Jakarta, Indonesia',
            'phone' => '081234567890',
        ]);

      
        $names = [
            'Budi Santoso', 'Siti Nurhaliza', 'Ahmad Rizki', 'Dewi Lestari', 'Rizky Pratama',
            'Putri Ayu', 'Andi Wijaya', 'Maya Sari', 'Doni Hermawan', 'Linda Kusuma',
            'Arif Rahman', 'Rina Wati', 'Eko Prasetyo', 'Fitri Handayani', 'Agus Setiawan',
            'Wulan Dari', 'Rudi Hartono', 'Sari Dewi', 'Bambang Susilo', 'Nadia Putri',
            'Hendro Gunawan', 'Ani Wijayanti', 'Tono Sukirman', 'Yuni Astuti', 'Joko Widodo',
            'Sri Mulyani', 'Dedi Kurniawan', 'Lia Amalia', 'Hadi Purnomo', 'Nina Zatulini',
            'Fajar Ramadhan', 'Tari Anggraini', 'Giri Pratama', 'Indah Permata', 'Hendra Wijaya',
            'Sinta Dewi', 'Bima Sakti', 'Citra Kirana', 'Dimas Anggara', 'Elsa Frozen',
            'Farel Prayoga', 'Gita Gutawa', 'Irfan Hakim', 'Intan Nuraini', 'Joni Iskandar',
            'Kartika Sari', 'Lukman Hakim', 'Mira Lesmana', 'Nugroho Adi'
        ];

        $locations = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang',
            'Makassar', 'Palembang', 'Tangerang', 'Depok', 'Bekasi',
            'Yogyakarta', 'Malang', 'Bogor', 'Batam', 'Pekanbaru'
        ];

        for ($i = 0; $i < 49; $i++) {
            $userNum = ($i % 10) + 1;
            $users[] = User::create([
                'name' => $names[$i],
                'email' => 'user' . ($i + 1) . '@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Pengguna aktif platform OpenHands',
                'avatar' => 'users/user-' . $userNum . '.png',
                'location' => $locations[array_rand($locations)] . ', Indonesia',
                'phone' => '08' . rand(1000000000, 9999999999),
            ]);
        }


        echo "Creating categories...\n";
        $categories = [
            'Kesehatan' => 'Kampanye untuk biaya pengobatan dan kesehatan',
            'Pendidikan' => 'Bantuan pendidikan dan beasiswa',
            'Bencana Alam' => 'Bantuan korban bencana alam',
            'Kemanusiaan' => 'Aksi sosial dan kemanusiaan',
            'Hewan' => 'Penyelamatan dan perawatan hewan',
            'Lingkungan' => 'Pelestarian lingkungan dan alam',
            'Anak Yatim' => 'Bantuan untuk anak yatim',
            'Masjid' => 'Pembangunan dan renovasi masjid',
            'Panti Asuhan' => 'Bantuan untuk panti asuhan',
            'Teknologi' => 'Inovasi dan teknologi sosial',
        ];

        $categoryModels = [];
        foreach ($categories as $name => $description) {
            $categoryModels[] = Category::create(['name' => $name]);
        }


        echo "Creating posts...\n";
        $postTitles = [
            'Bantu Biaya Operasi Ibu Siti',
            'Renovasi Sekolah Dasar Negeri 1',
            'Bantuan Korban Banjir Bandang',
            'Beasiswa Anak Kurang Mampu',
            'Penyelamatan Kucing Jalanan',
            'Pembangunan Taman Kota',
            'Santunan Anak Yatim Piatu',
            'Renovasi Masjid Al-Ikhlas',
            'Bantuan Panti Asuhan Kasih Sayang',
            'Bantu Pengobatan Penderita Kanker',
            'Laptop untuk Siswa Berprestasi',
            'Bantuan Gempa Bumi Cianjur',
            'Pelatihan Keterampilan Pemuda',
            'Sterilisasi Hewan Terlantar',
            'Penanaman 1000 Pohon',
            'Santunan Bulanan Yatim',
            'Pengadaan Al-Quran Masjid',
            'Perlengkapan Sekolah Anak Panti',
            'Operasi Jantung Bayi Andi',
            'Beasiswa S1 Anak Pemulung',
        ];

        $descriptions = [
            'Ibu Siti membutuhkan bantuan untuk biaya operasi tumor. Kondisinya sangat mengkhawatirkan dan memerlukan penanganan segera. Mari kita bantu ibu Siti agar bisa mendapatkan perawatan yang layak.',
            'Sekolah kami membutuhkan renovasi menyeluruh. Atap bocor, cat mengelupas, dan fasilitas sangat memprihatinkan. Dengan bantuan Anda, kami bisa memberikan lingkungan belajar yang lebih baik untuk anak-anak.',
            'Banjir bandang melanda desa kami. Ratusan keluarga kehilangan tempat tinggal dan harta benda. Mereka butuh bantuan segera untuk bertahan hidup. Setiap rupiah sangat berarti.',
            'Banyak anak cerdas yang terpaksa putus sekolah karena keterbatasan ekonomi. Mari kita wujudkan mimpi mereka untuk terus belajar dan meraih masa depan yang lebih baik.',
            'Ratusan kucing jalanan membutuhkan pertolongan. Mereka kelaparan, sakit, dan tidak memiliki tempat berlindung. Mari kita selamatkan mereka dan berikan kehidupan yang lebih baik.',
        ];

        $posts = [];
        for ($i = 0; $i < 100; $i++) {
            $titleIndex = $i % count($postTitles);
            $descIndex = $i % count($descriptions);
            $imageNum = ($i % 10) + 1;
            $targetAmount = rand(5, 100) * 1000000;
            $collectedPercent = rand(0, 90);
            $collectedAmount = ($targetAmount * $collectedPercent) / 100;

            $posts[] = Post::create([
                'user_id' => $users[array_rand($users)]->id,
                'category_id' => $categoryModels[array_rand($categoryModels)]->id,
                'title' => $postTitles[$titleIndex] . ' - ' . ($i + 1),
                'description' => $descriptions[$descIndex] . ' ' . fake()->paragraph(3),
                'image' => 'posts/post-' . $imageNum . '.png',
                'target_amount' => $targetAmount,
                'collected_amount' => $collectedAmount,
                'status' => rand(0, 10) > 1 ? 'active' : 'draft',
                'deadline' => now()->addDays(rand(30, 90)),
                'created_at' => now()->subDays(rand(0, 60)),
            ]);
        }


        echo "Creating donations...\n";
        $paymentMethods = ['bank_transfer', 'e-wallet', 'credit_card', 'qris'];
        $messages = [
            'Semoga lekas sembuh',
            'Semangat! Saya turut berdoa',
            'Semoga segera terkumpul',
            'Aamiin, semoga berkah',
            'Sedikit bantuan dari saya',
            'Ikut membantu',
            'Semoga bermanfaat',
            'Turut berpartisipasi',
            'Mari kita bantu bersama',
            'Semoga Allah memudahkan',
        ];

        for ($i = 0; $i < 500; $i++) {
            $post = $posts[array_rand($posts)];
            $amount = rand(10, 500) * 10000;
            $status = rand(0, 10) > 1 ? 'success' : 'pending';

            Donation::create([
                'post_id' => $post->id,
                'user_id' => $users[array_rand($users)]->id,
                'amount' => $amount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $status,
                'message' => rand(0, 2) ? $messages[array_rand($messages)] : null,
                'paid_at' => $status === 'success' ? now()->subDays(rand(0, 30)) : null,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }


        echo "Creating comments...\n";
        $commentTexts = [
            'Semoga cepat terkumpul dananya',
            'Aamiin, semoga dimudahkan',
            'Turut mendoakan yang terbaik',
            'Semoga Allah memudahkan segala urusan',
            'Ikut berpartisipasi, semoga bermanfaat',
            'Semoga lekas sembuh',
            'Keren nih kampanyenya!',
            'Support penuh untuk kampanye ini',
            'Semoga sukses!',
            'Sudah saya bantu ya',
            'Mari kita dukung bersama',
            'Semoga berkah',
            'Aamiin YRA',
            'Semangat terus!',
            'Turut prihatin dan berdoa',
        ];

        for ($i = 0; $i < 800; $i++) {
            Comment::create([
                'post_id' => $posts[array_rand($posts)]->id,
                'user_id' => $users[array_rand($users)]->id,
                'content' => $commentTexts[array_rand($commentTexts)],
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        echo "Creating likes...\n";
        $likeData = [];
        for ($i = 0; $i < 1500; $i++) {
            $postId = $posts[array_rand($posts)]->id;
            $userId = $users[array_rand($users)]->id;

            $key = $postId . '-' . $userId;
            if (!isset($likeData[$key])) {
                $likeData[$key] = true;
                Like::create([
                    'post_id' => $postId,
                    'user_id' => $userId,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }


        echo "Creating bookmarks...\n";
        $bookmarkData = [];
        for ($i = 0; $i < 300; $i++) {
            $postId = $posts[array_rand($posts)]->id;
            $userId = $users[array_rand($users)]->id;


            $key = $postId . '-' . $userId;
            if (!isset($bookmarkData[$key])) {
                $bookmarkData[$key] = true;
                Bookmark::create([
                    'post_id' => $postId,
                    'user_id' => $userId,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }
        }


        echo "Creating shares...\n";
        $platforms = ['facebook', 'twitter', 'whatsapp', 'telegram', 'instagram'];

        for ($i = 0; $i < 400; $i++) {
            $post = $posts[array_rand($posts)];
            Share::create([
                'post_id' => $post->id,
                'user_id' => $users[array_rand($users)]->id,
                'platform' => $platforms[array_rand($platforms)],
                'share_url' => url('/posts/' . $post->id),
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }


        echo "================================================\n";
        echo "Summary:\n";
        echo "- Users: " . User::count() . "\n";
        echo "- Categories: " . Category::count() . "\n";
        echo "- Posts: " . Post::count() . "\n";
        echo "- Donations: " . Donation::count() . "\n";
        echo "- Comments: " . Comment::count() . "\n";
        echo "- Likes: " . Like::count() . "\n";
        echo "- Bookmarks: " . Bookmark::count() . "\n";
        echo "- Shares: " . Share::count() . "\n";
        echo "================================================\n";
        echo "\nLogin credentials:\n";
        echo "Email: admin@openhands.com\n";
        echo "Password: password\n";
        echo "\nOr any user1-49@example.com with password: password\n";
    }
}
