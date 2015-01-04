<div class="page view">
<h2><?php echo __('Postal Code');?></h2>
	<dl>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($postalCode['PostalCode']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country Id'); ?></dt>
		<dd>
			<?php echo h($postalCode['Country']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<dd>
			<?php echo $this->Numeric->format($postalCode['PostalCode']['lat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lng'); ?></dt>
		<dd>
			<?php echo $this->Numeric->format($postalCode['PostalCode']['lng']); ?>
			&nbsp;
		</dd>
<?php if ((int)$postalCode['PostalCode']['lat'] || (int)$postalCode['PostalCode']['lng']) { ?>
		<dt><?php echo __('Map'); ?></dt>
		<dd>
			<?php echo $this->GoogleMapV3->staticMap(array('size' => '640x600', 'zoom' => 12, 'markers' => $this->GoogleMapV3->staticMarkers(array(array('lat' => $postalCode['PostalCode']['lat'], 'lng' => $postalCode['PostalCode']['lng']))))); ?>
		</dd>
<?php } ?>
		<dt><?php echo __('Official Address'); ?></dt>
		<dd>
			<?php echo h($postalCode['PostalCode']['official_address']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($postalCode['PostalCode']['created']); ?>
			&nbsp;
		</dd>
<?php if ($postalCode['PostalCode']['created'] != $postalCode['PostalCode']['modified']) { ?>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($postalCode['PostalCode']['modified']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Postal Code')), array('action' => 'edit', $postalCode['PostalCode']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('Postal Code')), array('action' => 'delete', $postalCode['PostalCode']['id']), null, __('Are you sure you want to delete # %s?', $postalCode['PostalCode']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Postal Codes')), array('action' => 'index')); ?> </li>
	</ul>
</div>
