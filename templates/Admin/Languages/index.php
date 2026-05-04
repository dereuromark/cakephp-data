<?php
/**
 * @var \App\View\AppView $this
 *
 * @var \Data\Model\Entity\Language $language
 * @var iterable<\Data\Model\Entity\Language> $languages
 */

use Cake\Core\Configure;
use Cake\Core\Plugin;
?>

<div class="page index">
<h2><?php echo __d('data', 'Languages');?></h2>

<?php if (Plugin::isLoaded('Search')) { ?>
<div class="search-box">
<?php
echo $this->Form->create(null, ['valueSources' => 'query']);
echo $this->Form->control('search', ['placeholder' => __d('data', 'wildcardSearch {0} and {1}', '*', '?')]);
echo $this->Form->control('dir', ['label' => __d('data', 'Direction'), 'options' => $language::directions(), 'empty' => Configure::read('Select.defaultBefore') . __d('data', 'noSelection') . Configure::read('Select.defaultAfter')]);
echo $this->Form->button(__d('data', 'Search'), []);
echo $this->Form->end();
?>
<?php if ($this->Search->isSearch()) {
	echo $this->Search->resetLink(null, ['class' => 'btn btn-secondary']);
} ?>
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
	<th class="actions"><?php echo __d('data', 'Actions');?></th>
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
			<?php echo $language::directions($language->direction); ?>
		</td>
		<td>
			<?php echo $this->Format->yesNo($language['status'], ['onTitle' => __d('data', 'Active'), 'offTitle' => __d('data', 'Inactive')]); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($language['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Icon->render('view'), ['action' => 'view', $language['id']], ['escapeTitle' => false]); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $language['id']], ['escapeTitle' => false]); ?>
			<?php echo $this->Form->postButton($this->Icon->render('delete'), ['action' => 'delete', $language['id']], [
				'escapeTitle' => false,
				'class' => 'btn btn-link p-0 align-baseline',
				'form' => [
					'class' => 'd-inline',
					'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $language['id']),
				],
			]); ?>
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
		<li><?php echo $this->Html->link(__d('data', 'Add {0}', __d('data', 'Language')), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Compare {0}', __d('data', 'Languages')), ['action' => 'compare_to_iso_list']); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Compare {0} to core', __d('data', 'Languages')), ['action' => 'compare_iso_list_to_core']); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Import {0} from Core', __d('data', 'Language')), ['action' => 'import_from_core'], [], __d('data', 'Sure?')); ?></li>
		<li><?php echo $this->Html->link(__d('data', 'Set primary languages active'), ['action' => 'set_primary_languages_active'], [], __d('data', 'Sure?')); ?></li>
	</ul>
</div>
<?= $this->element('Data.csp_confirm') ?>
