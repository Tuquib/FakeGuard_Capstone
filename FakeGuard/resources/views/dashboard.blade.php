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
    :root {
      --bg-color: #fff;
      --text-color: #111;
      --card-bg: #f8f9fa;
      --border-color: #ddd;
      --navbar-bg: #fff;
      --input-bg: #fff;
      --input-border: #ccc;
      --input-text: #111;
      --primary: #556B2F;
      --primary-hover: #6B8E23;
      --alert-bg: #f8f9fa;
      --alert-text: #888;
      --real: #00FF00;
      --fake: #FF0000;
      --loading-bg: rgba(34,34,34,0.7); /* shade of black */
      --loading-spinner: #222;
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
      --card-bg: #000;
      --border-color: #333;
      --navbar-bg: #000;
      --input-bg: #000;
      --input-border: #333;
      --input-text: #fff;
      --primary: #556B2F;
      --primary-hover: #6B8E23;
      --alert-bg: #000;
      --alert-text: #888;
      --loading-bg: rgba(243,243,243,0.7); /* shade of white */
      --loading-spinner: #f3f3f3;
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
    .main-content {
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }
    .url-input {
      background-color: var(--input-bg);
      border: 1px solid var(--input-border);
      color: var(--input-text);
      padding: 1rem;
    }
    .url-input::placeholder {
      color: #666;
    }
    .url-input:focus {
      background-color: var(--input-bg);
      border-color: var(--primary);
      color: var(--input-text);
      box-shadow: none;
    }
    .submit-btn {
      background-color: var(--primary);
      border: none;
      padding: 1rem 2rem;
      color: #fff;
    }
    .submit-btn:hover {
      background-color: var(--primary-hover);
      color: #fff;
    }
    .logout-btn {
      background-color: transparent;
      border: 1px solid var(--primary);
      color: var(--text-color);
      transition: all 0.3s ease;
    }
    .logout-btn:hover {
      background-color: var(--primary);
      color: #fff;
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
    .welcome-section {
      margin-bottom: 3rem;
    }
    .welcome-section p {
      color: #888;
    }
    .card {
      background-color: var(--card-bg);
      border: 1px solid var(--border-color);
    }
    .card-title {
      color: var(--text-color);
    }
    .alert {
      background-color: var(--alert-bg);
      border: 1px solid var(--border-color);
      color: var(--alert-text);
    }
    .alert strong {
      color: var(--text-color);
    }
    .alert svg {
      color: var(--primary);
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
        var(--real) 0deg 291deg,
        var(--fake) 291deg 360deg
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
      color: var(--real);
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
    .legend-real { background-color: var(--real); }
    .legend-fake { background-color: var(--fake); }
    .loading {
      display: none;
      text-align: center;
      margin: 2rem 0;
      border-radius: 12px;
      padding: 2rem 0;
    }
    .loading-spinner {
      width: 40px;
      height: 40px;
      border: 4px solid rgba(255, 255, 255, 0.1);
      border-left-color: var(--loading-spinner);
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto;
    }
    .loading-text {
      margin-top: 1rem;
      color: var(--text-color);
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
      color: var(--real);
    }
    .source-badge.dataset {
      background: rgba(0, 0, 255, 0.2);
      color: var(--real);
    }
    .url-preview {
      margin-top: 1rem;
      padding: 1rem;
      background: rgba(0,0,0,0.05);
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
      color: var(--text-color);
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
      background: rgba(0,0,0,0.05);
      padding: 1.5rem;
      border-radius: 8px;
      text-align: center;
    }
    .stat-value {
      font-size: 2rem;
      font-weight: 600;
      color: var(--real);
      margin-bottom: 0.5rem;
    }
    .stat-label {
      color: #888;
      font-size: 0.9rem;
    }
    .article-text {
      background: rgba(0,0,0,0.1);
      border-radius: 8px;
      padding: 1.5rem;
      margin: 2rem 0;
      color: var(--text-color);
      line-height: 1.6;
    }
    .detection-text {
      color: #666;
      line-height: 1.8;
      font-size: 1rem;
      margin-bottom: 1rem;
    }
    .highlight-real {
      color: var(--real);
      font-weight: 500;
    }
    .highlight-fake {
      color: var(--fake);
      font-weight: 500;
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
      <button class="toggle-darkmode" id="toggleDarkMode" title="Toggle dark mode">🌙</button>
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
          <strong>How it works:</strong> We use a machine learning model to analyze the article content and compare it with our verified dataset.
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

    // Add dark mode toggle logic
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
