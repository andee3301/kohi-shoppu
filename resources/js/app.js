import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

function activateLightTheme() {
	document.documentElement.classList.remove('theme-dark');
	document.documentElement.classList.add('theme-light');
	document.body.classList.remove('bg-background');
	document.body.classList.add('bg-gradient-to-r', 'from-rose-100', 'to-teal-100');
}

function activateDarkTheme() {
	document.documentElement.classList.remove('theme-light');
	document.documentElement.classList.add('theme-dark');
	document.body.classList.remove('bg-gradient-to-r', 'from-rose-100', 'to-teal-100');
	document.body.classList.add('bg-background');
}

function setTheme(targetTheme) {
	switch (targetTheme) {
		case 'theme-dark':
			activateDarkTheme();
			break;
		case 'theme-light':
			activateLightTheme();
			break;
		case 'auto':
		default:
			if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
				activateDarkTheme();
			} else {
				activateLightTheme();
			}
			break;
	}
}

function setupThemeChangeEventListener() {
	if (!window.Livewire) {
		return;
	}

	window.Livewire.on('theme-changed', (data) => {
		setTheme(data.theme);
	});
}

function setupProductSelectionListener() {
	window.addEventListener('USER_SELECT_PRODUCT_EVENT', (event) => {
		if (!window.Livewire) {
			return;
		}

		const productId = event?.detail?.product_id;

		if (!productId) {
			return;
		}

		window.Livewire.dispatch('USER_SELECT_PRODUCT_EVENT', productId);
	});
}

setTheme(window.theme || 'auto');
setupThemeChangeEventListener();
setupProductSelectionListener();

Alpine.start();
