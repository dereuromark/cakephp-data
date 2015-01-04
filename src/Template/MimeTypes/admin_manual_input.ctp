<div class="page index">
<h2><?php echo __('Manual Input');?></h2>





<h3>Export</h3>
<?php
//pr ($exportArray);

if (!empty($exportArray)) {
	$out = '$result = array(' . BR;
	foreach ($exportArray as $key => $value) {
		$out .= ' &nbsp; \'' . h($key) . '\' =&gt; array(' . BR;
		foreach ($value as $subkey => $subvalue) {
			$out .= ' &nbsp;&nbsp;&nbsp; \'' . h($subkey) . '\' =&gt; \'' . h($subvalue) . '\',' . BR;
		}
		$out .= ' &nbsp; ),' . BR;
	}
	$out .= ');';

	echo $this->Html->pre($out);

} else {
	echo '- - -';
}
?>
</div>