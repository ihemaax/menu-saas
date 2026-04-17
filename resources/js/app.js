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
    button.textContent = 'Copied';
    setTimeout(() => (button.textContent = old), 1500);
  });
});
