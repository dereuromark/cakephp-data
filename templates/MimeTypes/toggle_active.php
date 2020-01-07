<?php
/**
 * @var \App\View\AppView $this
 * @var array $ajaxToggle
 */
?>
<?php /**
 * @var \App\View\AppView $this
 */
echo $this->Html->link($this->Format->yesNo($ajaxToggle['MimeType']['active'], ['onTitle' => 'Active', 'offTitle' => 'Inactive']), ['action' => 'toggleActive', $ajaxToggle['MimeType']['id']], ['escape' => false]);?>