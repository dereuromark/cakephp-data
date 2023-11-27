<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Country[] $countriesWithoutIcons
 * @var iterable<\Data\Model\Entity\Country> $countries
 * @var array $icons
 */
?>
<h2>Icons</h2>
<?php echo count($countries); ?> Länder - <?php echo count($icons); ?> Icons

<?php if ($countriesWithoutIcons) { ?>
<h3>Countries Without Icons: <b><?php echo count($countriesWithoutIcons);?></b></h3>
<ul>
<?php
	foreach ($countriesWithoutIcons as $country) {
		echo '<li>';
		echo $this->Data->countryIcon(null) . ' ' . h($country->name) . ' (' . $country['iso2'] . ', ' . $country['iso3'] . ')';
		echo '</li>';
	}
?>
</ul>
<?php } ?>

<h3>Countries and Icons</h3>
<ul>
	<?php
	foreach ($countries as $country) {
		echo '<li>';
		echo $this->Data->countryIcon($country->iso2) . ' ' . h($country->name) . ' (' . $country['iso2'] . ', ' . $country['iso3'] . ') ' . $this->Html->link($this->Icon->render('view'), ['action' => 'view', $country->id], ['escapeTitle' => false]);
		echo '</li>';
	}
	?>
</ul>
