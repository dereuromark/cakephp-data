<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Currency[] $currencies
 */
?>
<div class="page index">
<h2><?php echo __('Full Currency Table');?></h2>

<?php
	echo pre($currencies);
?>


</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Currency')), ['action' => 'add']); ?></li>
	</ul>
</div>
