<div class="page index">
<h2><?php echo __('Countries');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Format->icon('filter'), ['escape' => false]);?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('country_code');?></th>
	<th><?php echo $this->Paginator->sort('zip_length', null, ['direction' => 'desc']);?></th>
</tr>
<?php
$i = 0;
foreach ($countries as $country):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr>
		<td>
			<?php echo $this->Data->countryIcon($country['iso2']); ?>
		</td>
		<td>
			<?php echo h($country['name']); ?>
		</td>
		<td>
			<?php echo h($country['ori_name']); ?>
		</td>
		<td>
			<?php echo $country['iso2']; ?>
		</td>
		<td>
			<?php echo $country['iso3']; ?>
		</td>
		<td>
			<?php echo '+' . $country['country_code']; ?>
		</td>
		<td>
			<?php if (!empty($country['zip_length'])) {
				echo $country['zip_length'];
			} else {
				echo '--';
			} ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<?php if (__('countryCodeExplanation') !== 'countryCodeExplanation') { ?>
<br/>
Hinweis:
<ul>
<li><?php echo __('countryCodeExplanation')?></li>
</ul>
<?php } ?>

<br/>
<span class="keyList"><?php echo __('Legend');?></span>
<ul class="keyList">
<li><?php echo $this->Data->countryIcon(null); ?> = Default Icon</li>
</ul>
