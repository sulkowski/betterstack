<?php
if (!isset($flashMessages) || !is_array($flashMessages) || $flashMessages === array()) {
	return;
}
$messages = array();
foreach ($flashMessages as $flash) {
	if (is_array($flash) && isset($flash['message']) && $flash['message'] !== '') {
		$messages[] = $flash['message'];
	} elseif (is_string($flash) && $flash !== '') {
		$messages[] = $flash;
	}
}
if ($messages === array()) {
	return;
}
?>
<div class="pointer-events-none fixed top-4 right-4 z-50 flex w-[calc(100%-2rem)] max-w-sm flex-col gap-3 sm:w-full" role="region" aria-label="Notifications">
	<?php foreach ($messages as $flashMessage) { ?>
	<div data-flash class="pointer-events-auto flex items-center gap-3 rounded-lg bg-white p-4 shadow-lg ring-1 ring-slate-900/5" role="status">
		<p class="min-w-0 flex-1 text-sm leading-snug text-slate-900"><?=htmlspecialchars($flashMessage, ENT_QUOTES, 'UTF-8')?></p>
		<button type="button" data-flash-dismiss class="inline-flex h-8 w-8 shrink-0 cursor-pointer items-center justify-center rounded-md text-slate-400 transition hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-white" aria-label="Dismiss notification">
			<span class="sr-only">Dismiss</span>
			<svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z"/></svg>
		</button>
	</div>
	<?php } ?>
</div>
