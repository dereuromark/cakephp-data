<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\PostalCode $postalCode
 */
?>
<div class="page view">
<h2><?php echo __('Postal Code');?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($postalCode['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country Id'); ?></dt>
		<dd>
			<?php echo h($postalCode->country->name); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo $this->Number->format($postalCode['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng'); ?></dt>
		<dd>
			<?php echo $this->Number->format($postalCode['lng']); ?>
			&nbsp;
		</dd>
<?php if ((int)$postalCode['lat'] || (int)$postalCode['lng']) { ?>
		<dt><?php echo __('Map'); ?></dt>
		<dd>
			<?php echo $this->GoogleMap->staticMap(['size' => '640x600', 'zoom' => 12, 'markers' => $this->GoogleMap->staticMarkers([['lat' => $postalCode['lat'], 'lng' => $postalCode['lng']]])]); ?>
		</dd>
<?php } ?>
		<dt><?php echo __('Official Address'); ?></dt>
		<dd>
			<?php echo h($postalCode['official_address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($postalCode['created']); ?>
			&nbsp;
		</dd>
<?php if ($postalCode['created'] != $postalCode['modified']) { ?>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($postalCode['modified']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Postal Code')), ['action' => 'edit', $postalCode['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete {0}', __('Postal Code')), ['action' => 'delete', $postalCode['id']], ['confirm' => __('Are you sure you want to delete # {0}?', $postalCode['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Postal Codes')), ['action' => 'index']); ?> </li>
	</ul>
</div>
