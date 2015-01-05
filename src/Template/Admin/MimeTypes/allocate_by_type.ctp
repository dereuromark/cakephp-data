
<h2>Allocate Images By Shared Types</h2>

<?php
	if (!empty($unused)) {
		echo '<h3>' . count($unused) . ' unused images</h3>';
		echo '<ul>';
		foreach ($unused as $u) {
			echo '<li>';
			echo $this->Html->image(IMG_MIMETYPES . $u['MimeTypeImage']['name'] . '.' . $u['MimeTypeImage']['ext']) . ' ' . $u['MimeTypeImage']['name'];
			echo '</li>';
		}
		echo '</ul>';
	}
?>


<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Mime Types'), array('action' => 'index'));?></li>
	</ul>
</div>