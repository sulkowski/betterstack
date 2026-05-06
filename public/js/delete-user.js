(() => {
	const dialog = document.querySelector('#delete-user-dialog');
	if (!dialog) return;

	const form = dialog.querySelector('#delete-user-form');
	if (!form) return;

	const submitButton = dialog.querySelector('button[form="delete-user-form"]');
	const formError = dialog.querySelector('#delete-user-form-error');
	const message = dialog.querySelector('#delete-user-dialog-message');
	const idInput = form.querySelector('input[name="id"]');

	const clearDeleteError = () => {
		if (!formError) return;
		formError.classList.add('hidden');
		formError.textContent = '';
	};

	const setDeleteError = (errorMessage) => {
		if (!formError) return;
		formError.textContent = errorMessage;
		formError.classList.remove('hidden');
	};

	const setDeleteSubmitting = (isSubmitting) => {
		if (!submitButton) return;
		submitButton.disabled = isSubmitting;
		submitButton.classList.toggle('opacity-70', isSubmitting);
		submitButton.classList.toggle('cursor-not-allowed', isSubmitting);
		submitButton.textContent = isSubmitting ? 'Removing...' : 'Remove';
	};

	document.querySelectorAll('[data-delete-user-id][data-delete-user-name]').forEach((trigger) => {
		trigger.addEventListener('click', () => {
			const userId = trigger.getAttribute('data-delete-user-id') || '';
			const userName = trigger.getAttribute('data-delete-user-name') || '';

			if (idInput) {
				idInput.value = userId;
			}
			if (message) {
				message.textContent = userName !== '' ? `"${userName}"` : 'this user';
			}
			clearDeleteError();
		});
	});

	form.addEventListener('submit', async (event) => {
		event.preventDefault();
		clearDeleteError();
		setDeleteSubmitting(true);

		try {
			const params = new URLSearchParams();
			params.set('id', idInput ? idInput.value : '');

			const response = await fetch(form.action, {
				method: 'DELETE',
				body: params,
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
				},
			});

			if (response.ok) {
				let payload = null;
				try {
					payload = await response.json();
				} catch (jsonError) {
					window.location.reload();
					return;
				}

				if (payload && payload.location) {
					window.location.href = new URL(payload.location, window.location.href).href;
				} else {
					window.location.reload();
				}
				return;
			}

			let payload = null;
			try {
				payload = await response.json();
			} catch (jsonError) {
				setDeleteError('Something went wrong. Please try again.');
				return;
			}

			setDeleteError(payload && payload.message ? payload.message : 'Something went wrong. Please try again.');
		} catch (error) {
			setDeleteError('Network error. Please check your connection and try again.');
		} finally {
			setDeleteSubmitting(false);
		}
	});
})();
