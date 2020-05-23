<?php
/**
 * @var \App\View\AppView $this
 * @var string $allCount
 * @var mixed $mimeTypes
 * @var string|null $searchStr
 */
?>
<div class="page index">
<h2><?php echo __('Mime Types');?></h2>

<div class="searchWrapper">
<?php echo $this->Form->create();?>
<div class="floatLeft"><?php echo $this->Form->control('Form.search', ['label' => '(Teil)Suche:', 'value' => $searchStr]);?></div>
<div class="floatLeft"><?php echo $this->Form->end(__('Submit'));?></div>
<?php
if (!empty($searchStr)) {
	echo '<div class="floatRight">' . $this->Html->link('Wieder alle anzeigen', ['action' => 'index', 'clear' => 'search']) . '</div>';
}
?>
<?php
if (!empty($searchStr) && !empty($allCount)) {
	$currentCount = $this->Paginator->params['paging']['CollectionEntry']['count'];
	if ($currentCount == 0) {
		$perCent = 0;
	} else {
		$perCent = ceil(($currentCount / $allCount) * 100);
	}
	echo '<br class="clear"/><div>' . $this->Html->image('icons/results.gif') . ' Treffer: <b>' . $perCent . '%</b> (' . $currentCount . __(' out of ') . $allCount . ')</div>';
}
?>
</div>
<br/>

<table class="table">
<tr>
	<th><?php echo __('Icon');?></th>
	<th><?php echo $this->Paginator->sort('ext');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('type');?></th>
	<th><?php echo $this->Paginator->sort('active');?></th>
	<th><?php echo $this->Paginator->sort('core');?></th>
	<th><?php echo $this->Paginator->sort('created', null, ['direction' => 'desc']);?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($mimeTypes as $mimeType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr>
		<td>
			<?php
			$icon = '---';

			if (!empty($mimeType['MimeTypeImage']['id'])) { // && !empty($mimeType['MimeTypeImage']['ext'])
				$fileName = $mimeType['MimeTypeImage']['name'];
				$fileExt = (!empty($mimeType['MimeTypeImage']['ext'])?$mimeType['MimeTypeImage']['ext']:'png');
				$title = (!empty($mimeType['MimeTypeImage']['ext'])?$fileName . '.' . $fileExt:'Kein Image festgelegt...');

				$icon = $this->Html->image(IMG_MIMETYPES . $fileName . '.' . $fileExt, ['title' => $title, 'alt' => $fileName . '.' . $fileExt]);
			}
			echo $icon;

			?>
		</td>
		<td>
			*.<b><?php echo h($mimeType['ext']); ?></b>
		</td>
		<td>
			<?php echo h($mimeType['name']); ?>
		</td>
		<td>
			<?php echo h($mimeType['type']); ?>
			<?php
			if (!empty($mimeType['alt_type'])) {
				echo '[' . h($mimeType['alt_type']) . ']';
			}
			?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-<?php echo $mimeType['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($mimeType['active'], ['onTitle' => 'Active', 'offTitle' => 'Inactive']), ['action' => 'toggleActive', $mimeType['id']], ['escape' => false]);?>
			</span>
		</td>
		<td>
			<?php echo $this->Format->yesNo($mimeType['core']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($mimeType['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($mimeType['modified']); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link($this->Format->icon('view'), ['action' => 'view', $mimeType['id']], ['escape' => false]); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $mimeType['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $mimeType['id']], ['escape' => false], __('Are you sure you want to delete # {0}?', $mimeType['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

	<?php echo $this->element('Tools.pagination'); ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Mime Type'), ['action' => 'add']); ?></li>

		<li><?php echo $this->Html->link(__('(Auto-) Allocate Icons by Extension'), ['action' => 'allocate']); ?></li>
		<li><?php echo $this->Html->link(__('Allocate Icons by Type (Groups)'), ['action' => 'allocateByType']); ?></li>
		<li><?php echo $this->Html->link(__('Import from Core Media View'), ['action' => 'fromCore']); ?></li>
		<li><?php echo $this->Html->link(__('Import from File'), ['action' => 'fromFile']); ?></li>
	</ul>
</div>
<br/>
<h3>Infos</h3>
<b>Bei den Medientypen gibt es folgende:</b><br/>
text = für Textdateien<br/>
image = für Grafikdateien<br/>
video = für Videodateien<br/>
audio = für Sounddateien<br/>
application = für Dateien, die an ein bestimmtes Programm gebunden sind<br/>
multipart = für mehrteilige Daten<br/>
message = für Nachrichten<br/>
model = für Dateien, die mehrdimensionale Strukturen repräsentieren<br/>
<br/>
Subtypen für server-eigene Dateiformate, d.h. Dateitypen, die auf dem Server ausgeführt werden können, werden meist mit x- eingeleitet.
