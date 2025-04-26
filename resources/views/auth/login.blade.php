<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | ScanBrew Cafe</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Background polka-dot splash with slow movement */
    .bg-splash {
      background-color: #FEF9C3; /* yellow-100 */
      background-image: repeating-radial-gradient(
        circle at 0 0,
        #FDE68A 0,
        #FDE68A 1px,
        transparent 1px,
        transparent 10px
      );
      background-size: 40px 40px;
      animation: moveDots 30s linear infinite;
    }
    @keyframes moveDots {
      from { background-position: 0 0; }
      to   { background-position: 100px 100px; }
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-splash">

  <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8">
    <!-- Logo & Title -->
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/scanbrewcafe.png') }}"
           alt="Logo ScanBrew Cafe"
           class="h-16 w-auto mb-4" />
      <h1 class="text-2xl font-bold">
        <span class="text-gray-800">ScanBrew</span>
        <span class="text-yellow-500">Cafe</span>
      </h1>
    </div>

    @if ($errors->any())
      <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded mb-6">
        <ul class="list-disc list-inside text-sm space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Email Field -->
      <div class="relative">
        <input
          type="email"
          name="email"
          id="email"
          required
          placeholder=" "
          class="peer w-full border-b-2 border-gray-300 focus:border-yellow-400 bg-transparent py-2 outline-none transition"
        />
        <label for="email"
               class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all
                      peer-placeholder-shown:top-2 peer-placeholder-shown:text-base
                      peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-yellow-500">
          Email
        </label>
        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
          <!-- Envelope Icon -->
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5 text-yellow-400"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 8l7.5 5L21 8m0 8V8a2 2 0 00-2-2H5a2 2 0
                     00-2 2v8a2 2 0 002 2h14a2 2 0 002-2z" />
          </svg>
        </span>
      </div>

      <!-- Password Field -->
      <div class="relative">
        <input
          type="password"
          name="password"
          id="password"
          required
          placeholder=" "
          class="peer w-full border-b-2 border-gray-300 focus:border-yellow-400 bg-transparent py-2 outline-none transition"
        />
        <label for="password"
               class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all
                      peer-placeholder-shown:top-2 peer-placeholder-shown:text-base
                      peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-yellow-500">
          Kata Sandi
        </label>
        <button type="button"
                id="togglePassword"
                class="absolute inset-y-0 right-0 flex items-center pr-3 focus:outline-none">
          <svg id="eyeClosed"
               xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5 text-yellow-400"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 12s4-8 9-8 9 8 9 8-4 8-9 8-9-8-9-8z" />
            <circle cx="12"
                    cy="12"
                    r="3"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2" />
          </svg>
          <svg id="eyeOpen"
               xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5 text-yellow-400 hidden"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 3l18 18" />
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M10.59 10.59A3 3 0 0013.41 13.41" />
          </svg>
        </button>
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="relative overflow-hidden group w-full py-3
               bg-yellow-400 hover:bg-yellow-500 text-white
               font-medium rounded-lg transition">
        <span class="absolute top-0 left-0 w-0 h-0 bg-white opacity-30
                     rounded-full transform group-hover:w-64 group-hover:h-64
                     group-hover:-translate-x-32 group-hover:-translate-y-32
                     transition-all duration-500"></span>
        <div class="relative flex items-center justify-center space-x-2">
          <svg xmlns="http://www.w3.org/2000/svg"
               class="h-5 w-5"
               fill="none"
               viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12H3m0 0l4-4m-4 4l4 4m13 4V8a2 2 0
                     00-2-2h-4" />
          </svg>
          <span>Masuk</span>
        </div>
      </button>
    </form>
  </div>

  <script>
    const toggle = document.getElementById('togglePassword');
    const pwdField = document.getElementById('password');
    const eyeO = document.getElementById('eyeOpen');
    const eyeC = document.getElementById('eyeClosed');
    toggle.addEventListener('click', () => {
      const type = pwdField.type === 'password' ? 'text' : 'password';
      pwdField.type = type;
      eyeO.classList.toggle('hidden');
      eyeC.classList.toggle('hidden');
    });
  </script>
</body>
</html>
