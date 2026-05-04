<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Address $address
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Address');?></h2>
	<dl>

		<dt><?php echo __d('data', 'Country'); ?></dt>
		<dd>
			<?php echo $this->Html->link($address->country->name, ['controller' => 'Countries', 'action' => 'view', $address->country->id]); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Data.Address.State')) { ?>
		<dt><?php echo __d('data', 'Country Province'); ?></dt>
		<dd>
			<?php echo $this->Html->link($address->state['name'], ['controller' => 'States', 'action' => 'view', $address->state['id']]); ?>
			&nbsp;
		</dd>
<?php } ?>
		<dt><?php echo __d('data', 'First Name'); ?></dt>
		<dd>
			<?php echo h($address['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Last Name'); ?></dt>
		<dd>
			<?php echo h($address['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Street'); ?></dt>
		<dd>
			<?php echo h($address['street']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Postal Code'); ?></dt>
		<dd>
			<?php echo h($address['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'City'); ?></dt>
		<dd>
			<?php echo h($address['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Lat'); ?></dt>
		<dd>
			<?php echo h($address->lat); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Lng'); ?></dt>
		<dd>
			<?php echo h($address->lng); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Last Used'); ?></dt>
		<dd>
			<?php echo $this->Time->niceDate($address['last_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Formatted Address'); ?></dt>
		<dd>
			<?php echo h($address['formatted_address']); ?>
			&nbsp;
		</dd>
<?php if (Configure::read('Data.Address.debug')) { ?>
		<dt><?php echo __d('data', 'Debug'); ?></dt>
		<dd>
			<?php echo pre($address['geocoder_result']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Address')), ['action' => 'edit', $address['id']]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'Mark as {0}', __d('data', 'Used')), ['action' => 'mark_as_used', $address['id']]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete {0}', __d('data', 'Address')), ['action' => 'delete', $address['id']], [
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $address['id']),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Addresses')), ['action' => 'index']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
