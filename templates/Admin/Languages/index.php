<?php
/**
 * @var \App\View\AppView $this
 *
 * @var \Data\Model\Entity\Language $language
 * @var \Data\Model\Entity\Language[]|\Cake\Collection\CollectionInterface $languages
 */

use Cake\Core\Configure;
use Cake\Core\Plugin;
?>

<div class="page index">
<h2><?php echo __('Languages');?></h2>

<?php if (Plugin::isLoaded('Search')) { ?>
<div class="search-box">
<?php
echo $this->Form->create($language);
echo $this->Form->control('search', ['placeholder' => __('wildcardSearch {0} and {1}', '*', '?')]);
echo $this->Form->control('dir', ['label' => __('Direction'), 'options' => $language::directions(), 'empty' => Configure::read('Select.defaultBefore') . __('noSelection') . Configure::read('Select.defaultAfter')]);
echo $this->Form->submit(__('Search'), []);
echo $this->Form->end();
?>
</div>
<?php } ?>

<table class="table"><tr>
	<th>&nbsp;</th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('code');?></th>
	<th><?php echo $this->Paginator->sort('locale');?></th>
	<th><?php echo $this->Paginator->sort('locale_fallback');?></th>
	<th><?php echo $this->Paginator->sort('direction');?></th>
	<th><?php echo $this->Paginator->sort('status');?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
foreach ($languages as $language):
?>
	<tr>
		<td>
<?php
	echo $this->Data->languageFlag($language['code']);
?>
		</td>
		<td>
			<?php echo h($language['name']); ?>
		</td>
		<td>
			<?php echo h($language['ori_name']); ?>
		</td>
		<td>
			<?php echo h($language['code']); ?>
		</td>
		<td>
			<?php echo h($language['locale']); ?>
		</td>
		<td>
			<?php echo h($language['locale_fallback']); ?>
		</td>
		<td>
			<?php echo h($language['direction']); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($language['status'], ['onTitle' => __('Active'), 'offTitle' => __('Inactive')]); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($language['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $language['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $language['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $language['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $language['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

<div class="pagination-container">
<?php echo $this->element('Tools.pagination'); ?></div>

</div>

<br/><br/>
Important Note:<br/>
The language flags are actually country flags. Due to incompatabities between countries and languages they should not be used on public sites. They are only meant to be a help (eye catcher) for admin views.
<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add {0}', __('Language')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('Compare {0}', __('Languages')), ['action' => 'compare_to_iso_list']); ?></li>
		<li><?php echo $this->Html->link(__('Compare {0} to core', __('Languages')), ['action' => 'compare_iso_list_to_core']); ?></li>
		<li><?php echo $this->Html->link(__('Import {0} from Core', __('Language')), ['action' => 'import_from_core'], [], __('Sure?')); ?></li>
		<li><?php echo $this->Html->link(__('Set primary languages active'), ['action' => 'set_primary_languages_active'], [], __('Sure?')); ?></li>
	</ul>
</div>
