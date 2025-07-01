<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DetectionController extends Controller
{
    public function index()
    {
        return view('detection');
    }

    public function detect(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        try {
            $response = Http::post('http://localhost:5000/detect', [
                'url' => $request->url
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                // Store the complete result in the session
                session(['detection_result' => $result]);
                
                return redirect()->route('detection.index')->with('detection_result', $result);
            }

            return redirect()
                ->route('detection.index')
                ->with('error', 'Error processing the article: ' . ($result['message'] ?? 'Unknown error'));

        } catch (\Exception $e) {
            return redirect()
                ->route('detection.index')
                ->with('error', 'Service unavailable: ' . $e->getMessage())
                ->with('url', $request->url);
        }
    }
} 