<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Currency[] $currencies
 */
?>
<div class="page index">
<h2><?php echo __d('data', 'Full Currency Table');?></h2>

<?php
	echo pre($currencies);
?>


</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Add {0}', __d('data', 'Currency')), ['action' => 'add']); ?></li>
	</ul>
</div>
