<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\PostalCode $postalCode
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Postal Code');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Code'); ?></dt>
		<dd>
			<?php echo h($postalCode['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Country Id'); ?></dt>
		<dd>
			<?php echo h($postalCode->country->name); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Lat'); ?></dt>
		<dd>
			<?php echo $this->Number->format($postalCode['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Lng'); ?></dt>
		<dd>
			<?php echo $this->Number->format($postalCode['lng']); ?>
			&nbsp;
		</dd>
<?php if ((int)$postalCode['lat'] || (int)$postalCode['lng']) { ?>
		<dt><?php echo __d('data', 'Map'); ?></dt>
		<dd>
			<?php echo $this->GoogleMap->staticMap(['size' => '640x600', 'zoom' => 12, 'markers' => $this->GoogleMap->staticMarkers([['lat' => $postalCode['lat'], 'lng' => $postalCode['lng']]])]); ?>
		</dd>
<?php } ?>
		<dt><?php echo __d('data', 'Official Address'); ?></dt>
		<dd>
			<?php echo h($postalCode['official_address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Created'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($postalCode['created']); ?>
			&nbsp;
		</dd>
<?php if ($postalCode['created'] != $postalCode['modified']) { ?>
		<dt><?php echo __d('data', 'Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($postalCode['modified']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Postal Code')), ['action' => 'edit', $postalCode['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete {0}', __d('data', 'Postal Code')), ['action' => 'delete', $postalCode['id']], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $postalCode['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Postal Codes')), ['action' => 'index']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
