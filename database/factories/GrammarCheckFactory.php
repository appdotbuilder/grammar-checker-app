<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrammarCheck>
 */
class GrammarCheckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $samples = [
            [
                'original' => 'i really enjoyed teh movie last night. its was very entertaining and the actors was great.',
                'corrected' => 'I really enjoyed the movie last night. It was very entertaining and the actors were great.',
                'suggestions' => 'Saran perbaikan: Selalu gunakan huruf kapital "I" dalam bahasa Inggris. Perhatikan ejaan kata-kata yang sering salah. Perhatikan kesepakatan subjek-verba.',
                'score' => 65
            ],
            [
                'original' => 'The presentation went very well. Everyone was impressed by the clear explanations and professional delivery.',
                'corrected' => 'The presentation went very well. Everyone was impressed by the clear explanations and professional delivery.',
                'suggestions' => 'Teks Anda sudah cukup baik! Struktur kalimat dan tata bahasa terlihat benar. Pertahankan gaya penulisan yang jelas dan natural seperti ini.',
                'score' => 100
            ],
            [
                'original' => 'your going to love this new restaurant . there food is amazing and the service is excellent .',
                'corrected' => 'You\'re going to love this new restaurant. Their food is amazing and the service is excellent.',
                'suggestions' => 'Saran perbaikan: Bedakan penggunaan your/you\'re, their/there/they\'re. Jangan beri spasi sebelum tanda baca. Gunakan huruf kapital di awal kalimat.',
                'score' => 60
            ],
            [
                'original' => 'The conference was informative and well-organized. I learned many new concepts that will help in my research.',
                'corrected' => 'The conference was informative and well-organized. I learned many new concepts that will help in my research.',
                'suggestions' => 'Teks Anda sudah cukup baik! Struktur kalimat dan tata bahasa terlihat benar. Pertahankan gaya penulisan yang jelas dan natural seperti ini.',
                'score' => 100
            ],
            [
                'original' => 'definately the best book i have ever read . its story was captivating from beginning to end .',
                'corrected' => 'Definitely the best book I have ever read. Its story was captivating from beginning to end.',
                'suggestions' => 'Saran perbaikan: Perhatikan ejaan kata-kata yang sering salah. Selalu gunakan huruf kapital "I" dalam bahasa Inggris. Jangan beri spasi sebelum tanda baca.',
                'score' => 70
            ]
        ];

        $sample = fake()->randomElement($samples);
        
        return [
            'name' => fake()->name(),
            'school' => fake()->randomElement([
                'SMA Negeri 1 Jakarta',
                'Universitas Indonesia',
                'SMK Negeri 5 Bandung',
                'Universitas Gadjah Mada',
                'SMA Negeri 3 Surabaya',
                'Institut Teknologi Bandung',
                'Universitas Airlangga',
                'SMA Negeri 2 Medan'
            ]),
            'original_text' => $sample['original'],
            'corrected_text' => $sample['corrected'],
            'suggestions' => $sample['suggestions'],
            'score' => $sample['score'],
        ];
    }
}