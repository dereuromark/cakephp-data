<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\MimeTypeImage> $mimeTypeImages
 */
?>
<div class="page index">
<h2><?php echo __('Mime Type Images');?></h2>

<table class="table">
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


	$image = '---';
	$imageSize = $imageWidth = $imageHeight = null;
	if (!empty($mimeTypeImage['ext']) && empty($mimeTypeImage['warning'])) {
		# Icon exists
		$image = $this->Html->image(IMG_MIMETYPES . $mimeTypeImage['name'] . '.' . $mimeTypeImage['ext'], ['
		title' => $mimeTypeImage['name'] . '.' . $mimeTypeImage['ext'], 'alt' => $mimeTypeImage['name'] . '.' . $mimeTypeImage['ext']]);

		$imageSize = getimagesize(PATH_MIMETYPES . $mimeTypeImage['name'] . '.' . $mimeTypeImage['ext']);
		$imageWidth = $imageSize[0];
		$imageHeight = $imageSize[1];
	}

?>
	<tr>
		<td>
			<?php echo $image; ?>
		</td>
		<td>
			<b><?php echo h($mimeTypeImage['name']); ?></b>
		</td>
		<td>
			<?php echo h($mimeTypeImage['ext']); ?>
		</td>
		<td>
			<span class="ajaxToggling" id="ajaxToggle-<?php echo $mimeTypeImage['id']?>">
			<?php echo $this->Html->link($this->Format->yesNo($mimeTypeImage['active'], ['onTitle' => 'Active', 'offTitle' => 'Inactive']), ['action' => 'toggleActive', $mimeTypeImage['id']], ['escape' => false]);?>
			</span>

			<?php
				if (!empty($mimeTypeImage['warning'])) {
				echo ' ' . $this->Icon->render('warning', ['title' => 'Icon konnte nicht gefunden werden!']);
				}

			?>

		</td>
		<td>
			<?php $count = $mimeTypeImage->mime_types ? count($mimeTypeImage->mime_types) : 0;
				if ($count > 0) {
					echo $count . ' &nbsp; ';
					echo $this->Icon->render('details', [], ['class' => 'hand', 'id' => 'details_' . $mimeTypeImage['id']]);
				} else {
					echo '---';
				}
			 ?>
		</td>
		<td>
			<?php echo nl2br(h($mimeTypeImage['details'])); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($mimeTypeImage['created']); ?>
		</td>
		<td>
			<?php echo $this->Time->niceDate($mimeTypeImage['modified']); ?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Icon->render('view'), array('action'=>'view', $mimeTypeImage['id']), array('escape'=>false)); ?>
			<?php echo $this->Html->link($this->Icon->render('edit'), ['action' => 'edit', $mimeTypeImage['id']], ['escape' => false]); ?>
			<?php echo $this->Form->postLink($this->Icon->render('delete'), ['action' => 'delete', $mimeTypeImage['id']], ['escape' => false, 'confirm'  => __('Are you sure you want to delete # {0}?', $mimeTypeImage['id'])]); ?>
			<?php
				if (isset($imageWidth) && isset($imageHeight) && $imageWidth != 16 && $imageHeight != 16) {
					echo $this->Icon->render('expand', ['title' => __('Größe ist nicht 16x16, sondern ' . $imageWidth . 'x' . $imageHeight . '! Anpassen...')]);
				} elseif (empty($mimeTypeImage['ext']) || !empty($mimeTypeImage['warning'])) {
					echo $this->Html->link($this->Icon->render('google', ['title' => __('Search with Google')]), 'http://images.google.de/images?q=' . $mimeTypeImage['name'] . '+imagesize%3A16x16&btnG=Bilder-Suche', ['escape' => false]);
				}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('Tools.pagination'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add Mime Type Image'), ['action' => 'add']); ?></li>
		<li><?php echo $this->Html->link(__('(Auto-) Allocate Icons Files'), ['action' => 'allocate']); ?></li>
		<li><?php echo $this->Html->link(__('Import Extensions'), ['action' => 'import']); ?></li>
		<li><?php echo $this->Html->link(__('Search Icon on google.de'), 'http://images.google.de/images?q=icon+imagesize%3A16x16&btnG=Bilder-Suche'); ?></li>
	</ul>
</div>
