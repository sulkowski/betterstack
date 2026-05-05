(() => {
	const dialog = document.querySelector('#create-user-dialog');
	if (!dialog) return;

	const form = dialog.querySelector('#create-user-form');
	if (!form) return;

	const submitButton = dialog.querySelector('button[form="create-user-form"]');
	const searchForm = document.querySelector('#user-search-form');
	const searchInput = document.querySelector('#user-search-input');
	const formError = form.querySelector('#create-user-form-error');
	const usersEmptyState = document.querySelector('#users-empty-state');
	const usersTableBlock = document.querySelector('#users-table-block');
	const usersTableBody = document.querySelector('#users-table-body');
	const userRowTemplate = document.querySelector('#user-row-template');
	const usersEmptyFirstTemplate = document.querySelector('#users-empty-first-template');
	const usersEmptySearchTemplate = document.querySelector('#users-empty-search-template');
	const totalUsersCount = document.querySelector('#total-users-count');
	const usersLoadingStatus = document.querySelector('#users-loading-status');
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

	const renderEmptyState = (totalUsersForEmpty) => {
		if (!usersEmptyState) return;
		const nameFilter = searchInput ? searchInput.value.trim() : '';
		const useSearchVariant = nameFilter !== '' && totalUsersForEmpty > 0;
		const template = useSearchVariant ? usersEmptySearchTemplate : usersEmptyFirstTemplate;
		usersEmptyState.innerHTML = '';
		if (template) {
			usersEmptyState.appendChild(template.content.cloneNode(true));
		}
		usersEmptyState.classList.remove('hidden');
		if (usersTableBlock) usersTableBlock.classList.add('hidden');
	};

	const renderUsers = (users, totalUsers) => {
		updateTotalUsersCount(totalUsers);
		if (!users || users.length === 0) {
			if (usersTableBody) usersTableBody.innerHTML = '';
			renderEmptyState(totalUsers);
			return;
		}
		if (usersEmptyState) usersEmptyState.classList.add('hidden');
		if (usersTableBlock) usersTableBlock.classList.remove('hidden');
		usersTableBody.innerHTML = '';
		users.forEach((user) => appendUser(user));
	};

	const updateTotalUsersCount = (totalUsers) => {
		totalUsersCount.dataset.count = String(totalUsers);
		totalUsersCount.textContent = String(totalUsers);
	};

	const setUsersLoading = (isLoading) => {
		if (usersLoadingStatus) {
			usersLoadingStatus.classList.toggle('invisible', !isLoading);
			usersLoadingStatus.classList.toggle('opacity-0', !isLoading);
			usersLoadingStatus.classList.toggle('opacity-100', isLoading);
			usersLoadingStatus.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
			const spinner = usersLoadingStatus.querySelector('svg');
			if (spinner) {
				spinner.classList.toggle('animate-spin', isLoading);
			}
		}
		if (searchInput) {
			searchInput.disabled = isLoading;
		}
	};

	const fetchUsers = async (nameFilter) => {
		setUsersLoading(true);
		try {
			const searchParams = new URLSearchParams();
			if (nameFilter) {
				searchParams.set('name', nameFilter);
			}

			const response = await fetch(`index.php?${searchParams.toString()}`, {
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			});

			if (!response.ok) {
				throw new Error('Failed to fetch users.');
			}

			return response.json();
		} finally {
			setUsersLoading(false);
		}
	};

	const getNameFilterFromUrl = () => {
		const params = new URLSearchParams(window.location.search);
		const name = params.get('name');
		return name == null ? '' : name.trim();
	};

	const applySearchQueryToUrl = (nameFilter) => {
		const url = new URL(window.location.href);
		if (nameFilter) {
			url.searchParams.set('name', nameFilter);
		} else {
			url.searchParams.delete('name');
		}
		window.history.replaceState({}, '', url.pathname + url.search);
	};

	const refreshUsers = async () => {
		const nameFilter = getNameFilterFromUrl();
		if (searchInput) {
			searchInput.value = nameFilter;
		}
		const payload = await fetchUsers(nameFilter);
		renderUsers(payload.users, payload.totalUsers);
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

			const user = payload && payload.user;
			if (user) {
				await refreshUsers();
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

	searchForm?.addEventListener('submit', async (event) => {
		event.preventDefault();
		try {
			const nameFilter = searchInput ? searchInput.value.trim() : '';
			applySearchQueryToUrl(nameFilter);
			await refreshUsers();
		} catch (error) {
			showGlobalError('Unable to search users right now. Please try again.');
		}
	});

	// Native clear (X) does not submit the form; sync URL and reload the list like a search submit.
	searchInput?.addEventListener('input', () => {
		if (!searchInput) return;
		if (searchInput.value !== '') return;
		applySearchQueryToUrl('');
		void refreshUsers();
	});
})();
