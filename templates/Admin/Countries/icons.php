<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $contriesWithoutIcons
 * @var mixed $countries
 * @var mixed $icons
 * @var mixed $iconsWithoutCountries
 */
?>
<h2>Icons</h2>
<?php echo count($countries); ?> Länder - <?php echo count($icons); ?> Icons


<h3>contriesWithoutIcons: <b><?php echo count($contriesWithoutIcons);?></b></h3>
<ul>
<?php
	foreach ($contriesWithoutIcons as $country) {
		echo '<li>';
		echo $this->Data->countryIcon(null) . ' ' . h($country->name) . ' (' . $country['iso2'] . ', ' . $country['iso3'] . ') ' . $this->Form->postLink($this->Format->icon('delete'), ['action' => 'delete', $country->id], ['escape' => false], 'Sicher?');
		echo '</li>';
	}
?>
</ul>


<h3>iconsWithoutCountries: <b><?php echo count($iconsWithoutCountries);?></b></h3>
<ul>
<?php
	foreach ($iconsWithoutCountries as $icon) {
		echo '<li>';
		echo $this->Data->countryIcon($icon) . ' (' . $icon . ')';
		echo '</li>';
	}
?>
</ul>


<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Reset Cache'), ['action' => 'icons', 'reset' => 1]); ?></li>
	</ul>
</div>
