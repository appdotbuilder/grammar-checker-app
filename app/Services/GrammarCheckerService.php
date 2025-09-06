<?php

namespace App\Services;

class GrammarCheckerService
{
    /**
     * Check and correct grammar, spelling, and punctuation errors
     */
    public function checkGrammar(string $text): array
    {
        // Simulate grammar checking with common corrections
        $originalText = $text;
        $correctedText = $this->applyCorrections($text);
        $suggestions = $this->generateSuggestions($originalText, $correctedText);

        return [
            'original_text' => $originalText,
            'corrected_text' => $correctedText,
            'suggestions' => $suggestions,
        ];
    }

    /**
     * Apply common grammar and spelling corrections
     */
    public function applyCorrections(string $text): string
    {
        $corrections = [
            // Common spelling mistakes
            '/\bteh\b/i' => 'the',
            '/\brecieve\b/i' => 'receive',
            '/\boccur\b/i' => 'occur',
            '/\bseperate\b/i' => 'separate',
            '/\bdefinately\b/i' => 'definitely',
            '/\baccommodate\b/i' => 'accommodate',
            '/\bneccessary\b/i' => 'necessary',
            '/\bexistance\b/i' => 'existence',
            '/\benvironment\b/i' => 'environment',
            '/\bgovernment\b/i' => 'government',

            // Grammar corrections
            '/\bi\b(?!\s+am|\'m)/i' => 'I', // Capitalize I
            '/\byour\s+welcome\b/i' => 'you\'re welcome',
            '/\bits\s+okay\b/i' => 'it\'s okay',
            '/\bthier\b/i' => 'their',
            '/\bthere\s+going\b/i' => 'they\'re going',
            '/\byour\s+going\b/i' => 'you\'re going',

            // Punctuation fixes
            '/\s+,/' => ',',
            '/\s+\./' => '.',
            '/\s+!/' => '!',
            '/\s+\?/' => '?',
            '/([.!?])\s*([a-z])/' => '$1 ' . strtoupper('$2'),
        ];

        $correctedText = $text;
        foreach ($corrections as $pattern => $replacement) {
            $correctedText = preg_replace($pattern, $replacement, $correctedText);
        }

        // Fix sentence capitalization
        $correctedText = $this->capitalizeSentences($correctedText);
        
        // Remove extra whitespace
        $correctedText = preg_replace('/\s+/', ' ', $correctedText);
        $correctedText = trim($correctedText);

        return $correctedText;
    }

    /**
     * Capitalize the first letter of each sentence
     */
    public function capitalizeSentences(string $text): string
    {
        // Split by sentence-ending punctuation
        $sentences = preg_split('/([.!?]+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        for ($i = 0; $i < count($sentences); $i += 2) {
            if (isset($sentences[$i]) && !empty(trim($sentences[$i]))) {
                $sentences[$i] = ucfirst(ltrim($sentences[$i]));
            }
        }
        
        return implode('', $sentences);
    }

    /**
     * Generate suggestions based on corrections made
     */
    public function generateSuggestions(string $original, string $corrected): string
    {
        if ($original === $corrected) {
            return 'Teks Anda sudah cukup baik! Struktur kalimat dan tata bahasa terlihat benar. Pertahankan gaya penulisan yang jelas dan natural seperti ini.';
        }

        $suggestions = [];
        
        // Check for common issues
        if (preg_match('/\bi\b(?!\s+am|\'m)/i', $original)) {
            $suggestions[] = 'Selalu gunakan huruf kapital "I" dalam bahasa Inggris';
        }
        
        if (preg_match('/\b(teh|recieve|seperate|definately)\b/i', $original)) {
            $suggestions[] = 'Perhatikan ejaan kata-kata yang sering salah';
        }
        
        if (preg_match('/(your\s+welcome|its\s+okay|thier|there\s+going)/i', $original)) {
            $suggestions[] = 'Bedakan penggunaan your/you\'re, its/it\'s, their/there/they\'re';
        }
        
        if (preg_match('/[.!?]\s*[a-z]/', $original)) {
            $suggestions[] = 'Gunakan huruf kapital di awal kalimat setelah tanda baca';
        }
        
        if (preg_match('/\s+[,.!?]/', $original)) {
            $suggestions[] = 'Jangan beri spasi sebelum tanda baca';
        }

        if (empty($suggestions)) {
            $suggestions[] = 'Terdapat beberapa perbaikan kecil pada struktur dan tata bahasa untuk membuat teks lebih natural';
        }

        return 'Saran perbaikan: ' . implode('. ', $suggestions) . '.';
    }
}