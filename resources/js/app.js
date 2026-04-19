import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('click', (event) => {
  const button = event.target.closest('[data-copy-target]');
  if (!button) return;
  const selector = button.dataset.copyTarget;
  const target = document.querySelector(selector);
  if (!target) return;

  navigator.clipboard.writeText(target.value ?? target.textContent ?? '').then(() => {
    const old = button.textContent;
    button.textContent = 'اتنسخ فعلاً';
    setTimeout(() => (button.textContent = old), 1200);
  });
});

const slugInputs = document.querySelectorAll('[data-slug-input]');
slugInputs.forEach((input) => {
  const statusEl = document.querySelector(input.dataset.slugStatus);
  const previewEl = document.querySelector(input.dataset.slugPreview);
  const sourceEl = document.querySelector(input.dataset.slugSource || '');
  let timer;

  const normalize = (value) =>
    value
      .trim()
      .toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');

  if (sourceEl) {
    sourceEl.addEventListener('input', () => {
      if (!input.dataset.userEdited) {
        input.value = normalize(sourceEl.value);
        input.dispatchEvent(new Event('input'));
      }
    });
  }

  input.addEventListener('input', () => {
    input.dataset.userEdited = '1';
    const slug = normalize(input.value);
    input.value = slug;

    if (previewEl) previewEl.textContent = `${window.location.origin}/menu/${slug || 'اسم-مطعمك'}`;
    if (!statusEl) return;

    clearTimeout(timer);
    if (slug.length < 3) {
      statusEl.textContent = 'اكتب 3 حروف أو أكتر.';
      statusEl.className = 'text-xs text-amber-600';
      return;
    }

    statusEl.textContent = 'لحظة ونتأكد...';
    statusEl.className = 'text-xs text-slate-500';

    timer = setTimeout(async () => {
      try {
        const response = await fetch(`/onboarding/slug-check?slug=${encodeURIComponent(slug)}`, {
          headers: { Accept: 'application/json' },
        });
        const data = await response.json();
        statusEl.textContent = data.message;
        statusEl.className = data.available ? 'text-xs text-emerald-600' : 'text-xs text-rose-600';
      } catch {
        statusEl.textContent = 'حصل مشكلة بسيطة، جرّب تاني.';
        statusEl.className = 'text-xs text-rose-600';
      }
    }, 350);
  });
});
