<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Data\Model\Entity\Currency> $currencies
 */
?>
<div class="currencies index content large-9 medium-8 columns col-12">
    <h1><?= __('Currencies') ?></h1>

    <div class="">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('symbol_left') ?></th>
                    <th><?= $this->Paginator->sort('symbol_right') ?></th>
                    <th><?= $this->Paginator->sort('decimal_places') ?></th>
                    <th><?= $this->Paginator->sort('value') ?></th>
                    <th><?= $this->Paginator->sort('base') ?></th>
                    <th><?= $this->Paginator->sort('active') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($currencies as $currency): ?>
                <tr>
                    <td><?= h($currency->name) ?></td>
                    <td><?= h($currency->code) ?></td>
                    <td><?= h($currency->symbol_left) ?></td>
                    <td><?= h($currency->symbol_right) ?></td>
                    <td><?= h($currency->decimal_places) ?></td>
                    <td><?= $this->Number->format($currency->value) ?></td>
                    <td><?= $this->Format->yesNo($currency->base) ?></td>
                    <td><?= $this->Format->yesNo($currency->active) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php echo $this->element('Tools.pagination'); ?>
</div>
