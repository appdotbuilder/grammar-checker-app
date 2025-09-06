<?php

namespace Tests\Feature;

use App\Models\GrammarCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GrammarCheckTest extends TestCase
{
    use RefreshDatabase;

    public function test_grammar_check_page_loads(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('welcome'));
    }

    public function test_can_submit_grammar_check_form(): void
    {
        $formData = [
            'name' => 'John Doe',
            'school' => 'Test University',
            'text' => 'This is a test sentence with some grammar mistakes. i dont know if its correct.'
        ];

        $response = $this->post(route('grammar-check.store'), $formData);

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('welcome')
            ->has('result')
            ->where('result.name', 'John Doe')
            ->where('result.school', 'Test University')
        );

        // Check database
        $this->assertDatabaseHas('grammar_checks', [
            'name' => 'John Doe',
            'school' => 'Test University',
        ]);

        $grammarCheck = GrammarCheck::where('name', 'John Doe')->first();
        $this->assertNotNull($grammarCheck);
        $this->assertNotEmpty($grammarCheck->corrected_text);
        $this->assertNotEmpty($grammarCheck->suggestions);
    }

    public function test_form_validation_works(): void
    {
        // Test empty fields
        $response = $this->post(route('grammar-check.store'), []);
        
        $response->assertSessionHasErrors(['name', 'school', 'text']);

        // Test text too short
        $response = $this->post(route('grammar-check.store'), [
            'name' => 'John Doe',
            'school' => 'Test School',
            'text' => 'Short'
        ]);
        
        $response->assertSessionHasErrors(['text']);
    }

    public function test_grammar_service_corrects_text(): void
    {
        $testText = 'i dont know if teh grammar is correct in this sentence.';
        
        $response = $this->post(route('grammar-check.store'), [
            'name' => 'Test User',
            'school' => 'Test School',
            'text' => $testText
        ]);

        $response->assertStatus(200);
        
        $grammarCheck = GrammarCheck::first();
        $this->assertNotEquals($testText, $grammarCheck->corrected_text);
        $this->assertStringContainsString('I', $grammarCheck->corrected_text); // Should capitalize "i"
        $this->assertStringContainsString('the', $grammarCheck->corrected_text); // Should correct "teh"
    }

    public function test_history_page_loads(): void
    {
        // Create some grammar checks
        GrammarCheck::factory()->count(3)->create();
        
        $response = $this->get(route('grammar-check.history'));
        
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('grammar-history')
            ->has('grammarChecks', 3)
        );
    }

    public function test_history_shows_latest_checks(): void
    {
        // Create grammar checks
        $old = GrammarCheck::factory()->create(['created_at' => now()->subDays(5)]);
        $recent = GrammarCheck::factory()->create(['created_at' => now()]);
        
        $response = $this->get(route('grammar-check.history'));
        
        $response->assertInertia(fn ($page) => $page
            ->has('grammarChecks', 2)
            ->where('grammarChecks.0.id', $recent->id) // Most recent first
            ->where('grammarChecks.1.id', $old->id)
        );
    }
}