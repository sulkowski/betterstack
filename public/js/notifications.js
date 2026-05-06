(() => {
	const DEFAULT_FLASH_DURATION_MS = 10 * 1000;
	const flashes = document.querySelectorAll('[data-flash]');

	if (!flashes.length) {
		return;
	}

	flashes.forEach((flash) => {
		let timeoutId = null;

		const removeFlash = () => {
			if (timeoutId !== null) {
				clearTimeout(timeoutId);
				timeoutId = null;
			}
			flash.remove();
		};

		const startTimer = () => {
			if (timeoutId !== null) {
				return;
			}
			timeoutId = window.setTimeout(removeFlash, DEFAULT_FLASH_DURATION_MS);
		};

		const pauseTimer = () => {
			if (timeoutId === null) {
				return;
			}
			clearTimeout(timeoutId);
			timeoutId = null;
		};

		const restartTimer = () => {
			pauseTimer();
			startTimer();
		};

		const dismissButton = flash.querySelector('[data-flash-dismiss]');
		if (dismissButton) {
			dismissButton.addEventListener('click', removeFlash);
		}

		flash.addEventListener('mouseenter', pauseTimer);
		flash.addEventListener('mouseleave', restartTimer);
		flash.addEventListener('focusin', pauseTimer);
		flash.addEventListener('focusout', restartTimer);

		startTimer();
	});
})();
