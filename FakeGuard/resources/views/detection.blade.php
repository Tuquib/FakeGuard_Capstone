<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detection Results - FakeGuard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #fff;
            --text-color: #111;
            --card-bg: #fff;
            --card-border: #d1d5db;
            --border-color: #ddd;
            --navbar-bg: #fff;
            --input-bg: #fff;
            --input-border: #ccc;
            --input-text: #111;
            --primary: #556B2F;
            --primary-hover: #6B8E23;
            --alert-bg: #f8f9fa;
            --alert-text: #888;
            --real: #218838; /* deep green for light mode */
            --fake: #C82333; /* deep red for light mode */
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            transition: background 0.3s, color 0.3s;
        }
        .dark-mode {
            --bg-color: #000;
            --text-color: #fff;
            --card-bg: #181a1b;
            --card-border: #333;
            --border-color: #333;
            --navbar-bg: #000;
            --input-bg: #000;
            --input-border: #333;
            --input-text: #fff;
            --primary: #556B2F;
            --primary-hover: #6B8E23;
            --alert-bg: #000;
            --alert-text: #888;
            --real: #39FF14; /* bright green for dark mode */
            --fake: #FF4C4C; /* bright red for dark mode */
        }
        .navbar {
            background-color: var(--navbar-bg);
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-color);
            text-decoration: none;
        }
        .navbar-brand img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .detection-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .result-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .result-header h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .result-header p {
            color: #888;
            font-size: 1.1rem;
        }
        .chart-section {
            display: flex;
            gap: 4rem;
            margin-top: 2rem;
            align-items: flex-start;
        }
        .chart-container {
            position: relative;
            width: 300px;
        }
        .pie-chart {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.2);
            transition: background 0.5s ease;
        }
        .chart-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            background: var(--bg-color);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .percentage {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            line-height: 1;
            transition: color 0.5s ease;
            color: var(--real);
        }
        .status {
            font-size: 1.2rem;
            margin-top: 0.5rem;
            transition: color 0.5s ease;
            color: #888;
        }
        .detection-details {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            margin-top: 3rem;
            border: 1px solid var(--border-color);
        }
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .detail-item {
            text-align: center;
        }
        .detail-value {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-color);
        }
        .detail-label {
            color: #888;
            font-size: 0.9rem;
        }
        .article-info {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
            border: 1px solid var(--border-color);
        }
        .article-header {
            margin-bottom: 1.5rem;
        }
        .article-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-color);
        }
        .article-meta {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        .article-content {
            color: var(--text-color);
            line-height: 1.8;
            font-size: 1.1rem;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
            white-space: pre-line;
        }
        .source-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-left: 1rem;
        }
        .source-badge.model {
            background: rgba(0, 128, 255, 0.2);
            color: #00BFFF;
            border: 1px solid rgba(0, 128, 255, 0.3);
        }
        .source-badge.fact-check {
            background: rgba(0, 255, 0, 0.2);
            color: #00FF00;
            border: 1px solid rgba(0, 255, 0, 0.3);
        }
        .source-badge.dataset {
            background: rgba(0, 0, 255, 0.2);
            color: #00FF00;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--real);
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 2rem;
        }
        .back-btn:hover {
            background: var(--real);
            color: var(--bg-color);
        }
        .confidence-meter {
            width: 100%;
            height: 8px;
            background: rgba(0,0,0,0.1);
            border-radius: 4px;
            margin-top: 1rem;
            overflow: hidden;
        }
        .confidence-bar {
            height: 100%;
            background: var(--real);
            border-radius: 4px;
            transition: width 0.5s ease;
        }
        .percentage-details {
            display: flex;
            justify-content: space-around;
            margin-top: 1rem;
            padding: 1rem;
            background: var(--card-bg);
            border-radius: 8px;
        }
        .percentage-item {
            text-align: center;
        }
        .percentage-value {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .percentage-label {
            color: #888;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        .real-percentage {
            color: var(--real);
        }
        .fake-percentage {
            color: var(--fake);
        }
        .highlighted-text {
            font-weight: bold;
        }
        .real-highlight, .fake-highlight {
            display: inline;
            color: var(--text-color);
            padding: 2px 4px;
            margin: 0 2px;
            border-radius: 2px;
            line-height: 1.8;
            transition: all 0.2s ease;
        }
        .real-highlight {
            background-color: rgba(39, 174, 96, calc(var(--opacity) * 0.5));
            box-shadow: 0 0 8px rgba(39, 174, 96, calc(var(--opacity) * 0.3));
        }
        .fake-highlight {
            background-color: rgba(231, 76, 60, calc(var(--opacity) * 0.5));
            box-shadow: 0 0 8px rgba(231, 76, 60, calc(var(--opacity) * 0.3));
        }
        .real-highlight:hover, .fake-highlight:hover {
            filter: brightness(1.2);
        }
        .article-content span {
            transition: all 0.3s ease;
        }
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
        }
        .error-box {
            background: rgba(255, 0, 0, 0.1);
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .error-box svg {
            margin-bottom: 1.5rem;
        }
        .error-box h2 {
            color: #FF0000;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        .error-box p {
            color: #fff;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        .error-box .back-btn {
            margin-top: 0;
        }
        .error-verdict {
            color: #FF0000;
            background: rgba(255, 0, 0, 0.1);
            padding: 1rem 2rem;
            border-radius: 8px;
            text-align: center;
            margin: 2rem 0;
            border: 1px solid #FF0000;
        }
        .error-verdict h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #FF0000;
        }
        .error-verdict p {
            font-size: 1.1rem;
            color: #fff;
            margin-bottom: 0;
        }
        .error-icon {
            width: 64px;
            height: 64px;
            margin-bottom: 1rem;
        }
        .detection-summary {
            background: var(--card-bg);
            border-radius: 8px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
        }
        .summary-section {
            margin-bottom: 1.5rem;
        }
        .sentence-item {
            background: rgba(0,0,0,0.03);
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }
        .sentence-score {
            font-size: 0.9rem;
            color: #888;
            margin-top: 0.5rem;
        }
        .fact-check-section {
            margin-top: 2rem;
            padding: 1.5rem;
            background: var(--card-bg);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--text-color);
        }
        .fact-checks-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .fact-check-item {
            padding: 1rem;
            background: rgba(0,0,0,0.03);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .fact-check-item:hover {
            background: rgba(0,0,0,0.05);
        }
        .fact-check-claim {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        .claimant {
            color: #888;
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }
        .fact-check-review {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 0.75rem;
            background: rgba(0,0,0,0.02);
            border-radius: 4px;
            margin-top: 0.5rem;
        }
        .review-source {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .publisher {
            font-weight: 500;
            color: var(--real);
        }
        .review-rating {
            color: var(--text-color);
        }
        .rating {
            color: var(--real);
            font-weight: 500;
        }
        .review-link {
            margin-left: auto;
            color: var(--real);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(0, 255, 0, 0.1);
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        .review-link:hover {
            background: rgba(0, 255, 0, 0.2);
        }
        .review-link svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
        }
        .claims-info {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--card-bg);
            border-radius: 8px;
        }
        .claims-count {
            font-size: 0.9rem;
            color: #888;
        }
        .toggle-darkmode {
            margin-left: 1rem;
            background: none;
            border: 1px solid var(--primary);
            color: var(--primary);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
        }
        .toggle-darkmode.active, .toggle-darkmode:hover {
            background: var(--primary);
            color: #fff;
        }
        .real-color { color: var(--real) !important; }
        .fake-color { color: var(--fake) !important; }
        .btn,
        button,
        .toggle-darkmode,
        .back-btn {
            background: #111;
            color: #fff;
            border: 1.5px solid #111;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .btn,
    button,
    .toggle-darkmode,
    .logout-btn {
        background: #111;
        color: #fff;
        border: 1.5px solid #111;
        transition: background 0.2s, color 0.2s, border 0.2s;
    }
    .btn:hover,
        button:hover,
        .toggle-darkmode:hover,
        .toggle-darkmode.active,
        .back-btn:hover {
            background: #fff;
            color: #111;
            border: 1.5px solid #111;
        }
        body.dark-mode .btn,
        body.dark-mode button,
        body.dark-mode .toggle-darkmode,
        body.dark-mode .back-btn {
            background: #fff;
            color: #111;
            border: 1.5px solid #fff;
        }
        body.dark-mode .btn:hover,
        body.dark-mode button:hover,
        body.dark-mode .toggle-darkmode:hover,
        body.dark-mode .back-btn:hover {
            background: #111;
            color: #fff;
            border: 1.5px solid #fff;
        }
        nav .toggle-darkmode:hover,
        nav .toggle-darkmode.active {
            background: #fff;
            color: #111;
            border: 1.5px solid #111;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <img src="{{ asset('build/assets/images/logo.png') }}" alt="FakeGuard Logo">
                <span>FakeGuard</span>
            </a>
            <button class="toggle-darkmode" id="toggleDarkMode" title="Toggle dark mode">🌙</button>
        </div>
    </nav>

    <div class="detection-container">
        <div class="result-header">
            <h1>Detection Results</h1>
            <p>Analysis completed for the provided news article</p>
        </div>

        @if(session('error'))
            <div class="error-container">
                <div class="error-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#FF0000" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <h2>Error Occurred</h2>
                    <p>{{ session('error') }}</p>
                    <div class="article-info mt-4">
                        <div class="article-header">
                            <h3 class="article-title">Article Details</h3>
                        </div>
                        <div class="article-meta">
                            <strong>URL:</strong> {{ session('url', 'N/A') }}
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="back-btn btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @elseif(session('detection_result'))
            @if(session('detection_result')['error'] ?? false)
                <div class="error-verdict">
                    <svg class="error-icon" xmlns="http://www.w3.org/2000/svg" fill="#FF0000" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <h2>Error Detected</h2>
                    <p>{{ session('detection_result')['message'] ?? 'Failed to analyze the article' }}</p>
                    <div class="article-info mt-4">
                        <div class="article-header">
                            <h3 class="article-title">Article Details</h3>
                        </div>
                        <div class="article-meta">
                            <strong>URL:</strong> {{ session('detection_result')['url'] ?? 'N/A' }}
                        </div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="back-btn btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            @else
                <div class="chart-section">
                    <div class="chart-container">
                        <div class="pie-chart" style="background: conic-gradient(
                            var(--real) 0deg {{ session('detection_result')['bert_result']['real_percentage'] * 3.6 }}deg,
                            var(--fake) {{ session('detection_result')['bert_result']['real_percentage'] * 3.6 }}deg 360deg
                        );"></div>
                        <div class="chart-overlay">
                            <p class="percentage {{ session('detection_result')['final_decision']['prediction'] === 'Real' ? 'real-color' : 'fake-color' }}">
                                {{ number_format(max(session('detection_result')['bert_result']['real_percentage'], session('detection_result')['bert_result']['fake_percentage']), 1) }}%
                            </p>
                            <p class="status {{ session('detection_result')['final_decision']['prediction'] === 'Real' ? 'real-color' : 'fake-color' }}">
                                {{ session('detection_result')['final_decision']['prediction'] }}
                            </p>
                        </div>
                    </div>

                    <div class="detection-details">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-value {{ session('detection_result')['final_decision']['prediction'] === 'Real' ? 'real-color' : 'fake-color' }}">
                                    {{ session('detection_result')['final_decision']['prediction'] }}
                                    <span class="source-badge {{ strtolower(session('detection_result')['final_decision']['source']) === 'model' ? 'model' : 'fact-check' }}">
                                        {{ strtolower(session('detection_result')['final_decision']['source']) === 'model' ? ' Model ' : 'Fact Check' }}
                                    </span>
                                </div>
                                <div class="detail-label">Final Verdict</div>
                                @if(session('detection_result')['final_decision']['source'] === 'fact_check_api' && count(session('detection_result')['fact_check_result']['matched_claims'] ?? []) > 0)
                                    <div class="claims-info">
                                        <span class="claims-count">{{ count(session('detection_result')['fact_check_result']['matched_claims']) }} fact check claims found</span>
                                    </div>
                                @endif
                            </div>
                            <div class="detail-item">
                                <div class="percentage-details">
                                    <div class="percentage-item">
                                        <div class="percentage-value real-percentage">
                                            {{ number_format(session('detection_result')['bert_result']['real_percentage'], 1) }}%
                                        </div>
                                        <div class="percentage-label">Real Probability</div>
                                    </div>
                                    <div class="percentage-item">
                                        <div class="percentage-value fake-percentage">
                                            {{ number_format(session('detection_result')['bert_result']['fake_percentage'], 1) }}%
                                        </div>
                                        <div class="percentage-label">Fake Probability</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="article-info">
                    <div class="article-header">
                        <h2 class="article-title">
                            @if(session('detection_result')['title'])
                                {{ session('detection_result')['title'] }}
                            @else
                                Article Content
                            @endif
                        </h2>
                        <div class="article-meta">
                            @if(session('detection_result')['url'])
                                <span>URL: {{ session('detection_result')['url'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="article-content">
                        @php
                            $highlightedText = session('detection_result')['highlighted_text'] ?? [];
                            
                            if (!empty($highlightedText)) {
                                foreach ($highlightedText as $item) {
                                    $opacity = max(0.2, min(0.8, $item['confidence'] / 100));
                                    $class = $item['label'] === 'Real' ? 'real-highlight' : 'fake-highlight';
                                    $title = $item['label'] . ': ' . number_format($item['confidence'], 1) . '%';
                                    
                                    echo "<span class='{$class}' style='--opacity: {$opacity}' title='{$title}'>" . 
                                         e($item['sentence']) . 
                                         "</span> ";
                                }
                            } else {
                                echo '<p class="text-muted">No article content available.</p>';
                            }
                        @endphp
                    </div>
                </div>

                <a href="{{ route('dashboard') }}" class="back-btn btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Back to Dashboard
                </a>

                <!-- Add Fact Check Results Section -->
                @if(!empty(session('detection_result')['fact_check_result']['matched_claims']))
                    <div class="fact-check-section">
                        <h3 class="section-title">Related Fact Checks</h3>
                        <div class="fact-checks-container">
                            @foreach(session('detection_result')['fact_check_result']['matched_claims'] as $claim)
                                <div class="fact-check-item">
                                    <div class="fact-check-claim">
                                        <strong>Claim:</strong> {{ $claim['text'] }}
                                        @if(!empty($claim['claimant']))
                                            <span class="claimant">by {{ $claim['claimant'] }}</span>
                                        @endif
                                    </div>
                                    
                                    @foreach($claim['claimReview'] as $review)
                                        <div class="fact-check-review">
                                            <div class="review-source">
                                                <span class="publisher">{{ $review['publisher']['name'] }}</span>
                                            </div>
                                            <div class="review-rating">
                                                Rating: <span class="rating">{{ $review['textualRating'] }}</span>
                                            </div>
                                            <a href="{{ $review['url'] }}" target="_blank" class="review-link">
                                                Read full fact check <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        @else
            <div class="error-container">
                <div class="error-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#FFA500" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <h2>No Detection Results</h2>
                    <p>No article analysis results are available. Please try analyzing an article first.</p>
                    <a href="{{ route('dashboard') }}" class="back-btn btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Dark mode toggle logic
      const darkModeToggle = document.getElementById('toggleDarkMode');
      function setDarkMode(enabled) {
        if (enabled) {
          document.body.classList.add('dark-mode');
          darkModeToggle.classList.add('active');
          darkModeToggle.textContent = '☀️';
        } else {
          document.body.classList.remove('dark-mode');
          darkModeToggle.classList.remove('active');
          darkModeToggle.textContent = '🌙';
        }
      }
      // Load preference
      const darkPref = localStorage.getItem('darkMode') === 'true';
      setDarkMode(darkPref);
      darkModeToggle.addEventListener('click', () => {
        const enabled = !document.body.classList.contains('dark-mode');
        setDarkMode(enabled);
        localStorage.setItem('darkMode', enabled);
      });
    </script>
</body>
</html> 
