<footer class="app-footer" role="contentinfo">
    <div class="app-footer__inner" itemscope itemtype="https://schema.org/Organization">
        <div class="app-footer__brand">

            <strong class="app-footer__name" itemprop="name">Sunshine for All</strong>
        </div>

        <address class="app-footer__address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <span itemprop="streetAddress">1407 SW 22nd Street</span><br>
            <span itemprop="addressLocality">Miami</span>,
            <span itemprop="addressRegion">Florida</span>
            <span itemprop="postalCode">33145</span>
        </address>

        <div class="app-footer__contact">
            <a class="app-footer__tel" href="tel:+13052853217" itemprop="telephone">P: 305-285-3217 ext. 203</a>
        </div>
    </div>
    <img src="{{ $logo }}" alt="Sunshine for All" class="w-20" />
</footer>

<style>
    :root {
        --footer-bg: #fbfbfb;
        --footer-fg: #374151;
        /* gray-700 */
        --footer-accent: #2563eb;
        /* blue-600 */
        --footer-border: #e5e7eb;
        /* gray-200 */
    }

    .app-footer {
        position: fixed;
        /* fijo para impresión/PDF */
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--footer-bg);
        border-top: 1px solid var(--footer-border);
        font: 13px/1.4 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        color: var(--footer-fg);
        padding: 12px 16px;
    }

    .app-footer__inner {
        max-width: 880px;
        margin: 0 auto;
        text-align: center;
    }

    .app-footer__brand {
        margin-bottom: 2px;
    }

    .app-footer__name {
        font-size: 15px;
        letter-spacing: .5px;
        font-variant-caps: small-caps;
    }

    .app-footer__logo {
        height: 18px;
        vertical-align: middle;
        margin-right: 8px;
    }

    .app-footer__address {
        margin: 2px 0;
        font-style: normal;
    }

    .app-footer__contact {
        margin-top: 2px;
    }

    .app-footer__tel {
        color: var(--footer-accent);
        text-decoration: none;
        font-weight: 600;
    }

    .app-footer__tel:hover {
        text-decoration: underline;
    }

    /* Mejoras para impresión: menos margen inferior del body
     para que el contenido no tape el footer fijo */
    @media print {
        body {
            margin-bottom: 60px;
        }

        .app-footer {
            background: white;
            border-top-color: #d1d5db;
            /* gray-300 */
            padding: 10px 14px;
        }
    }
</style>
