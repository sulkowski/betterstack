(() => {
	const dialog = document.querySelector('#create-user-dialog');
	if (!dialog) return;

	const form = dialog.querySelector('#create-user-form');
	if (!form) return;

	const elements = {
		search: {
			form: document.querySelector('#user-search-form'),
			input: document.querySelector('#user-search-input'),
		},
		userForm: {
			dialog,
			form,
			submitButton: dialog.querySelector('button[form="create-user-form"]'),
			formError: form.querySelector('#create-user-form-error'),
		},
		userList: {
			emptyState: document.querySelector('#users-empty-state'),
			tableBlock: document.querySelector('#users-table-block'),
			tableBody: document.querySelector('#users-table-body'),
			totalCount: document.querySelector('#total-users-count'),
			loadingStatus: document.querySelector('#users-loading-status'),
		},
		templates: {
			row: document.querySelector('#user-row-template'),
			noUsers: document.querySelector('#users-no-users-template'),
			noSearchResults: document.querySelector('#users-no-search-results-template'),
		},
	};

	const validationErrors = {};

	elements.userForm.form.querySelectorAll('[data-error-for]').forEach((element) => {
		validationErrors[element.getAttribute('data-error-for')] = element;
	});

	const clearErrors = () => {
		if (elements.userForm.formError) {
			elements.userForm.formError.classList.add('hidden');
			elements.userForm.formError.textContent = '';
		}

		Object.values(validationErrors).forEach((element) => {
			element.classList.add('hidden');
			element.textContent = '';
		});

		['name', 'email', 'city', 'phone'].forEach((fieldName) => {
			const field = elements.userForm.form.elements[fieldName];
			if (!field) return;
			field.classList.remove('ring-red-300', 'focus:ring-red-500');
			field.classList.add('ring-slate-300', 'focus:ring-indigo-500');
			field.removeAttribute('aria-invalid');
		});
	};

	const showGlobalError = (message) => {
		if (!elements.userForm.formError) return;
		elements.userForm.formError.textContent = message;
		elements.userForm.formError.classList.remove('hidden');
	};

	const setFieldError = (fieldName, message) => {
		const fieldError = validationErrors[fieldName];
		const field = elements.userForm.form.elements[fieldName];
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
		if (elements.userForm.submitButton) {
			elements.userForm.submitButton.disabled = isSubmitting;
			elements.userForm.submitButton.classList.toggle('opacity-70', isSubmitting);
			elements.userForm.submitButton.classList.toggle('cursor-not-allowed', isSubmitting);
			elements.userForm.submitButton.textContent = isSubmitting ? 'Creating...' : 'Create User';
		}
	};

	const appendUser = (user) => {
		const rowFragment = elements.templates.row.content.cloneNode(true);
		const rowElement = rowFragment.querySelector('tr');

		const nameCell = rowElement.querySelector('[data-field="name"]');
		const emailCell = rowElement.querySelector('[data-field="email"]');
		const cityCell = rowElement.querySelector('[data-field="city"]');
		const phoneCell = rowElement.querySelector('[data-field="phone"]');

		nameCell.textContent = user.name || '';
		emailCell.textContent = user.email || '';
		cityCell.textContent = user.city || '';
		if (phoneCell) phoneCell.textContent = user.phone || '';

		elements.userList.tableBody.appendChild(rowFragment);
	};

	const renderEmptyState = (totalUsersForEmpty) => {
		if (!elements.userList.emptyState) return;
		const nameFilter = elements.search.input ? elements.search.input.value.trim() : '';
		const useSearchVariant = nameFilter !== '' && totalUsersForEmpty > 0;
		const template = useSearchVariant ? elements.templates.noSearchResults : elements.templates.noUsers;
		elements.userList.emptyState.innerHTML = '';
		if (template) {
			elements.userList.emptyState.appendChild(template.content.cloneNode(true));
		}
		elements.userList.emptyState.classList.remove('hidden');
		if (elements.userList.tableBlock) elements.userList.tableBlock.classList.add('hidden');
	};

	const renderUsers = (users, totalUsers) => {
		updateTotalUsersCount(totalUsers);
		if (!users || users.length === 0) {
			if (elements.userList.tableBody) elements.userList.tableBody.innerHTML = '';
			renderEmptyState(totalUsers);
			return;
		}
		if (elements.userList.emptyState) elements.userList.emptyState.classList.add('hidden');
		if (elements.userList.tableBlock) elements.userList.tableBlock.classList.remove('hidden');
		elements.userList.tableBody.innerHTML = '';
		users.forEach((user) => appendUser(user));
	};

	const updateTotalUsersCount = (totalUsers) => {
		elements.userList.totalCount.dataset.count = String(totalUsers);
		elements.userList.totalCount.textContent = String(totalUsers);
	};

	const setUsersLoading = (isLoading) => {
		if (elements.userList.loadingStatus) {
			elements.userList.loadingStatus.classList.toggle('invisible', !isLoading);
			elements.userList.loadingStatus.classList.toggle('opacity-0', !isLoading);
			elements.userList.loadingStatus.classList.toggle('opacity-100', isLoading);
			elements.userList.loadingStatus.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
			const spinner = elements.userList.loadingStatus.querySelector('svg');
			if (spinner) {
				spinner.classList.toggle('animate-spin', isLoading);
			}
		}
		if (elements.search.input) {
			elements.search.input.disabled = isLoading;
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
		if (elements.search.input) {
			elements.search.input.value = nameFilter;
		}
		const payload = await fetchUsers(nameFilter);
		renderUsers(payload.users, payload.totalUsers);
	};

	elements.userForm.form.addEventListener('submit', async (event) => {
		event.preventDefault();
		clearErrors();
		setSubmitting(true);

		try {
			const response = await fetch(elements.userForm.form.action, {
				method: 'POST',
				body: new FormData(elements.userForm.form),
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
				elements.userForm.form.reset();
				clearErrors();
				elements.userForm.dialog.close?.();
				return;
			}

			window.location.reload();
		} catch (error) {
			showGlobalError('Network error. Please check your connection and try again.');
		} finally {
			setSubmitting(false);
		}
	});

	elements.search.form?.addEventListener('submit', async (event) => {
		event.preventDefault();
		try {
			const nameFilter = elements.search.input ? elements.search.input.value.trim() : '';
			applySearchQueryToUrl(nameFilter);
			await refreshUsers();
		} catch (error) {
			showGlobalError('Unable to search users right now. Please try again.');
		}
	});

	elements.search.input?.addEventListener('input', () => {
		if (!elements.search.input) return;
		if (elements.search.input.value !== '') return;
		applySearchQueryToUrl('');
		void refreshUsers();
	});
})();
