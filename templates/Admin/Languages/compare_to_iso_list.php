<?php
/**
 * @var \App\View\AppView $this
 * @var array $isoList
 * @var mixed $languages
 */
use Cake\Core\Plugin;
use Cake\Cache\Cache;
use Shim\Filesystem\Folder;
?>

<div class="page index">
<h2><?php echo __('Languages');?></h2>
ISO List contains <?php echo count($isoList['values']); ?> languages.
<br/>
Local DB contains <?php echo count($languages); ?> locales.
<br/><br/>

<table class="table"><tr>
	<th>&nbsp;</th>
	<th><?php echo $isoList['heading'][0];?></th>
	<th><?php echo $isoList['heading'][1];?></th>
	<th><?php echo $isoList['heading'][2];?></th>
	<th><?php echo __('Locales'); ?></th>
	<th class="actions"><?php echo __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($isoList['values'] as $language):

?>
	<tr>
		<td>
<?php
	$languageFlags = Cache::read('language_flags');
	if (!$languageFlags) {
		$handle = new Folder(Plugin::path('Tools') . 'webroot' . DS . 'img' . DS . 'country_flags');
		$languageFlags = $handle->read(true, true);
		$languageFlags = $languageFlags[1];
		Cache::write('language_flags', $languageFlags);
	}

	if (!empty($language['iso2']) && in_array($language['iso2'] . '.gif', $languageFlags)) {
		echo $this->Html->image('/data/img/country_flags/' . $language['iso2'] . '.gif');
	}
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
		<td>
			<?php
				if (!empty($language['iso2'])) {
					foreach ($languages as $lang) {
					if (!empty($lang['code']) && $language['iso2'] == $lang['code']) {
						echo '<div>' . h($lang['name']) . '</div>';
					}
					}
				}
			?>
			&nbsp;
		</td>
		<td class="actions">
			<?php //echo $this->Html->link($this->Icon->render('view'), array('action'=>'view', $language['id']), array('escape'=>false)); ?>
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
