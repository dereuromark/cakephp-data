<?php echo $this->Html->link($this->Format->yesNo($ajaxToggle['MimeType']['active'], ['onTitle' => 'Active', 'offTitle' => 'Inactive']), array('action' => 'toggleActive', $ajaxToggle['MimeType']['id']), array('escape' => false));?>