<div class="page view">
<h2><?php  echo __('City');?></h2>
	<dl>
		<dt><?php echo __('Country Id'); ?></dt>
		<dd>
			<?php echo h($city['City']['country_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Official Id'); ?></dt>
		<dd>
			<?php echo h($city['City']['official_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('County Id'); ?></dt>
		<dd>
			<?php echo h($city['City']['county_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($city['City']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Citizens'); ?></dt>
		<dd>
			<?php echo h($city['City']['citizens']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code'); ?></dt>
		<dd>
			<?php echo h($city['City']['postal_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lat'); ?></dt>
		<td>
			<?php echo $this->Numeric->format($city['City']['lat']); ?>
		</td>
		<dt><?php echo __('Lng'); ?></dt>
		<td>
			<?php echo $this->Numeric->format($city['City']['lng']); ?>
		</td>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo nl2br(h($city['City']['description'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Postal Code Unique'); ?></dt>
		<dd>
			<?php echo $this->Format->yesNo($city['City']['postal_code_unique']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($city['City']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('City')), array('action' => 'edit', $city['City']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('City')), array('action' => 'delete', $city['City']['id']), null, __('Are you sure you want to delete # %s?', $city['City']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Cities')), array('action' => 'index')); ?> </li>
	</ul>
</div>
