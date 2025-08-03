<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Recovery Codes</title>

    {{-- Estilo embebido para compatibilidad máxima con correos --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            padding: 2rem;
            line-height: 1.5;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }

        h2 {
            font-size: 18px;
            font-weight: 600;
            margin-top: 1.5rem;
            color: #1e3a8a;
        }

        ul {
            padding-left: 1.2rem;
            margin-top: 0.5rem;
        }

        li {
            margin-bottom: 4px;
            font-family: monospace;
        }

        p {
            margin-top: 1.5rem;
            font-size: 16px;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hello {{ $user->name }},</h1>

        <p>Here are your recovery codes for two-factor authentication:</p>

        @if (!empty($codesApp))
            <h2>Application Codes</h2>
            <ul>
                @foreach ($codesApp as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        @endif

        @if (!empty($codesAdmin))
            <h2>Admin Codes</h2>
            <ul>
                @foreach ($codesAdmin as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        @endif

        <p>Please store these codes in a safe place. Each code can be used only once.</p>
    </div>
</body>

</html>
