<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurantName }} - QR Print Design</title>
    <style>
        :root {
            --paper-width: 148mm;
            --paper-height: 210mm;
            --ink: #1f2937;
            --muted: #6b7280;
            --panel: #ffffff;
            --frame: #e7e1d3;
            --accent: #b18a4a;
            --bg: #f5f2ea;
        }

        * { box-sizing: border-box; }

        @page {
            size: A5 portrait;
            margin: 0;
        }

        body {
            margin: 0;
            font-family: "DejaVu Sans", "Segoe UI", Tahoma, Arial, sans-serif;
            background: #e8e2d3;
            color: var(--ink);
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .sheet {
            width: var(--paper-width);
            height: var(--paper-height);
            background: linear-gradient(150deg, #fcfaf5, var(--bg));
            padding: 12mm;
            border-radius: 10mm;
            border: 1px solid #d9cfbe;
            box-shadow: 0 20px 60px rgba(47, 41, 29, 0.18);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card {
            background: var(--panel);
            border: 1.5px solid var(--frame);
            border-radius: 8mm;
            padding: 8mm;
            text-align: center;
            display: grid;
            gap: 5mm;
            justify-items: center;
        }

        .logo {
            width: 28mm;
            height: 28mm;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #e2d8c3;
            padding: 1.5mm;
            background: #fff;
        }

        .name {
            margin: 0;
            font-size: 22px;
            line-height: 1.25;
            font-weight: 700;
            letter-spacing: 0.01em;
            max-width: 95%;
            word-break: break-word;
        }

        .cta {
            margin: 0;
            font-size: 17px;
            font-weight: 700;
            color: #6d5130;
        }

        .qr-wrap {
            width: 78mm;
            height: 78mm;
            padding: 5mm;
            border-radius: 6mm;
            background: #fff;
            border: 2px solid #ece5d7;
            box-shadow: inset 0 0 0 1px #f8f4ec;
            display: grid;
            place-items: center;
        }

        .qr {
            width: 100%;
            height: 100%;
            image-rendering: crisp-edges;
            image-rendering: pixelated;
        }

        .helper {
            margin: 0;
            font-size: 12px;
            color: var(--muted);
            letter-spacing: 0.01em;
        }

        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            .sheet {
                border-radius: 0;
                box-shadow: none;
                border: 0;
                width: 148mm;
                height: 210mm;
            }
        }
    </style>
</head>
<body>
    <main class="sheet">
        <section class="card">
            @if($logoDataUri)
                <img src="{{ $logoDataUri }}" alt="Restaurant logo" class="logo">
            @endif

            <h1 class="name">{{ $restaurantName }}</h1>
            <p class="cta">{{ $ctaText }}</p>

            <div class="qr-wrap" aria-label="Menu QR code">
                <img src="{{ $qrDataUri }}" alt="Menu QR" class="qr">
            </div>

            <p class="helper">{{ $helperText }}</p>
        </section>
    </main>
</body>
</html>
