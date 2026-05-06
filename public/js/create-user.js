(() => {
	const dialog = document.querySelector('#create-user-dialog');
	if (!dialog) return;

	const form = dialog.querySelector('#create-user-form');
	if (!form) return;

	const submitButton = dialog.querySelector('button[form="create-user-form"]');
	const formError = form.querySelector('#create-user-form-error');
	const validationErrors = {};

	form.querySelectorAll('[data-error-for]').forEach((element) => {
		validationErrors[element.getAttribute('data-error-for')] = element;
	});

	const redirectFromLocationHeader = (response) => {
		const location = response.headers.get('Location') ?? response.headers.get('location');
		if (location) {
			window.location.href = new URL(location, window.location.href).href;
		} else {
			window.location.reload();
		}
	};

	const clearErrors = () => {
		if (formError) {
			formError.classList.add('hidden');
			formError.textContent = '';
		}

		Object.values(validationErrors).forEach((element) => {
			element.classList.add('hidden');
			element.textContent = '';
		});

		['name', 'email', 'city', 'phone'].forEach((fieldName) => {
			const field = form.elements[fieldName];
			if (!field) return;
			field.classList.remove('ring-red-300', 'focus:ring-red-500');
			field.classList.add('ring-slate-300', 'focus:ring-indigo-500');
			field.removeAttribute('aria-invalid');
		});
	};

	const showFormError = (message) => {
		if (!formError) return;
		formError.textContent = message;
		formError.classList.remove('hidden');
	};

	const setFieldError = (fieldName, message) => {
		const fieldError = validationErrors[fieldName];
		const field = form.elements[fieldName];
		if (fieldError) {
			fieldError.textContent = message;
			fieldError.classList.remove('hidden');
		}
		if (field) {
			field.classList.remove('ring-slate-300', 'focus:ring-indigo-500');
			field.classList.add('ring-red-300', 'focus:ring-red-500');
			field.setAttribute('aria-invalid', 'true');
		}
	};

	const setSubmitting = (isSubmitting) => {
		if (!submitButton) return;
		submitButton.disabled = isSubmitting;
		submitButton.classList.toggle('opacity-70', isSubmitting);
		submitButton.classList.toggle('cursor-not-allowed', isSubmitting);
		submitButton.textContent = isSubmitting ? 'Creating...' : 'Create User';
	};

	form.addEventListener('submit', async (event) => {
		event.preventDefault();
		clearErrors();
		setSubmitting(true);

		try {
			const response = await fetch(form.action, {
				method: 'POST',
				body: new FormData(form),
				headers: {
					'X-Requested-With': 'XMLHttpRequest',
				},
				redirect: 'manual',
			});

			if (response.ok) {
				redirectFromLocationHeader(response);
				return;
			}

			let payload = null;
			try {
				payload = await response.json();
			} catch (jsonError) {
				showFormError('Something went wrong. Please try again.');
				return;
			}

			if (response.status === 422 && payload && payload.errors) {
				Object.entries(payload.errors).forEach(([fieldName, message]) => {
					setFieldError(fieldName, message);
				});
				return;
			}

			showFormError(payload && payload.message ? payload.message : 'Something went wrong. Please try again.');
		} catch (error) {
			showFormError('Network error. Please check your connection and try again.');
		} finally {
			setSubmitting(false);
		}
	});
})();
