<header class="mb-6 flex items-center justify-between gap-4">
	<div>
		<h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">User Management</h1>
		<p class="mt-1 text-sm text-slate-600">View and manage your users in one place.</p>
	</div>
	<div class="flex items-center gap-3">
		<form id="user-search-form" class="flex items-center gap-2">
			<label for="user-search-input" class="sr-only">Search by name</label>
			<input id="user-search-input" name="name" type="search" placeholder="Search by name" value="<?=htmlspecialchars($searchName, ENT_QUOTES, 'UTF-8')?>" class="box-border h-9 w-56 rounded-md border-0 bg-white px-3 text-sm leading-9 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-500"/>
		</form>
		<button type="button" command="show-modal" commandfor="create-user-dialog" class="inline-flex h-9 items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2">
			Add User
		</button>
	</div>
</header>

<div class="space-y-6">
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="flex min-h-10 items-center border-b border-slate-100 px-6">
			<p id="users-loading-status" class="flex items-center gap-2 text-sm text-slate-600 opacity-0 invisible transition-opacity duration-200" role="status" aria-live="polite" aria-hidden="true">
				<svg class="h-4 w-4 shrink-0 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
				<span>Refreshing…</span>
			</p>
		</div>
		<div id="users-empty-state" class="px-6 py-14 <?=count($users) > 0 ? 'hidden' : ''?>">
			<?php if ($totalUsers === 0) { ?>
				<?php include __DIR__.'/partials/no-users.php'; ?>
			<?php } else { ?>
				<?php include __DIR__.'/partials/no-results.php'; ?>
			<?php } ?>
		</div>
		<div id="users-table-block" class="<?=count($users) > 0 ? '' : 'hidden'?>">
			<div class="overflow-x-auto">
				<table class="min-w-full text-sm">
					<thead>
						<tr>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">Name</th>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">E-mail</th>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">City</th>
							<th scope="col" class="px-6 py-3.5 text-left font-semibold text-slate-900">Phone</th>
						</tr>
					</thead>
					<tbody id="users-table-body" class="divide-y divide-slate-100 border-y border-slate-100 bg-white">
						<?php foreach ($users as $user) { ?>
						<tr>
							<td class="whitespace-nowrap px-6 py-4 font-medium text-slate-950"><?=htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8')?></td>
							<td class="whitespace-nowrap px-6 py-4 text-slate-600"><?=htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8')?></td>
							<td class="whitespace-nowrap px-6 py-4 text-slate-600"><?=htmlspecialchars($user['city'], ENT_QUOTES, 'UTF-8')?></td>
							<td class="whitespace-nowrap px-6 py-4 text-slate-600"><?=htmlspecialchars(isset($user['phone']) ? $user['phone'] : '', ENT_QUOTES, 'UTF-8')?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="border-t border-slate-100 px-6 py-3.5 text-right text-sm font-medium text-slate-500">
			Total users: <span id="total-users-count" data-count="<?=$totalUsers?>"><?=$totalUsers?></span>
		</div>
	</section>
</div>

<template id="user-row-template">
	<tr>
		<td data-field="name" class="whitespace-nowrap px-6 py-4 font-medium text-slate-950"></td>
		<td data-field="email" class="whitespace-nowrap px-6 py-4 text-slate-600"></td>
		<td data-field="city" class="whitespace-nowrap px-6 py-4 text-slate-600"></td>
		<td data-field="phone" class="whitespace-nowrap px-6 py-4 text-slate-600"></td>
	</tr>
</template>

<template id="users-no-users-template">
	<?php include __DIR__.'/partials/no-users.php'; ?>
</template>

<template id="users-no-search-results-template">
	<?php include __DIR__.'/partials/no-results.php'; ?>
</template>

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

				<form id="create-user-form" method="post" action="create.php" class="mt-5 space-y-4 px-6" novalidate>
					<div id="create-user-form-error" class="hidden rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700"></div>
					<div>
						<label for="name" class="mb-1.5 block text-sm font-medium text-slate-900">Name</label>
						<input name="name" type="text" id="name" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="name"></p>
					</div>

					<div>
						<label for="email" class="mb-1.5 block text-sm font-medium text-slate-900">E-mail</label>
						<input name="email" type="email" id="email" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="email"></p>
					</div>

					<div>
						<label for="city" class="mb-1.5 block text-sm font-medium text-slate-900">City</label>
						<input name="city" type="text" id="city" required class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="city"></p>
					</div>

					<div>
						<label for="phone" class="mb-1.5 block text-sm font-medium text-slate-900">Phone</label>
						<input name="phone" type="tel" id="phone" inputmode="tel" autocomplete="tel" required maxlength="20" placeholder="+1 212 555 1234" class="block w-full rounded-md border-0 px-3 py-2 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500"/>
						<p class="mt-1 hidden text-sm text-red-600" data-error-for="phone"></p>
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

<?php ob_start(); ?>
<script src="js/users.js" defer></script>
<?php $scripts = ob_get_clean(); ?>