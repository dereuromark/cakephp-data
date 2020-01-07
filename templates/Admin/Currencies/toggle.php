<?php
/**
 * @var \App\View\AppView $this
 * @var array $ajaxToggle
 * @var mixed $field
 * @var mixed $model
 */
?>
<?php /**
 * @var \App\View\AppView $this
 */
echo $this->Html->link($this->Format->yesNo($ajaxToggle[$model][$field]), ['action' => 'toggle', $field, $ajaxToggle[$model]['id']], ['escape' => false]);