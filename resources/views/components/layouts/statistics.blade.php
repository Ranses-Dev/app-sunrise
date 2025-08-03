<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset=" UTF-8">
    <title>{{ $title ?? 'Statistics' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="  text-gray-900">
    <div class="flex items-center w-full">
        <span class="text-base font-semibold text-gray-900 bg-white pr-3">
            {{ $title ?? 'Statistics' }}
        </span>
        <div class="flex-1 border-t border-gray-300"></div>
    </div>
    {{ $slot }}
    @livewireScripts
</body>

</html>
<style>
    .table-container {
        margin-top: 1rem;
        overflow-x: auto;
        background: #fff;
        padding: 1rem;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.5rem;
        color: #374151;
    }

    .table-custom th,
    .table-custom td {
        padding: 0.5rem 0.5rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    .table-custom th {
        background: #f9fafb;
        font-weight: 600;
        color: #1f2937;
        text-transform: uppercase;
        font-size: 0.50rem;
        letter-spacing: 0.05em;
    }

    .table-custom tbody tr:hover {
        background: #f3f4f6;
    }

    .table-custom tbody tr:nth-child(even) {
        background: #fafafa;
    }

    .table-custom td:first-child {
        font-weight: 500;
        color: #111827;
    }

    .footer-container {
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0.25rem;
        border-top: 1px solid #e5e7eb;
        font-size: 0.25rem;
        color: #374151;
    }

    .footer-logo {
        width: 60px;
        margin-right: 1rem;
    }

    .footer-text {
        line-height: 1.4;
    }

    @media (max-width: 768px) {

        .table-custom,
        .table-custom thead,
        .table-custom tbody,
        .table-custom th,
        .table-custom td,
        .table-custom tr {
            display: block;
        }

        .table-custom thead {
            display: none;
        }

        .table-custom tr {
            margin-bottom: 0.8rem;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            background: #fff;
            border: 1px solid #e5e7eb;
        }

        .table-custom td {
            border: none;
            padding: 0.6rem 0.9rem;
            position: relative;
        }

        .table-custom td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #6b7280;
            display: block;
            margin-bottom: 0.2rem;
        }

        .footer-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .footer-logo {
            margin-bottom: 0.5rem;
        }
    }
</style>
