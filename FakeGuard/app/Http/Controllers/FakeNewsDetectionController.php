<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FakeNewsDetectionController extends Controller
{
    private $modelEndpoint;

    public function __construct()
    {
        // This should be configured in your .env file
        $this->modelEndpoint = env('BERT_MODEL_ENDPOINT', 'http://localhost:5000/predict');
    }

    public function showResults(Request $request)
    {
        $result = session('detection_result', []);
        
        return view('detection', [
            'prediction' => $result['final_decision']['prediction'] ?? '',
            'confidence' => $result['final_decision']['confidence'] ?? 0,
            'realPercentage' => $result['bert_result']['real_percentage'] ?? 0,
            'fakePercentage' => $result['bert_result']['fake_percentage'] ?? 0,
            'url' => $result['url'] ?? '',
            'articleText' => $result['text'] ?? '',
            'articleTitle' => $result['title'] ?? '',
            'source' => $result['final_decision']['source'] ?? 'Model',
            'factCheckResult' => $result['fact_check_result'] ?? null,
            'highlightedText' => $result['highlighted_text'] ?? []
        ]);
    }

    public function detect(Request $request)
    {
        try {
            $request->validate([
                'url' => 'required|url'
            ]);

            // Extract text from URL using newspaper3k
            $python = 'python';
            $script = base_path('model/extract_article.py');
            $url = escapeshellarg($request->url);
            
            $command = "$python $script $url";
            $output = shell_exec($command);
            
            if (!$output) {
                throw new \Exception('Failed to extract article content');
            }
            
            $article = json_decode($output, true);
            
            if (!$article || json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid article data');
            }

            // Send the text to the BERT model endpoint
            $response = Http::post('http://localhost:5000/detect', [
                'url' => $request->url
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to get prediction from model');
            }

            $result = $response->json();
            
            // Store the results in session
            session(['detection_result' => $result]);

            return response()->json([
                'success' => true,
                'result' => $result,
                'redirect' => route('detection.results')
            ]);
        } catch (\Exception $e) {
            Log::error('Detection error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to analyze the article: ' . $e->getMessage()
            ], 500);
        }
    }

    public function preview(Request $request)
    {
        try {
            $request->validate([
                'url' => 'required|url'
            ]);

            // Use newspaper3k to extract article info
            $python = 'python';
            $script = base_path('model/extract_preview.py');
            $url = escapeshellarg($request->url);
            
            $command = "$python $script $url";
            $output = shell_exec($command);
            
            if (!$output) {
                throw new \Exception('Failed to extract article preview');
            }
            
            $preview = json_decode($output, true);
            
            if (!$preview || json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid preview data');
            }
            
            return response()->json([
                'success' => true,
                'title' => $preview['title'] ?? '',
                'description' => $preview['description'] ?? '',
                'image' => $preview['image'] ?? ''
            ]);
        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get article preview: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'detection_result' => 'required|array',
                'url' => 'required|string'
            ]);

            $detectionResult = $request->detection_result;
            // Add the URL to the detection result
            $detectionResult['url'] = $request->url;
            
            // Store the complete detection result in session
            session(['detection_result' => $detectionResult]);

            return response()->json([
                'success' => true,
                'message' => 'Detection results stored successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Store detection error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to store detection results: ' . $e->getMessage()
            ], 500);
        }
    }
} 