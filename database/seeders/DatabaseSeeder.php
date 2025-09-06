<?php

namespace Database\Seeders;

use App\Models\GrammarCheck;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create sample grammar checks
        GrammarCheck::factory()->create([
            'name' => 'Ahmad Fauzi',
            'school' => 'SMA Negeri 1 Jakarta',
            'original_text' => 'i think teh weather is nice today. its really good for going out.',
            'corrected_text' => 'I think the weather is nice today. It\'s really good for going out.',
            'suggestions' => 'Saran perbaikan: Selalu gunakan huruf kapital "I" dalam bahasa Inggris. Perhatikan ejaan kata-kata yang sering salah. Bedakan penggunaan its/it\'s.',
        ]);

        GrammarCheck::factory()->create([
            'name' => 'Sari Dewi',
            'school' => 'Universitas Indonesia',
            'original_text' => 'The students was studying in the library when there teacher arrived.',
            'corrected_text' => 'The students were studying in the library when their teacher arrived.',
            'suggestions' => 'Saran perbaikan: Perhatikan kesepakatan subjek-verba (students were, bukan students was). Bedakan penggunaan their/there/they\'re.',
        ]);

        GrammarCheck::factory()->create([
            'name' => 'Rizki Pratama',
            'school' => 'SMK Negeri 5 Bandung',
            'original_text' => 'Your writing is excellent and demonstrates a clear understanding of the topic.',
            'corrected_text' => 'Your writing is excellent and demonstrates a clear understanding of the topic.',
            'suggestions' => 'Teks Anda sudah cukup baik! Struktur kalimat dan tata bahasa terlihat benar. Pertahankan gaya penulisan yang jelas dan natural seperti ini.',
        ]);

        // Create more sample data
        GrammarCheck::factory()->count(7)->create();
    }
}
