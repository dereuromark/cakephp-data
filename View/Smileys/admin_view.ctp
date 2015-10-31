<div class="page view">
<h2><?php echo __('Smiley');?></h2>
	<dl>
		<dt><?php echo __('Smiley Cat Id'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['smiley_cat_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Smiley Path'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['smiley_path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prim Code'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['prim_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sec Code'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['sec_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Base'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['is_base']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sort'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['sort']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($smiley['Smiley']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($smiley['Smiley']['created']); ?>
			&nbsp;
		</dd>
<?php if ($smiley['Smiley']['created'] != $smiley['Smiley']['modified']) { ?>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo $this->Datetime->niceDate($smiley['Smiley']['modified']); ?>
			&nbsp;
		</dd>
<?php } ?>
	</dl>
</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit %s', __('Smiley')), ['action' => 'edit', $smiley['Smiley']['id']]); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete %s', __('Smiley')), ['action' => 'delete', $smiley['Smiley']['id']], ['confirm' => __('Are you sure you want to delete # %s?', $smiley['Smiley']['id'])]); ?> </li>
		<li><?php echo $this->Html->link(__('List %s', __('Smileys')), ['action' => 'index']); ?> </li>
	</ul>
</div>