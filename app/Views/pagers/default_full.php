<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            </li>
        <?php else : ?>
            <li class="disabled">
                <span aria-hidden="true">&laquo;</span>
            </li>
            <li class="disabled">
                <span aria-hidden="true">&lsaquo;</span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li <?= $link['active'] ? 'class="active"' : '' ?>>
                <a href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        <?php else : ?>
            <li class="disabled">
                <span aria-hidden="true">&rsaquo;</span>
            </li>
            <li class="disabled">
                <span aria-hidden="true">&raquo;</span>
            </li>
        <?php endif ?>
    </ul>
</nav>