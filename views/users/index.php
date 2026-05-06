<header class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
	<div class="min-w-0">
		<h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">User Management</h1>
		<p class="mt-1 text-sm text-slate-600">View and manage your users in one place.</p>
	</div>
	<div class="flex w-full min-w-0 flex-col gap-3 sm:w-auto sm:flex-row sm:items-center sm:justify-end sm:gap-3">
		<form id="user-search-form" method="get" class="flex w-full shrink-0 sm:w-56" role="search">
			<label for="user-search-input" class="sr-only">Search by name</label>
			<input id="user-search-input" name="name" type="search" placeholder="Search by name" value="<?=htmlspecialchars($searchName, ENT_QUOTES, 'UTF-8')?>" class="box-border h-9 min-w-0 w-full rounded-md border-0 bg-white px-3 text-sm leading-9 text-slate-900 ring-1 ring-inset ring-slate-300 outline-none transition focus:ring-2 focus:ring-indigo-500 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-500"/>
		</form>
		<button type="button" command="show-modal" commandfor="create-user-dialog" class="inline-flex h-9 w-full shrink-0 cursor-pointer items-center justify-center rounded-md bg-indigo-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2 sm:w-auto">
			Create User
		</button>
	</div>
</header>

<div class="space-y-6">
	<section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<?php if ((int)$pagination['totalRecords'] === 0) { ?>
		<div id="users-empty-state" class="px-6 py-14">
			<?php if ($searchName === '') {
				$title = 'There are no users yet';
				$message = 'Create your first user to get started.';
				$showCreateButton = true;
			} else {
				$title = 'No matching users';
				$message = 'Try a different name or clear the search to see all users.';
				$showCreateButton = false;
			} ?>
			<?php include __DIR__.'/empty-state.php'; ?>
		</div>
		<?php } else { ?>
		<div id="users-table-block">
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
							<td class="whitespace-nowrap px-6 py-4 text-slate-600"><?=htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8')?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php include __DIR__.'/pagination.php'; ?>
		<?php } ?>
	</section>
</div>

<?php include __DIR__.'/create-form.php'; ?>
<?php ob_start(); ?>
<script src="js/users.js" defer></script>
<?php $scripts = ob_get_clean(); ?>
