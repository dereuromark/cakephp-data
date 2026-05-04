<?php
/**
 * @var \App\View\AppView $this
 * @var \Data\Model\Entity\Timezone $timezone
 */
?>
<div class="row">
    <aside class="column actions large-3 medium-4 col-sm-4 col-xs-12">
        <ul class="side-nav nav nav-pills flex-column">
            <li class="nav-item heading"><?= __d('data', 'Actions') ?></li>
            <li class="nav-item"><?= $this->Html->link(__d('data', 'Edit {0}', __d('data', 'Timezone')), ['action' => 'edit', $timezone->id], ['class' => 'side-nav-item']) ?></li>
            <li class="nav-item"><?= $this->Form->postButton(__d('data', 'Delete {0}', __d('data', 'Timezone')), ['action' => 'delete', $timezone->id], [
                'class' => 'side-nav-item btn btn-link text-start w-100',
                'form' => [
                    'class' => 'd-inline',
                    'data-confirm-message' => __d('data', 'Are you sure you want to delete # {0}?', $timezone->id),
                ],
            ]) ?></li>
            <li class="nav-item"><?= $this->Html->link(__d('data', 'List {0}', __d('data', 'Timezones')), ['action' => 'index'], ['class' => 'side-nav-item']) ?></li>
        </ul>
    </aside>
    <div class="column-responsive column-80 content large-9 medium-8 col-sm-8 col-xs-12">
        <div class="timezones view content">
            <h2><?= h($timezone->name) ?></h2>

            <table class="table table-striped">
                <tr>
                    <th><?= __d('data', 'Name') ?></th>
                    <td>
						<?= h($timezone->name) ?>
						<div><small>
								<?php if ($timezone->canonical_timezone) {
									echo ' => ' . $this->Html->link($timezone->canonical_timezone->name, ['action' => 'view', $timezone->linked_id]);
								} ?>
							</small></div>
					</td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Country Code') ?></th>
                    <td><?php
						echo $timezone->country ? $this->Html->link($timezone->country_code, ['controller' => 'Countries', 'action' => 'view', $timezone->country->id]) : h($timezone->country_code)
					?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Offset') ?></th>
                    <td><?= h($timezone->offset_string) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Offset Dst') ?></th>
                    <td><?= h($timezone->offset_dst_string) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Type') ?></th>
                    <td><?= h($timezone->type) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Covered') ?></th>
                    <td><?= h($timezone->covered) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Notes') ?></th>
                    <td><?= h($timezone->notes) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Lat') ?></th>
                    <td><?= $this->Number->format($timezone->lat) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Lng') ?></th>
                    <td><?= $this->Number->format($timezone->lng) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Created') ?></th>
                    <td><?= $this->Time->nice($timezone->created) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Modified') ?></th>
                    <td><?= $this->Time->nice($timezone->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __d('data', 'Active') ?></th>
                    <td><?= $this->Format->yesNo($timezone->active) ?> <?= $timezone->active ? __d('data', 'Yes') : __d('data', 'No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?= $this->element('Data.csp_confirm') ?>
