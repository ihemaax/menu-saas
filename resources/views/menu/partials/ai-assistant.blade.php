@php
    $availableCategories = $categories
        ->filter(fn ($category) => $category->products->count())
        ->values();

    $menuText = mb_strtolower($availableCategories->map(function ($category) {
        return trim(($category->name_ar ?? '').' '.($category->name_en ?? '').' '.$category->products->pluck('name')->implode(' '));
    })->implode(' '));

    $isSalonMenu = str($menuText)->contains([
        'صالون', 'حلاق', 'حلاقة', 'شعر', 'دقن', 'لحية', 'قص', 'صبغة', 'بشرة', 'ماسك', 'تنظيف', 'مانيكير', 'باديكير',
        'salon', 'barber', 'hair', 'beard', 'facial', 'nails',
    ]);

    $isFoodMenu = str($menuText)->contains([
        'مطعم', 'كافيه', 'قهوة', 'مشروب', 'مشروبات', 'عصير', 'اكل', 'أكل', 'وجبة', 'وجبات', 'بيتزا', 'برجر', 'ساندوتش',
        'حلويات', 'ساقع', 'بارد', 'ساخن', 'coffee', 'drink', 'burger', 'pizza', 'dessert', 'food',
    ]);

    $assistantChips = collect();

    if ($isSalonMenu) {
        $assistantChips = $assistantChips->merge([
            'أنسب خدمة للشعر؟',
            'رشحلي خدمة سريعة',
            'إيه المناسب للعناية؟',
            'خدمة بسعر أقل',
        ]);
    } elseif ($isFoodMenu) {
        $assistantChips = $assistantChips->merge([
            'رشحلي حاجة حلوة',
            'عايز حاجة ساقعة',
            'حاجة تحت سعر مناسب',
            'إيه الأكثر طلبًا؟',
        ]);
    } else {
        $assistantChips = $assistantChips->merge([
            'رشحلي اختيار مناسب',
            'إيه الأكثر طلبًا؟',
            'اختيار بسعر أقل',
        ]);
    }

    $categoryChips = $availableCategories
        ->take(3)
        ->map(fn ($category) => 'رشحلي من '.$category->name_ar);

    $assistantChips = $categoryChips
        ->merge($assistantChips)
        ->push('مش عارف أختار إيه')
        ->unique()
        ->take(7)
        ->values();
@endphp

<style>
    .osx-ai-assistant{position:fixed;inset:0;z-index:1200;font-family:'Cairo',system-ui,sans-serif;direction:rtl;pointer-events:none}
    .osx-ai-scrim{position:fixed;inset:0;display:none;background:rgba(8,10,13,.22);backdrop-filter:blur(2px);pointer-events:auto}
    .osx-ai-assistant.is-open .osx-ai-scrim{display:block}
    .osx-ai-toggle{position:fixed;inset-inline-end:18px;bottom:calc(92px + env(safe-area-inset-bottom,0px));width:58px;height:58px;display:inline-grid;place-items:center;border:1px solid rgba(255,255,255,.26);border-radius:50%;background:#111315;color:#f4d78a;padding:0;box-shadow:0 18px 42px rgba(0,0,0,.32),0 0 0 1px rgba(244,215,138,.14) inset;cursor:pointer;pointer-events:auto}
    .osx-ai-toggle::after{content:"";position:absolute;inset:7px;border-radius:50%;border:1px solid rgba(244,215,138,.22)}
    .osx-ai-toggle svg{position:relative;z-index:1;width:31px;height:31px;display:block}
    .osx-ai-assistant.is-open .osx-ai-toggle{display:none}
    .osx-ai-sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap}
    .osx-ai-panel{position:fixed;inset-inline-end:18px;bottom:calc(162px + env(safe-area-inset-bottom,0px));width:min(390px,calc(100vw - 32px));max-height:min(640px,calc(100vh - 190px));display:none;overflow:hidden;border:1px solid rgba(17,24,39,.12);border-radius:18px;background:#ffffff;color:#111827;box-shadow:0 26px 70px rgba(0,0,0,.28);pointer-events:auto}
    .osx-ai-assistant.is-open .osx-ai-panel{display:block}
    .osx-ai-head{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 14px 12px;border-bottom:1px solid #eef0f2;background:#111315;color:#fff}
    .osx-ai-brand{display:flex;align-items:center;gap:10px;min-width:0}
    .osx-ai-mark{width:36px;height:36px;display:grid;place-items:center;border-radius:12px;background:#202326;color:#f4d78a;border:1px solid rgba(244,215,138,.2);flex:0 0 auto}
    .osx-ai-mark svg{width:22px;height:22px}
    .osx-ai-title{margin:0;font-size:1rem;font-weight:900;line-height:1.35}
    .osx-ai-subtitle{display:block;margin-top:1px;color:#c7cbd1;font-size:.72rem;font-weight:800}
    .osx-ai-close{width:34px;height:34px;flex:0 0 auto;border:1px solid rgba(255,255,255,.12);border-radius:10px;background:rgba(255,255,255,.08);color:#fff;font-size:1.2rem;line-height:1;cursor:pointer}
    .osx-ai-body{display:grid;gap:12px;padding:14px;max-height:calc(min(640px,100vh - 190px) - 63px);overflow:auto;background:linear-gradient(180deg,#fff,#fafafa)}
    .osx-ai-reply{display:none;border:1px solid #e7e9ed;border-radius:12px;background:#f8fafc;padding:11px 12px;color:#20242b;font-size:.88rem;font-weight:800;line-height:1.75}
    .osx-ai-error{display:none;border:1px solid #fecaca;border-radius:12px;background:#fff1f1;padding:10px 12px;color:#991b1b;font-size:.84rem;font-weight:900;line-height:1.6}
    .osx-ai-chips{display:flex;gap:8px;overflow-x:auto;padding-bottom:2px;scrollbar-width:none}
    .osx-ai-chips::-webkit-scrollbar{display:none}
    .osx-ai-chip{flex:0 0 auto;border:1px solid #e3e6ea;border-radius:999px;background:#fff;color:#2f3742;padding:8px 11px;font:900 .75rem 'Cairo',system-ui,sans-serif;cursor:pointer}
    .osx-ai-chip:hover{border-color:#111315;background:#f5f6f7}
    .osx-ai-chip:disabled{opacity:.58;cursor:wait}
    .osx-ai-form{display:grid;grid-template-columns:minmax(0,1fr) 48px;gap:8px;border:1px solid #e1e5ea;border-radius:16px;background:#fff;padding:6px}
    .osx-ai-input{min-width:0;border:0;border-radius:12px;background:transparent;padding:9px 8px;color:#111827;font:800 16px 'Cairo',system-ui,sans-serif;outline:none}
    .osx-ai-send{display:grid;place-items:center;border:0;border-radius:12px;background:#111315;color:#fff;font:900 .82rem 'Cairo',system-ui,sans-serif;cursor:pointer}
    .osx-ai-send svg{width:18px;height:18px}
    .osx-ai-send:disabled{opacity:.6;cursor:wait}
    .osx-ai-assistant.is-loading .osx-ai-reply{display:block;background:linear-gradient(90deg,#f8fafc 0%,#eef1f5 45%,#f8fafc 100%);background-size:220% 100%;animation:osx-ai-loading 1.1s ease-in-out infinite}
    @keyframes osx-ai-loading{0%{background-position:100% 0}100%{background-position:-100% 0}}
    .osx-ai-products{display:grid;gap:8px}
    .osx-ai-product{display:grid;grid-template-columns:54px minmax(0,1fr);gap:10px;align-items:center;text-decoration:none;border:1px solid #e7e9ed;border-radius:12px;background:#fff;color:#111827;padding:8px;transition:.18s ease}
    .osx-ai-product:hover{border-color:#111315;transform:translateY(-1px)}
    .osx-ai-product img{width:54px;height:54px;border-radius:10px;object-fit:cover;background:#f1f3f5}
    .osx-ai-product-name{display:block;font-size:.82rem;font-weight:900;line-height:1.45}
    .osx-ai-product-meta{display:block;margin-top:2px;color:#667085;font-size:.72rem;font-weight:800}
    @media (max-width:640px){
        .osx-ai-toggle{inset-inline-end:16px;bottom:calc(92px + env(safe-area-inset-bottom,0px));width:56px;height:56px}
        .osx-ai-panel{inset-inline:10px;bottom:calc(82px + env(safe-area-inset-bottom,0px));width:auto;max-height:min(72vh,620px);border-radius:20px}
        .osx-ai-body{max-height:calc(min(72vh,620px) - 63px)}
    }
</style>

<div class="osx-ai-assistant" data-osx-ai>
    <div class="osx-ai-scrim" data-osx-ai-scrim></div>
    <div class="osx-ai-panel" role="dialog" aria-label="اسأل Osirix">
        <div class="osx-ai-head">
            <div class="osx-ai-brand">
                <span class="osx-ai-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="6.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M12 2.8c2.9 2.1 4.35 5.15 4.35 9.2S14.9 19.1 12 21.2C9.1 19.1 7.65 16.05 7.65 12S9.1 4.9 12 2.8Z" stroke="currentColor" stroke-width="1.4"/>
                        <path d="M4.2 8.6h15.6M4.2 15.4h15.6" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                    </svg>
                </span>
                <div>
                    <h2 class="osx-ai-title">محتاج ترشيح؟</h2>
                    <span class="osx-ai-subtitle">قولّي بتحب إيه وأنا أظبطلك اختيار حلو</span>
                </div>
            </div>
            <button type="button" class="osx-ai-close" data-osx-ai-close aria-label="إغلاق">×</button>
        </div>
        <div class="osx-ai-body">
            <div class="osx-ai-reply" data-osx-ai-reply></div>
            <div class="osx-ai-error" data-osx-ai-error></div>
            <div class="osx-ai-products" data-osx-ai-products></div>
            <div class="osx-ai-chips">
                @foreach($assistantChips as $chip)
                    <button type="button" class="osx-ai-chip" data-osx-ai-chip>{{ $chip }}</button>
                @endforeach
            </div>
            <form class="osx-ai-form" data-osx-ai-form>
                <input class="osx-ai-input" name="question" maxlength="500" autocomplete="off" placeholder="اكتب سؤالك هنا..." data-osx-ai-input>
                <button type="submit" class="osx-ai-send" data-osx-ai-send aria-label="إرسال">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h13M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    <button type="button" class="osx-ai-toggle" data-osx-ai-toggle aria-label="اسأل Osirix">
        <span class="osx-ai-sr">اسأل Osirix</span>
        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
            <circle cx="12" cy="12" r="6.4" stroke="currentColor" stroke-width="1.8"/>
            <path d="M12 2.75c3.05 2.22 4.58 5.3 4.58 9.25S15.05 19.03 12 21.25C8.95 19.03 7.42 15.95 7.42 12S8.95 4.97 12 2.75Z" stroke="currentColor" stroke-width="1.45"/>
            <path d="M4 8.65h16M4 15.35h16" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"/>
        </svg>
    </button>
</div>

<script>
    (() => {
        const root = document.querySelector('[data-osx-ai]');
        if (!root) return;

        const endpoint = @json(route('menu.ai.ask', ['slug' => $menuSetting->slug]));
        const token = @json(csrf_token());
        const scrim = root.querySelector('[data-osx-ai-scrim]');
        const toggle = root.querySelector('[data-osx-ai-toggle]');
        const close = root.querySelector('[data-osx-ai-close]');
        const form = root.querySelector('[data-osx-ai-form]');
        const input = root.querySelector('[data-osx-ai-input]');
        const send = root.querySelector('[data-osx-ai-send]');
        const reply = root.querySelector('[data-osx-ai-reply]');
        const error = root.querySelector('[data-osx-ai-error]');
        const products = root.querySelector('[data-osx-ai-products]');
        const chips = Array.from(root.querySelectorAll('[data-osx-ai-chip]'));

        const focusComposer = () => {
            window.setTimeout(() => {
                form.scrollIntoView({ behavior: 'smooth', block: 'end' });
                input.focus();
            }, 80);
        };

        const setOpen = (open) => {
            root.classList.toggle('is-open', open);
            if (open) focusComposer();
        };

        const showError = (message) => {
            error.textContent = message;
            error.style.display = 'block';
        };

        const clearResults = () => {
            reply.style.display = 'none';
            error.style.display = 'none';
            products.innerHTML = '';
        };

        const renderProducts = (items) => {
            products.innerHTML = '';
            items.forEach((item) => {
                const card = document.createElement('a');
                card.className = 'osx-ai-product';
                card.href = `#osirix-product-${item.id}`;
                card.addEventListener('click', () => {
                    const target = document.getElementById(`osirix-product-${item.id}`);
                    if (!target) return;
                    setOpen(false);
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });

                const img = document.createElement('img');
                img.alt = item.name || '';
                img.src = item.image || 'https://via.placeholder.com/160x160?text=Osirix';

                const body = document.createElement('span');
                const name = document.createElement('span');
                name.className = 'osx-ai-product-name';
                name.textContent = item.name || '';
                const meta = document.createElement('span');
                meta.className = 'osx-ai-product-meta';
                meta.textContent = `${item.category || 'القائمة'} · ${item.price} ج.م`;

                body.append(name, meta);
                card.append(img, body);
                products.appendChild(card);
            });
        };

        toggle.addEventListener('click', () => setOpen(!root.classList.contains('is-open')));
        close.addEventListener('click', () => setOpen(false));
        scrim.addEventListener('click', () => setOpen(false));
        document.addEventListener('click', (event) => {
            if (!root.classList.contains('is-open') || root.contains(event.target)) {
                return;
            }

            setOpen(false);
        });

        root.querySelectorAll('[data-osx-ai-chip]').forEach((chip) => {
            chip.addEventListener('click', () => {
                input.value = chip.textContent.trim();
                form.requestSubmit();
            });
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const question = input.value.trim();
            if (!question) {
                showError('اكتب سؤال بسيط الأول.');
                focusComposer();
                return;
            }

            input.value = '';
            clearResults();
            root.classList.add('is-loading');
            reply.textContent = 'ثواني بس، هشوفلك اختيار يليق بذوقك...';
            reply.style.display = 'block';
            focusComposer();
            send.disabled = true;
            chips.forEach((chip) => chip.disabled = true);

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ question }),
                });

                const data = await response.json();

                if (!response.ok || !data.ok) {
                    showError(data.message || 'المساعد غير متاح حاليًا، جرّب بعد قليل.');
                    return;
                }

                reply.textContent = data.reply || '';
                reply.style.display = data.reply ? 'block' : 'none';
                renderProducts(data.recommended_products || []);
                focusComposer();
            } catch (e) {
                showError('المساعد غير متاح حاليًا، جرّب بعد قليل.');
                focusComposer();
            } finally {
                root.classList.remove('is-loading');
                send.disabled = false;
                chips.forEach((chip) => chip.disabled = false);
            }
        });
    })();
</script>
