<div class="page index">
<h2><?php echo __('Mime Type Images');?></h2>
<p>
<?php
echo $this->Paginator->counter([
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total')
]);
?></p>
<table class="list">
<tr>
	<th><?php echo __('Icon');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ext');?></th>
	<th><?php echo $this->Paginator->sort('active');?></th>
	<th><?php echo __('Usage');?></th>
	<th><?php echo $this->Paginator->sort('details');?></th>
	<th><?php echo $this->Paginator->sort('created', null, ['direction' => 'desc']);?></th>
	<th><?php echo $this->Paginator->sort('modified', null, ['direction' => 'desc']);?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($mimeTypeImages as $mimeTypeImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}

	$image = '---';
	$imageSize = $imageWidth = $imageHeight = null;
	if (!empty($mimeTypeImage['MimeTypeImage']['ext']) && empty($mimeTypeImage['MimeTypeImage']['warning'])) {
		# Icon exists
		$image = $this->Html->image(IMG_MIMETYPES . $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext'], ['
		title' => $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext'], 'alt' => $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext']]);

		$imageSize = getimagesize(PATH_MIMETYPES . $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext']);
		$imageWidth = $imageSize[0];
		$imageHeight = $imageSize[1];
	}

?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $image; ?>
		</td>
		<td>
			<b><?php echo h($mimeTypeImage['MimeTypeImage']['name']); ?></b>
		</td>
		<td>
			<?php echo h($mimeTypeImage['MimeTypeImage']['ext']); ?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-<?php echo $mimeTypeImage['MimeTypeImage']['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($mimeTypeImage['MimeTypeImage']['active'], 'Active', 'Inactive', 1), ['action' => 'toggleActive', $mimeTypeImage['MimeTypeImage']['id']], ['escape' => false]);?>
			</span>

			<?php
				if (!empty($mimeTypeImage['MimeTypeImage']['warning'])) {
				echo ' ' . $this->Format->icon('warning', 'Icon konnte nicht gefunden werden!');
				}

			?>

		</td>
		<td>
			<?php $count = count($mimeTypeImage['MimeType']);
				if ($count > 0) {
					echo $count . ' &nbsp; ';
					echo $this->Format->icon('details', [], ['class' => 'hand', 'id' => 'details_' . $mimeTypeImage['MimeTypeImage']['id']]);
				} else {
					echo '---';
				}
			 ?>
		</td>
		<td>
			<?php echo nl2br(h($mimeTypeImage['MimeTypeImage']['details'])); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($mimeTypeImage['MimeTypeImage']['created']); ?>
		</td>
		<td>
			<?php echo $this->Datetime->niceDate($mimeTypeImage['MimeTypeImage']['modified']); ?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $mimeTypeImage['MimeTypeImage']['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Format->icon('edit'), ['action' => 'edit', $mimeTypeImage['MimeTypeImage']['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $mimeTypeImage['MimeTypeImage']['id']], ['escape' => false, 'confirm' => __('Are you sure you want to delete # %s?', $mimeTypeImage['MimeTypeImage']['id'])]); ?>
			<?php
				if (isset($imageWidth) && isset($imageHeight) && $imageWidth != 16 && $imageHeight != 16) {
					echo $this->Format->cIcon(ICON_SIZE, ['title' => 'Größe ist nicht 16x16, sondern ' . $imageWidth . 'x' . $imageHeight . '! Anpassen...']);
				} elseif (empty($mimeTypeImage['MimeTypeImage']['ext']) || !empty($mimeTypeImage['MimeTypeImage']['warning'])) {
					echo $this->Html->link($this->Format->cIcon('google.gif', 'Bei Google suchen'), 'http://images.google.de/images?q=' . $mimeTypeImage['MimeTypeImage']['name'] . '+imagesize%3A16x16&btnG=Bilder-Suche', ['escape' => false]);
				}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->first(__('first'), []);?>
 |
	<?php echo $this->Paginator->prev(__('previous'), [], null, ['class' => 'disabled']);?>
 |
	<?php echo $this->Paginator->numbers(['separator' => PAGINATOR_SEPARATOR]);?>
 |
	<?php echo $this->Paginator->next(__('next'), [], null, ['class' => 'disabled']);?>

 |
	<?php echo $this->Paginator->last(__('last'), []);?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Mime Type Image'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('(Auto-) Allocate Icons Files'), ['action' => 'allocate']); ?></li>
		<li><?php echo $this->Html->link(__('Import Extensions'), ['action' => 'import']); ?></li>
		<li><?php echo $this->Html->link(__('Search Icon on google.de'), 'http://images.google.de/images?q=icon+imagesize%3A16x16&btnG=Bilder-Suche'); ?></li>
	</ul>
</div>
