(() => {
	const dialog = document.querySelector('#create-user-dialog');
	if (!dialog) return;

	const form = dialog.querySelector('#create-user-form');
	if (!form) return;

	const submitButton = dialog.querySelector('button[form="create-user-form"]');
	const formError = form.querySelector('#create-user-form-error');
	const usersTableBody = document.querySelector('#users-table-body');
	const userRowTemplate = document.querySelector('#user-row-template');
	const totalUsersCount = document.querySelector('#total-users-count');
	const validationErrors = {};

	form.querySelectorAll('[data-error-for]').forEach((element) => {
		validationErrors[element.getAttribute('data-error-for')] = element;
	});

	const clearErrors = () => {
		if (formError) {
			formError.classList.add('hidden');
			formError.textContent = '';
		}

		Object.values(validationErrors).forEach((element) => {
			element.classList.add('hidden');
			element.textContent = '';
		});

		['name', 'email', 'city'].forEach((fieldName) => {
			const field = form.elements[fieldName];
			if (!field) return;
			field.classList.remove('ring-red-300', 'focus:ring-red-500');
			field.classList.add('ring-slate-300', 'focus:ring-indigo-500');
			field.removeAttribute('aria-invalid');
		});
	};

	const showGlobalError = (message) => {
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
		if (submitButton) {
			submitButton.disabled = isSubmitting;
			submitButton.classList.toggle('opacity-70', isSubmitting);
			submitButton.classList.toggle('cursor-not-allowed', isSubmitting);
			submitButton.textContent = isSubmitting ? 'Creating...' : 'Create User';
		}
	};

	const appendUser = (user) => {
		const rowFragment = userRowTemplate.content.cloneNode(true);
		const rowElement = rowFragment.querySelector('tr');

		const nameCell = rowElement.querySelector('[data-field="name"]');
		const emailCell = rowElement.querySelector('[data-field="email"]');
		const cityCell = rowElement.querySelector('[data-field="city"]');

		nameCell.textContent = user.name || '';
		emailCell.textContent = user.email || '';
		cityCell.textContent = user.city || '';

		usersTableBody.appendChild(rowFragment);
	};

	const updateTotalUsersCount = (totalUsers) => {
		totalUsersCount.dataset.count = String(totalUsers);
		totalUsersCount.textContent = String(totalUsers);
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
					'X-Requested-With': 'XMLHttpRequest'
				}
			});

			let payload = null;
			try {
				payload = await response.json();
			} catch (jsonError) {
				showGlobalError('Something went wrong. Please try again.');
				return;
			}

			if (response.status === 422 && payload && payload.errors) {
				Object.entries(payload.errors).forEach(([fieldName, message]) => {
					setFieldError(fieldName, message);
				});
				return;
			}

			if (!response.ok) {
				showGlobalError((payload && payload.message) ? payload.message : 'Something went wrong. Please try again.');
				return;
			}

			// Update only the affected UI parts instead of reloading the whole page.
			const user = payload && payload.user;
			const totalUsers = payload && payload.totalUsers;
			if (user) {
				appendUser(user);
				updateTotalUsersCount(totalUsers);
				form.reset();
				clearErrors();
				dialog.close?.();
				return;
			}

			// Fallback for empty-state pages where table DOM isn't present yet.
			window.location.reload();
		} catch (error) {
			showGlobalError('Network error. Please check your connection and try again.');
		} finally {
			setSubmitting(false);
		}
	});
})();
