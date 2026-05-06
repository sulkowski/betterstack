<el-dialog>
	<dialog id="create-user-dialog" aria-labelledby="create-user-dialog-title" class="fixed inset-0 z-50 size-auto max-h-none max-w-none overflow-y-auto bg-transparent p-4 backdrop:bg-transparent">
		<el-dialog-backdrop class="fixed inset-0 bg-slate-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"></el-dialog-backdrop>
		<div tabindex="0" class="flex min-h-full items-center justify-center text-left focus:outline-none">
			<el-dialog-panel class="relative w-full max-w-md transform overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl transition-all data-closed:translate-y-2 data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
				<div class="flex items-start justify-between px-6 pt-6">
					<div>
						<h2 id="create-user-dialog-title" class="text-lg font-semibold text-slate-900">Create User</h2>
						<p class="mt-1 text-sm text-slate-600">Fill out all fields to create the user.</p>
					</div>
					<button type="button" command="close" commandfor="create-user-dialog" class="inline-flex cursor-pointer items-center justify-center rounded-md p-1 text-slate-400 transition hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2" aria-label="Close modal">
						<span class="sr-only">Close</span>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="h-5 w-5">
							<path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</button>
				</div>

				<form id="create-user-form" method="post" action="create.php" class="mt-5 space-y-4 px-6" novalidate>
					<div id="create-user-form-error" class="hidden rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700"></div>
					<div>
						<label for="create-user-name" class="mb-1.5 block text-sm font-medium text-slate-900">Name <span aria-hidden="true" class="text-red-600">*</span></label>
						<input name="name" type="text" id="create-user-name" required placeholder="Maria Novák" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="name"></p>
					</div>

					<div>
						<label for="create-user-email" class="mb-1.5 block text-sm font-medium text-slate-900">E-mail <span aria-hidden="true" class="text-red-600">*</span></label>
						<input name="email" type="email" id="create-user-email" required placeholder="maria@example.com" autocomplete="email" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="email"></p>
					</div>

					<div>
						<label for="create-user-city" class="mb-1.5 block text-sm font-medium text-slate-900">City <span aria-hidden="true" class="text-red-600">*</span></label>
						<input name="city" type="text" id="create-user-city" required placeholder="Praha" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="city"></p>
					</div>

					<div>
						<label for="create-user-phone" class="mb-1.5 block text-sm font-medium text-slate-900">Phone <span aria-hidden="true" class="text-red-600">*</span></label>
						<input name="phone" type="tel" id="create-user-phone" inputmode="tel" autocomplete="tel" required maxlength="20" placeholder="+420 601 123 456" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="phone"></p>
					</div>
				</form>
				<div class="mt-6 bg-slate-50 px-6 py-4">
					<button form="create-user-form" type="submit" class="inline-flex w-full cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2">
						Create User
					</button>
				</div>
			</el-dialog-panel>
		</div>
	</dialog>
</el-dialog>
