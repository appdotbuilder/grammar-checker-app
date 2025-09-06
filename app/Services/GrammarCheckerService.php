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
        $issues = $this->_getIssues($originalText, $correctedText);
        $score = $this->_calculateScore($originalText, $issues);
        $suggestions = $this->generateSuggestions($originalText, $correctedText, $issues);

        return [
            'original_text' => $originalText,
            'corrected_text' => $correctedText,
            'suggestions' => $suggestions,
            'score' => $score,
        ];
    }

    /**
     * Identify specific issues by comparing original and corrected text
     */
    protected function _getIssues(string $original, string $corrected): array
    {
        $issues = [];
        
        // Check for capitalization issues
        if (preg_match('/\bi\b(?!\s+am|\'m)/i', $original)) {
            $issues[] = 'capitalization';
        }
        
        // Check for sentence start capitalization
        if (preg_match('/[.!?]\s*[a-z]/', $original)) {
            $issues[] = 'sentence_capitalization';
        }
        
        // Check for spelling errors
        if (preg_match('/\b(teh|recieve|seperate|definately|neccessary|occuring|existance|environement|goverment|accomodate)\b/i', $original)) {
            $issues[] = 'spelling';
        }
        
        // Check for homophone errors
        if (preg_match('/\b(your\s+welcome|your\s+going|there\s+going|its\s+okay|thier)\b/i', $original)) {
            $issues[] = 'homophone';
        }
        
        // Check for punctuation spacing errors
        if (preg_match('/\s+[,.!?]/', $original)) {
            $issues[] = 'punctuation';
        }
        
        // Check for grammar structure issues (based on text length and corrections made)
        $originalWords = str_word_count($original);
        $correctedWords = str_word_count($corrected);
        if (abs($originalWords - $correctedWords) > 1 || strlen($original) !== strlen($corrected)) {
            $issues[] = 'grammar_structure';
        }
        
        return array_unique($issues);
    }

    /**
     * Calculate score based on identified issues
     */
    protected function _calculateScore(string $original, array $issues): int
    {
        $score = 100;
        
        foreach ($issues as $issue) {
            switch ($issue) {
                case 'capitalization':
                    $score -= 5;
                    break;
                case 'spelling':
                    $score -= 10;
                    break;
                case 'homophone':
                    $score -= 15;
                    break;
                case 'punctuation':
                    $score -= 5;
                    break;
                case 'sentence_capitalization':
                    $score -= 10;
                    break;
                case 'grammar_structure':
                    $score -= 8;
                    break;
                default:
                    $score -= 5;
                    break;
            }
        }
        
        return max(0, $score);
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
     * Generate suggestions based on corrections made and issues identified
     */
    public function generateSuggestions(string $original, string $corrected, array $issues = []): string
    {
        if (empty($issues) && $original === $corrected) {
            return 'Teks Anda sudah cukup baik! Struktur kalimat dan tata bahasa terlihat benar. Pertahankan gaya penulisan yang jelas dan natural seperti ini.';
        }

        $suggestions = [];
        
        // Generate specific suggestions based on issues
        foreach ($issues as $issue) {
            switch ($issue) {
                case 'capitalization':
                    $suggestions[] = 'Selalu gunakan huruf kapital "I" dalam bahasa Inggris';
                    break;
                case 'spelling':
                    $suggestions[] = 'Perhatikan ejaan kata-kata yang sering salah';
                    break;
                case 'homophone':
                    $suggestions[] = 'Bedakan penggunaan your/you\'re, its/it\'s, their/there/they\'re';
                    break;
                case 'sentence_capitalization':
                    $suggestions[] = 'Gunakan huruf kapital di awal kalimat setelah tanda baca';
                    break;
                case 'punctuation':
                    $suggestions[] = 'Jangan beri spasi sebelum tanda baca';
                    break;
                case 'grammar_structure':
                    $suggestions[] = 'Perhatikan struktur kalimat dan tata bahasa';
                    break;
            }
        }

        if (empty($suggestions)) {
            $suggestions[] = 'Terdapat beberapa perbaikan kecil pada struktur dan tata bahasa untuk membuat teks lebih natural';
        }

        return 'Saran perbaikan: ' . implode('. ', $suggestions) . '.';
    }
}