<?php
/**
 * @var \App\View\AppView $this
 * @var array $isoList
 * @var mixed $languages
 * @var mixed $locales
 */
?>
<div class="page index">
<h2><?php echo __('Languages');?></h2>
ISO List contains <?php echo count($isoList['values']); ?> languages.
<br/>
Core contains <?php echo count($locales);?> locales (with <?php echo count($languages); ?> regional locales).
<br/><br/>

<h3>Not in core</h3>
<table class="table"><tr>
	<th>&nbsp;</th>
	<th><?php echo $isoList['heading'][0];?></th>
	<th><?php echo $isoList['heading'][1];?></th>
	<th><?php echo $isoList['heading'][2];?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($isoList['values'] as $language):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}

	if (empty($language['iso2']) || array_key_exists($language['iso2'], $locales)) {
		continue;
	}

?>
	<tr>
		<td>
<?php
?>
		</td>
		<td>
			<?php
				echo h($language['iso3']);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo h($language['iso2']);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo h($language['ori_name']);
			?>&nbsp;
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $language['id']), array('escape'=>false)); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>


<h3>Only in core or faulty</h3>
<table class="table"><tr>
	<th>&nbsp;</th>
	<th><?php echo __('Language');?></th>
	<th><?php echo __('Code');?></th>
	<th><?php echo __('Locale');?></th>
	<th><?php echo __('Status');?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$isoLocales = [];
foreach ($isoList['values'] as $key => $value) {
	if (empty($value['iso2'])) {
		continue;
	}
	if (in_array($value['iso3'], $isoLocales, true)) {
		trigger_error(print_r($value, true));
	}
	$isoLocales[$value['iso2']] = $value['iso3'];
}

$i = 0;
foreach ($locales as $key => $locale):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}

	if (($exists = array_key_exists($key, $isoLocales)) && $locale['locale'] === $isoLocales[$key]) {
		continue;
	}

	//debug($locale);

?>
	<tr>
		<td>
<?php
?>
		</td>
		<td>
			<?php
				echo h($locale['language']);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo h($key);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo h($locale['locale']);
			?>&nbsp;
		</td>
		<td>
			<?php
				echo $this->Format->yesNo($exists, ['onTitle' => 'Existiert, aber falsch', 'offTitle' => 'Existiert nicht (mehr)']);
			?>&nbsp;
			<?php
				if ($exists) {
					echo h(' => ') . $isoLocales[$key];
				}
			?>
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Format->icon('view'), array('action'=>'view', $language['id']), array('escape'=>false)); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>



</div>

<br/><br/>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List {0}', __('Languages')), ['action' => 'index']); ?></li>
	</ul>
</div>
