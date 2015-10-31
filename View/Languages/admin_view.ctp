<div class="page view">
<h2><?php echo __('Language');?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($language['Language']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ori Name'); ?></dt>
		<dd>
			<?php echo h($language['Language']['ori_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code'); ?></dt>
		<dd>
			<?php echo h($language['Language']['code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Locale'); ?></dt>
		<dd>
			<?php echo h($language['Language']['locale']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Locale Fallback'); ?></dt>
		<dd>
			<?php echo h($language['Language']['locale_fallback']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($language['Language']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($language['Language']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Language')), ['action' => 'edit', $language['Language']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('Language')), ['action' => 'delete', $language['Language']['id']], ['confirm' => __('Are you sure you want to delete # %s?', $language['Language']['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Languages')), ['action' => 'index']); ?> </li>
	</ul>
</div>