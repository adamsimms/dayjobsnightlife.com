import domReady from '@roots/sage/client/dom-ready';

domReady(async () => {
  const searchButton = document.querySelector('.btn-search');
  const searchPanel = document.getElementById('site-search');

  if (!searchButton || !searchPanel) {
    return;
  }

  searchButton.addEventListener('click', () => {
    const isOpen = !searchPanel.hidden;
    searchPanel.hidden = isOpen;
    searchButton.setAttribute('aria-expanded', String(!isOpen));

    if (!isOpen) {
      const input = searchPanel.querySelector('input[type="search"], input[type="text"]');
      input?.focus();
    }
  });
});

if (import.meta.webpackHot) {
  import.meta.webpackHot.accept(console.error);
}
