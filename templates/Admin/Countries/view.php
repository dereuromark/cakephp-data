<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country $country
 */
?>
<div class="page view">
<h2><?php echo __('Country');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($country->name); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ori Name'); ?></dt>
		<dd>
			<?php echo h($country['ori_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Iso2'); ?></dt>
		<dd>
			<?php echo h($country['iso2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Iso3'); ?></dt>
		<dd>
			<?php echo h($country['iso3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone Code'); ?></dt>
		<dd>
			<?php echo ($country['phone_code'] ? '+' . h($country['phone_code']) : ''); ?>
		</dd>
		<dt><?php echo __('Timezone'); ?></dt>
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

		<dt><?php echo __('Special'); ?></dt>
		<dd>
			<?php echo h($country['special']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address Format'); ?></dt>
		<dd>
			<?php echo nl2br(h($country['address_format'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit {0}', __('Country')), ['action' => 'edit', $country->id]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Country'), ['action' => 'delete', $country->id], ['escape' => false, 'confirm'  => __('Are you sure you want to delete # {0}?', $country->id)]); ?> </li>
		<li><?php echo $this->Html->link(__('List {0}', __('Countries')), ['action' => 'index']); ?> </li>
	</ul>
</div>
