<div class="page index">
<h2><?php echo __('Mime Type Images');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total')
));
?></p>
<table class="list">
<tr>
	<th><?php echo __('Icon');?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ext');?></th>
	<th><?php echo $this->Paginator->sort('active');?></th>
	<th><?php echo __('Usage');?></th>
	<th><?php echo $this->Paginator->sort('details');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
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
		$image = $this->Html->image(IMG_MIMETYPES . $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext'], array('
		title' => $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext'], 'alt' => $mimeTypeImage['MimeTypeImage']['name'] . '.' . $mimeTypeImage['MimeTypeImage']['ext']));

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
			<?php echo $this->Html->link($this->Format->yesNo($mimeTypeImage['MimeTypeImage']['active'], 'Active', 'Inactive', 1), array('action' => 'toggleActive', $mimeTypeImage['MimeTypeImage']['id']), array('escape' => false));?>
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
					echo $this->Format->icon('details', null, null, null, array('class' => 'hand', 'id' => 'details_' . $mimeTypeImage['MimeTypeImage']['id']));
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
			<?php echo $this->Html->link($this->Format->icon('edit'), array('action' => 'edit', $mimeTypeImage['MimeTypeImage']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Format->icon('delete'), array('action' => 'delete', $mimeTypeImage['MimeTypeImage']['id']), array('escape' => false), __('Are you sure you want to delete # %s?', $mimeTypeImage['MimeTypeImage']['id'])); ?>
			<?php
				if (isset($imageWidth) && isset($imageHeight) && $imageWidth != 16 && $imageHeight != 16) {
					echo $this->Format->cIcon(ICON_SIZE, 'Größe ist nicht 16x16, sondern ' . $imageWidth . 'x' . $imageHeight . '! Anpassen...');
				} elseif (empty($mimeTypeImage['MimeTypeImage']['ext']) || !empty($mimeTypeImage['MimeTypeImage']['warning'])) {
					echo $this->Html->link($this->Format->cIcon('google.gif', 'Bei Google suchen'), 'http://images.google.de/images?q=' . $mimeTypeImage['MimeTypeImage']['name'] . '+imagesize%3A16x16&btnG=Bilder-Suche', array('escape' => false));
				}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->first(__('first'), array());?>
 |
	<?php echo $this->Paginator->prev(__('previous'), array(), null, array('class' => 'disabled'));?>
 |
	<?php echo $this->Paginator->numbers(array('separator' => PAGINATOR_SEPARATOR));?>
 |
	<?php echo $this->Paginator->next(__('next'), array(), null, array('class' => 'disabled'));?>

 |
	<?php echo $this->Paginator->last(__('last'), array());?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Mime Type Image'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('(Auto-) Allocate Icons Files'), array('action' => 'allocate')); ?></li>
		<li><?php echo $this->Html->link(__('Import Extensions'), array('action' => 'import')); ?></li>
		<li><?php echo $this->Html->link(__('Search Icon on google.de'), 'http://images.google.de/images?q=icon+imagesize%3A16x16&btnG=Bilder-Suche'); ?></li>
	</ul>
</div>