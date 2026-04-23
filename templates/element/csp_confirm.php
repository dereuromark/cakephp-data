<?php
/**
 * CSP-safe confirmation delegate for Form->postButton() forms.
 *
 * Attaches a single submit listener to every <form data-confirm-message="...">
 * on the page and shows a native confirm() dialog before submission. This
 * replaces the inline onclick handler that Form->postLink() + ['confirm' => ...]
 * would emit, which is blocked under a strict CSP.
 *
 * Include once at the bottom of any template that renders a postButton:
 *   <?= $this->element('Data.csp_confirm') ?>
 *
 * Falls back gracefully: when the host app does not set a cspNonce request
 * attribute, the nonce= attribute is not rendered at all.
 *
 * @var \Cake\View\View $this
 */
$cspNonce = (string)$this->getRequest()->getAttribute('cspNonce', '');
?>
<script<?= $cspNonce !== '' ? ' nonce="' . h($cspNonce) . '"' : '' ?>>
document.querySelectorAll('form[data-confirm-message]').forEach(function(form) {
	form.addEventListener('submit', function(e) {
		if (!confirm(this.dataset.confirmMessage)) {
			e.preventDefault();
		}
	});
});
</script>
