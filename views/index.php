<header class="mb-6 flex items-center justify-between gap-4">
	<div>
		<h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">User Management</h1>
		<p class="mt-1 text-sm text-slate-600">View and manage your users in one place.</p>
	</div>
	<button type="button" command="show-modal" commandfor="create-user-dialog" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2">
		Add User
	</button>
</header>

<div class="space-y-6">
	<?php if (count($users) === 0) { ?>
		<section class="rounded-xl border border-slate-200 bg-white px-6 py-12 text-center shadow-sm">
			<div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="h-6 w-6 text-indigo-600">
					<path d="M15 19.128a9.38 9.38 0 0 0 2.625.372A9.337 9.337 0 0 0 22.5 18c-1.343-2.56-4.065-4.5-7.5-4.5a9.37 9.37 0 0 0-1.125.068m0 0A5.002 5.002 0 0 1 7.5 9a5 5 0 0 1 10 0 5.002 5.002 0 0 1-3.625 4.568m0 0A9.372 9.372 0 0 0 6.375 19.5c-1.12 0-2.194-.196-3.188-.556 1.343-2.56 4.065-4.5 7.5-4.5 1.314 0 2.566.284 3.688.796Z" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</div>
			<h2 class="mx-auto mt-2 max-w-md text-lg font-semibold text-slate-900">Add your first user to get started.</h2>
			<button type="button" command="show-modal" commandfor="create-user-dialog" class="mt-5 inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2">
				Add User
			</button>
		</section>
	<?php } else { ?>
		<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
			<div class="overflow-x-auto">
				<table class="min-w-full text-sm">
					<thead>
						<tr>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">Name</th>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">E-mail</th>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">City</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-100 border-y border-slate-100 bg-white">
						<?php foreach($users as $user){ ?>
						<tr>
							<td class="whitespace-nowrap px-6 py-4 font-medium text-slate-950"><?=$user->getName()?></td>
							<td class="whitespace-nowrap px-6 py-4 text-slate-600"><?=$user->getEmail()?></td>
							<td class="whitespace-nowrap px-6 py-4 text-slate-600"><?=$user->getCity()?></td>
						</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" class="px-6 py-3.5 text-right font-medium text-slate-500">Total users: <?=count($users)?></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</section>
	<?php } ?>
</div>

<el-dialog>
	<dialog id="create-user-dialog" aria-labelledby="create-user-dialog-title" class="fixed inset-0 z-50 size-auto max-h-none max-w-none overflow-y-auto bg-transparent p-4 backdrop:bg-transparent">
		<el-dialog-backdrop class="fixed inset-0 bg-slate-900/50 transition-opacity data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in"></el-dialog-backdrop>
		<div tabindex="0" class="flex min-h-full items-center justify-center text-left focus:outline-none">
			<el-dialog-panel class="relative w-full max-w-md transform overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl transition-all data-closed:translate-y-2 data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
				<div class="flex items-start justify-between px-6 pt-6">
					<div>
						<h2 id="create-user-dialog-title" class="text-lg font-semibold text-slate-900">Add user</h2>
						<p class="mt-1 text-sm text-slate-600">Fill out all fields to create the user.</p>
					</div>
					<button type="button" command="close" commandfor="create-user-dialog" class="inline-flex items-center justify-center rounded-md p-1 text-slate-400 transition hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2" aria-label="Close modal">
						<span class="sr-only">Close</span>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="h-5 w-5">
							<path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</button>
				</div>

				<form id="create-user-form" method="post" action="create.php" class="mt-5 space-y-4 px-6">
					<div>
						<label for="name" class="mb-1.5 block text-sm font-medium text-slate-900">Name</label>
						<input name="name" type="text" id="name" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
					</div>

					<div>
						<label for="email" class="mb-1.5 block text-sm font-medium text-slate-900">E-mail</label>
						<input name="email" type="email" id="email" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
					</div>

					<div>
						<label for="city" class="mb-1.5 block text-sm font-medium text-slate-900">City</label>
						<input name="city" type="text" id="city" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
					</div>
				</form>
				<div class="mt-6 bg-slate-50 px-6 py-4">
					<button form="create-user-form" type="submit" class="inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2">
						Create User
					</button>
				</div>
			</div>
		</div>
	</dialog>
</el-dialog>