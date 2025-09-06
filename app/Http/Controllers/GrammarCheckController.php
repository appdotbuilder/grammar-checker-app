<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGrammarCheckRequest;
use App\Models\GrammarCheck;
use App\Services\GrammarCheckerService;
use Inertia\Inertia;

class GrammarCheckController extends Controller
{
    /**
     * Display the grammar checker form.
     */
    public function index()
    {
        return Inertia::render('welcome');
    }

    /**
     * Process the grammar check request.
     */
    public function store(StoreGrammarCheckRequest $request, GrammarCheckerService $grammarChecker)
    {
        $validatedData = $request->validated();
        
        // Check grammar using the service
        $result = $grammarChecker->checkGrammar($validatedData['text']);
        
        // Save the result to database
        $grammarCheck = GrammarCheck::create([
            'name' => $validatedData['name'],
            'school' => $validatedData['school'],
            'original_text' => $result['original_text'],
            'corrected_text' => $result['corrected_text'],
            'suggestions' => $result['suggestions'],
            'score' => $result['score'],
        ]);

        return Inertia::render('welcome', [
            'result' => [
                'original_text' => $result['original_text'],
                'corrected_text' => $result['corrected_text'],
                'suggestions' => $result['suggestions'],
                'score' => $result['score'],
                'name' => $validatedData['name'],
                'school' => $validatedData['school'],
            ]
        ]);
    }

    /**
     * Display the history of grammar checks.
     */
    public function show()
    {
        $grammarChecks = GrammarCheck::latest()
            ->take(20)
            ->get();

        return Inertia::render('grammar-history', [
            'grammarChecks' => $grammarChecks
        ]);
    }
}