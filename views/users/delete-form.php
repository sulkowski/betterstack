<el-dialog>
	<dialog id="delete-user-dialog" aria-labelledby="delete-user-dialog-title" class="fixed inset-0 z-50 size-auto max-h-none max-w-none overflow-y-auto bg-transparent p-4 backdrop:bg-transparent">
		<el-dialog-backdrop class="fixed inset-0 bg-slate-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"></el-dialog-backdrop>
		<div tabindex="0" class="flex min-h-full items-center justify-center text-left focus:outline-none">
			<el-dialog-panel class="relative w-full max-w-md transform overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl transition-all data-closed:translate-y-2 data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
				<div class="px-6 pt-6">
					<h2 id="delete-user-dialog-title" class="text-lg font-semibold text-slate-900">Do you really want to remove this user?</h2>
					<p class="mt-2 text-sm leading-6 text-slate-600">
						User <span id="delete-user-dialog-message" class="font-medium text-slate-900"></span> will be permanently removed. This action cannot be undone.
					</p>
					<div id="delete-user-form-error" class="mt-4 hidden rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700"></div>
				</div>
				<form id="delete-user-form" method="post" action="/delete.php" class="hidden">
					<input type="hidden" name="id" value="">
				</form>
				<div class="mt-6 flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
					<button type="button" command="close" commandfor="delete-user-dialog" class="inline-flex cursor-pointer items-center justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-slate-300 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2">
						Cancel
					</button>
					<button form="delete-user-form" type="submit" class="inline-flex cursor-pointer items-center justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
						Remove
					</button>
				</div>
			</el-dialog-panel>
		</div>
	</dialog>
</el-dialog>
