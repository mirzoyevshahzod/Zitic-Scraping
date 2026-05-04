<!doctype html>
<html lang="uz">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Scraping Panel</title>

  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: radial-gradient(circle at top, #1e293b, #020617);
      font-family: 'Inter', sans-serif;
      color: #fff;
    }

    .container {
      text-align: center;
      padding: 50px;
      border-radius: 20px;
      backdrop-filter: blur(12px);
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(255,255,255,0.1);
      box-shadow: 0 10px 40px rgba(0,0,0,0.6);
      width: 380px;
    }

    h1 {
      font-size: 26px;
      margin-bottom: 20px;
      letter-spacing: 1px;
    }

    .status {
      margin-bottom: 20px;
      font-size: 14px;
      color: #4ade80;
    }

    button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      background: linear-gradient(135deg, #22c55e, #4ade80);
      color: #022c22;
      transition: all 0.2s ease;
      box-shadow: 0 4px 20px rgba(34,197,94,0.4);
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 25px rgba(34,197,94,0.6);
    }

    button:active {
      transform: scale(0.97);
    }

    .loader {
      display: none;
      margin-top: 15px;
      font-size: 13px;
      color: #94a3b8;
    }

    .output {
      margin-top: 20px;
      text-align: left;
      font-size: 12px;
      max-height: 150px;
      overflow-y: auto;
      background: rgba(0,0,0,0.4);
      padding: 10px;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>🚀 Scraping Panel</h1>

  @if(session('success'))
    <div class="status">{{ session('success') }}</div>
  @endif

  <form id="scrapeForm" action="{{ route('scrape') }}" method="POST">
    @csrf
    <button type="submit">Scrapingni boshlash</button>
  </form>

  <div class="loader" id="loader">⏳ Scraping ketmoqda...</div>

  @if(session('output'))
    <div class="output">
      <pre>{{ session('output') }}</pre>
    </div>
  @endif
</div>

<script>
  const form = document.getElementById('scrapeForm');
  const loader = document.getElementById('loader');

  form.addEventListener('submit', () => {
    loader.style.display = 'block';
  });
</script>

</body>
</html>