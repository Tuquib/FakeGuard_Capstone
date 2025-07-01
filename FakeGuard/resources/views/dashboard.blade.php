<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard - FakeGuard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #000000;
      color: white;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
    }
    .navbar {
      background-color: #000000;
      padding: 1rem 2rem;
      border-bottom: 1px solid #333;
    }
    .navbar-brand {
      display: flex;
      align-items: center;
      gap: 1rem;
      color: white;
      text-decoration: none;
    }
    .navbar-brand img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }
    .main-content {
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .url-input {
      background-color: #000000;
      border: 1px solid #333;
      color: white;
      padding: 1rem;
    }
    .url-input::placeholder {
      color: #666;
    }
    .url-input:focus {
      background-color: #000000;
      border-color: #556B2F;
      color: white;
      box-shadow: none;
    }
    .submit-btn {
      background-color: #556B2F;
      border: none;
      padding: 1rem 2rem;
      color: white;
    }
    .submit-btn:hover {
      background-color: #6B8E23;
      color: white;
    }
    .logout-btn {
      background-color: transparent;
      border: 1px solid #556B2F;
      color: white;
      transition: all 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #556B2F;
      color: white;
    }
    .welcome-section {
      margin-bottom: 3rem;
    }
    .welcome-section p {
      color: #888;
    }
    .card {
      background-color: #000000;
      border: 1px solid #333;
    }
    .card-title {
      color: white;
    }
    .alert {
      background-color: #000000;
      border: 1px solid #333;
      color: #888;
    }
    .alert strong {
      color: white;
    }
    .alert svg {
      color: #556B2F;
    }
    .result-section {
      display: none;
      margin-top: 2rem;
    }
    .chart-container {
      position: relative;
      width: 300px;
      margin: 0 auto;
    }
    .pie-chart {
      width: 300px;
      height: 300px;
      border-radius: 50%;
      background: conic-gradient(
        #00FF00 0deg 291deg,
        #FF0000 291deg 360deg
      );
      box-shadow: 0 0 30px rgba(0, 255, 0, 0.2);
    }
    .chart-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 200px;
      height: 200px;
      background: #000000;
      border-radius: 50%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .percentage {
      font-size: 2.5rem;
      font-weight: 700;
      color: #00FF00;
      margin: 0;
      line-height: 1;
    }
    .status {
      font-size: 1.2rem;
      color: #888;
      margin-top: 0.5rem;
    }
    .chart-legend {
      margin-top: 2rem;
      display: flex;
      justify-content: center;
      gap: 2rem;
    }
    .legend-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .legend-color {
      width: 12px;
      height: 12px;
      border-radius: 2px;
    }
    .legend-real { background-color: #00FF00; }
    .legend-fake { background-color: #FF0000; }
    .loading {
      display: none;
      text-align: center;
      margin: 2rem 0;
    }
    .loading-spinner {
      width: 40px;
      height: 40px;
      border: 4px solid rgba(255, 255, 255, 0.1);
      border-left-color: #00FF00;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }
    .loading-text {
      margin-top: 1rem;
      color: #00FF00;
      font-size: 1.1rem;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
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
      background: rgba(0, 255, 0, 0.2);
      color: #00FF00;
    }
    .source-badge.dataset {
      background: rgba(0, 0, 255, 0.2);
      color: #00FF00;
    }
    .url-preview {
      margin-top: 1rem;
      padding: 1rem;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      display: none;
    }
    .url-preview img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
    .url-preview h3 {
      color: #fff;
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
    }
    .url-preview p {
      color: #888;
      font-size: 0.9rem;
      margin-bottom: 0;
    }
    .detection-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-top: 2rem;
    }
    .stat-card {
      background: rgba(255, 255, 255, 0.05);
      padding: 1.5rem;
      border-radius: 8px;
      text-align: center;
    }
    .stat-value {
      font-size: 2rem;
      font-weight: 600;
      color: #00FF00;
      margin-bottom: 0.5rem;
    }
    .stat-label {
      color: #888;
      font-size: 0.9rem;
    }
    .article-text {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      padding: 1.5rem;
      margin: 2rem 0;
      color: #fff;
      line-height: 1.6;
    }
    .detection-text {
      color: #666;
      line-height: 1.8;
      font-size: 1rem;
      margin-bottom: 1rem;
    }
    .highlight-real {
      color: #00FF00;
      font-weight: 500;
    }
    .highlight-fake {
      color: #FF0000;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container-fluid">
      <a href="#" class="navbar-brand">
        <img src="{{ asset('build/assets/images/logo.png') }}" alt="FakeGuard Logo">
        <span>FakeGuard</span>
      </a>
      <form method="POST" action="{{ route('logout') }}" class="d-flex">
        @csrf
        <button type="submit" class="btn logout-btn">Logout</button>
      </form>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content">
    <div class="welcome-section">
      <h1>Hi! {{ Auth::user()->name }}</h1>
      <h1>Welcome to FakeGuard</h1>
      <p>Enter a news article URL below to detect if it's real or fake news.</p>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="alert alert-info" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
          </svg>
          <strong>How it works:</strong> Our AI model analyzes the article content and compares it with our verified dataset.
        </div>

        <!-- Input Form -->
        <form onsubmit="detectFakeNews(); return false;">
          <div class="mb-3">
            <label for="newsUrl" class="form-label">News Article URL</label>
            <div class="input-group">
              <input type="url" id="newsUrl" class="form-control url-input" placeholder="Paste news article URL here" required>
              <button class="btn submit-btn" type="submit">
                <span class="button-text">Detect Fake News</span>
                <div class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </button>
            </div>
          </div>
        </form>

        <!-- URL Preview -->
        <div class="url-preview" id="urlPreview" style="display: none;">
          <img id="previewImage" src="" alt="Article preview">
          <h3 id="previewTitle"></h3>
          <p id="previewDescription"></p>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div class="loading" id="loading" style="display: none;">
      <div class="loading-spinner"></div>
      <div class="loading-text">Analyzing article...</div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    async function detectFakeNews() {
      const url = document.getElementById('newsUrl').value;
      const button = document.querySelector('.submit-btn');
      const buttonText = button.querySelector('.button-text');
      const spinner = button.querySelector('.spinner-border');

      if (!url.trim()) {
        showError('Please enter a valid news article URL');
        return;
      }

      // Show loading state
      button.disabled = true;
      buttonText.textContent = 'Analyzing...';
      spinner.classList.remove('d-none');
      document.getElementById('loading').style.display = 'block';

      try {
        const response = await fetch(`{{ route("detect") }}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ url: url.trim() })
        });

        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.error || 'Failed to analyze the article');
        }

        // Store results in session and redirect
        const storeResponse = await fetch('{{ route("store.detection") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            detection_result: data.result,
            url: url.trim()
          })
        });

        if (!storeResponse.ok) {
          throw new Error('Failed to store detection results');
        }

        // Redirect to detection view
        window.location.href = '{{ route("detection") }}';

      } catch (error) {
        showError(error.message);
      } finally {
        // Reset button state
        button.disabled = false;
        buttonText.textContent = 'Analyze';
        spinner.classList.add('d-none');
        document.getElementById('loading').style.display = 'none';
      }
    }

    function showError(message) {
      // Create error alert
      const alertDiv = document.createElement('div');
      alertDiv.className = 'alert alert-danger mt-3';
      alertDiv.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
          <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
          <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
        </svg>
        <strong>Error:</strong> ${message}
      `;

      // Remove any existing error alerts
      const existingAlert = document.querySelector('.alert-danger');
      if (existingAlert) {
        existingAlert.remove();
      }

      // Add the new error alert
      const cardBody = document.querySelector('.card-body');
      cardBody.appendChild(alertDiv);

      // Scroll to the error message
      alertDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Preview URL when pasted
    document.getElementById('newsUrl').addEventListener('paste', async (e) => {
      const url = e.clipboardData.getData('text');
      if (!url) return;

      const preview = document.getElementById('urlPreview');
      preview.style.display = 'none';
      
      try {
        // Show loading state for preview
        const previewImage = document.getElementById('previewImage');
        const previewTitle = document.getElementById('previewTitle');
        const previewDescription = document.getElementById('previewDescription');
        
        previewImage.src = '';
        previewTitle.textContent = 'Loading preview...';
        previewDescription.textContent = '';
        preview.style.display = 'block';

        // Get preview data from backend
        const response = await fetch('{{ route("preview") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ url })
        });

        const data = await response.json();

        if (data.success) {
          previewImage.src = data.image || '';
          previewTitle.textContent = data.title || 'No title available';
          previewDescription.textContent = data.description || 'No description available';
          preview.style.display = 'block';
        } else {
          preview.style.display = 'none';
        }
      } catch (error) {
        console.error('Error fetching preview:', error);
        preview.style.display = 'none';
      }
    });
  </script>
</body>
</html>