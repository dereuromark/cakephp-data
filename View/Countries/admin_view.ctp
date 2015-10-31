<div class="page view">
<h2><?php echo __('Country');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($country['Country']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ori Name'); ?></dt>
		<dd>
			<?php echo h($country['Country']['ori_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Iso2'); ?></dt>
		<dd>
			<?php echo h($country['Country']['iso2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Iso3'); ?></dt>
		<dd>
			<?php echo h($country['Country']['iso3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country Code'); ?></dt>
		<dd>
			<?php echo h($country['Country']['country_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Special'); ?></dt>
		<dd>
			<?php echo h($country['Country']['special']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address Format'); ?></dt>
		<dd>
			<?php echo nl2br(h($country['Country']['address_format'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Country')), ['action' => 'edit', $country['Country']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Country'), ['action' => 'delete', $country['Country']['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $country['Country']['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Countries')), ['action' => 'index']); ?> </li>
		<li><?php echo $this->Html->link(__('List Country Provinces'), ['controller' => 'country_provinces', 'action' => 'index']); ?> </li>
	</ul>
</div>