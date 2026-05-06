<?php if ((int)$pagination['totalRecords'] < 1) { ?>
<div id="users-pagination" class="hidden">
	<span id="total-users-count" class="sr-only" data-count="0">0</span>
</div>
<?php } else { ?>
<div id="users-pagination" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
	<div class="flex flex-1 justify-between sm:hidden">
		<?php if ($pagination['hasPrev']) { ?>
		<a href="<?= htmlspecialchars($pagination['prevHref'], ENT_QUOTES, 'UTF-8') ?>" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
		<?php } else { ?>
		<span class="relative inline-flex cursor-not-allowed items-center rounded-md border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-400">Previous</span>
		<?php } ?>
		<?php if ($pagination['hasNext']) { ?>
		<a href="<?= htmlspecialchars($pagination['nextHref'], ENT_QUOTES, 'UTF-8') ?>" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
		<?php } else { ?>
		<span class="relative ml-3 inline-flex cursor-not-allowed items-center rounded-md border border-gray-200 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-400">Next</span>
		<?php } ?>
	</div>
	<div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
		<div>
			<p class="text-sm text-gray-700">
				Showing
				<span class="font-medium"><?= (int)$pagination['showingFrom'] ?></span>
				to
				<span class="font-medium"><?= (int)$pagination['showingTo'] ?></span>
				of
				<span id="total-users-count" class="font-medium" data-count="<?= (int)$pagination['totalRecords'] ?>"><?= (int)$pagination['totalRecords'] ?></span>
				results
			</p>
		</div>
		<div>
			<nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-xs">
				<?php if ($pagination['hasPrev']) { ?>
				<a href="<?= htmlspecialchars($pagination['prevHref'], ENT_QUOTES, 'UTF-8') ?>" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
					<span class="sr-only">Previous</span>
					<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5"><path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" /></svg>
				</a>
				<?php } else { ?>
				<span class="relative inline-flex cursor-not-allowed items-center rounded-l-md px-2 py-2 text-gray-300 inset-ring inset-ring-gray-200">
					<span class="sr-only">Previous</span>
					<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5"><path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" /></svg>
				</span>
				<?php } ?>
				<?php foreach ($pagination['pages'] as $item) { ?>
					<?php if ($item['type'] === 'ellipsis') { ?>
				<span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 inset-ring inset-ring-gray-300">...</span>
					<?php } elseif ((int)$item['n'] === (int)$pagination['page']) { ?>
				<span aria-current="page" class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><?= (int)$item['n'] ?></span>
					<?php } else { ?>
				<a href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"><?= (int)$item['n'] ?></a>
					<?php } ?>
				<?php } ?>
				<?php if ($pagination['hasNext']) { ?>
				<a href="<?= htmlspecialchars($pagination['nextHref'], ENT_QUOTES, 'UTF-8') ?>" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
					<span class="sr-only">Next</span>
					<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
				</a>
				<?php } else { ?>
				<span class="relative inline-flex cursor-not-allowed items-center rounded-r-md px-2 py-2 text-gray-300 inset-ring inset-ring-gray-200">
					<span class="sr-only">Next</span>
					<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
				</span>
				<?php } ?>
			</nav>
		</div>
	</div>
</div>
<?php } ?>
