<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country $country
 */
?>
<div class="page view">
<h2><?php echo __d('data', 'Country');?></h2>
	<dl>
		<dt><?php echo __d('data', 'Name'); ?></dt>
		<dd>
			<?php echo h($country->name); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Ori Name'); ?></dt>
		<dd>
			<?php echo h($country['ori_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Iso2'); ?></dt>
		<dd>
			<?php echo h($country['iso2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Iso3'); ?></dt>
		<dd>
			<?php echo h($country['iso3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Phone Code'); ?></dt>
		<dd>
			<?php echo ($country['phone_code'] ? '+' . h($country['phone_code']) : ''); ?>
		</dd>
		<dt><?php echo __d('data', 'Timezone'); ?></dt>
		<dd>
			<p>
			<?php echo $country->timezone_offset_strings? 'UTC ' . implode(', ', $country->timezone_offset_strings) : ''; ?>
			</p>
			<?php if ($country->timezones) { ?>
			<b>Related timezones:</b>
				<ul>
					<?php foreach ($country->timezones as $timezone) { ?>
					<li>
						<?php echo $this->Html->link($timezone->name, ['controller' => 'Timezones', 'action' => 'view', $timezone->id]);?>
						(<?php echo h($timezone->offset_string); ?>)
					</li>
					<?php } ?>
				</ul>
			<?php } ?>
		</dd>

		<dt><?php echo __d('data', 'Special'); ?></dt>
		<dd>
			<?php echo h($country['special']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __d('data', 'Address Format'); ?></dt>
		<dd>
			<?php echo nl2br(h($country['address_format'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Country')), ['action' => 'edit', $country->id]); ?> </li>
		<li><?php echo $this->Form->postButton(__d('data', 'Delete Country'), ['action' => 'delete', $country->id], [
			'escapeTitle' => false,
			'class' => 'btn btn-link p-0 align-baseline',
			'form' => [
				'class' => 'd-inline',
				'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $country->id),
			],
		]); ?> </li>
		<li><?php echo $this->Html->link(__d('data', 'List {0}', __d('data', 'Countries')), ['action' => 'index']); ?> </li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
