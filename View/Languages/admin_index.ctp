<?php
App::uses('Folder', 'Utility');
?>
<div class="page index">
<h2><?php echo __('Languages');?></h2>

<?php if (CakePlugin::loaded('Search')) { ?>
<div class="search-box">
<?php
echo $this->Form->create();
echo $this->Form->input('search', ['placeholder' => __('wildcardSearch %s and %s', '*', '?')]);
echo $this->Form->input('dir', ['label' => __('Direction'), 'options' => Language::directions(), 'empty' => Configure::read('Select.defaultBefore') . __('noSelection') . Configure::read('Select.defaultAfter')]);
echo $this->Form->submit(__('Search'), []);
echo $this->Form->end();
?>
</div>
<?php } ?>

<table class="table list"><tr>
	<th>&nbsp;</th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo $this->Paginator->sort('locale');?></th>
	<th><?php echo $this->Paginator->sort('locale_fallback');?></th>
	<?php if (isset($language['Language']['direction'])) { ?>
	<th><?php echo $this->Paginator->sort('direction');?></th>
	<?php } ?>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($languages as $language):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
<?php
	$languageFlags = Cache::read('language_flags');
	list($wwwPath, $path) = $this->Data->getCountryIconPaths();
	if (!$languageFlags) {
		$handle = new Folder($path);
		$languageFlags = $handle->read(true, true);
		$languageFlags = $languageFlags[1];
		Cache::write('language_flags', $languageFlags);
	}

	if (!empty($language['Language']['code']) && in_array($language['Language']['code'] . '.gif', $languageFlags)) {
		echo $this->Html->image($wwwPath . $language['Language']['code'] . '.gif');
	}
?>
		</td>
		<td>
			<?php echo h($language['Language']['name']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['ori_name']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['code']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['locale']); ?>
		</td>
		<td>
			<?php echo h($language['Language']['locale_fallback']); ?>
		</td>
		<?php if (isset($language['Language']['direction'])) { ?>
		<td>
			<?php echo h($language['Language']['direction']); ?>
		</td>
		<?php } ?>
		<td>
			<?php echo $this->Format->yesNo($language['Language']['status'], ['onTitle' => __('Active'), 'offTitle' => __('Inactive')]); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($language['Language']['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $language['Language']['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $language['Language']['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $language['Language']['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $language['Language']['id'])]); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br /><br />
Important Note:<br />
The language flags are actually country flags. Due to incompatabities between countries and languages they should not be used on public sites. They are only meant to be a help (eye catcher) for admin views.
<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Language')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Compare %s', __('Languages')), ['action' => 'compare_to_iso_list']); ?></li>
		<li><?php echo $this->Html->link(__('Compare %s to core', __('Languages')), ['action' => 'compare_iso_list_to_core']); ?></li>
		<li><?php echo $this->Html->link(__('Import %s from Core', __('Language')), ['action' => 'import_from_core'], [], __('Sure?')); ?></li>
		<li><?php echo $this->Html->link(__('Set primary languages active'), ['action' => 'set_primary_languages_active'], [], __('Sure?')); ?></li>
	</ul>
</div>
