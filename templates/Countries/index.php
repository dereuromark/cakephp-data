<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\Country> $countries
 */
?>
<div class="page index">
<h2><?php echo __('Countries');?></h2>

<table class="table">
<tr>
	<th><?php echo $this->Paginator->sort('sort', $this->Icon->render('filter'), ['escape' => false]);?></th>
	<th><?php echo $this->Paginator->sort('name');?></th>
	<th><?php echo $this->Paginator->sort('ori_name');?></th>
	<th><?php echo $this->Paginator->sort('iso2');?></th>
	<th><?php echo $this->Paginator->sort('iso3');?></th>
	<th><?php echo $this->Paginator->sort('phone_code');?></th>
</tr>
<?php
foreach ($countries as $country):
?>
	<tr>
		<td>
			<?php echo $this->Data->countryIcon($country->iso2); ?>
		</td>
		<td>
			<?php echo h($country->name); ?>
		</td>
		<td>
			<?php echo h($country->ori_name); ?>
		</td>
		<td>
			<?php echo h($country->iso2); ?>
		</td>
		<td>
			<?php echo h($country->iso3); ?>
		</td>
		<td>
			<?php echo ($country['phone_code'] ? '+' . h($country['phone_code']) : ''); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('Tools.pagination'); ?>
</div>

<?php if (__('countryCodeExplanation') !== 'countryCodeExplanation') { ?>
<br/>
<?php echo __('Note') ?>:
<ul>
<li><?php echo __('countryCodeExplanation')?></li>
</ul>
<?php } ?>

<br/>
<span class="keyList"><?php echo __('Legend');?></span>
<ul class="keyList">
<li><?php echo $this->Data->countryIcon(null); ?> = Default Icon</li>
</ul>
