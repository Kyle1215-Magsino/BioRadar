// Setup jQuery AJAX defaults (no axios)
window.$ = window.jQuery || window.$;
if (window.$) {
	$.ajaxSetup({
		headers: {
			'X-Requested-With': 'XMLHttpRequest',
			'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]') ? document.head.querySelector('meta[name="csrf-token"]').content : ''
		}
	});
}
