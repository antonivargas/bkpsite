<section id="main">
    <div class="page-header">
        <h2><?= t('Project access list for "%s"', $project['name']) ?></h2>
        <ul>
            <li><a href="?controller=project"><?= t('All projects') ?></a></li>
        </ul>
    </div>
    <section>

    <?php if (! empty($users['not_allowed'])): ?>
        <form method="post" action="?controller=project&amp;action=allow&amp;project_id=<?= $project['id'] ?>" autocomplete="off">

            <?= Helper\form_hidden('project_id', array('project_id' => $project['id'])) ?>

            <?= Helper\form_label(t('User'), 'user_id') ?>
            <?= Helper\form_select('user_id', $users['not_allowed']) ?><br/>

            <div class="form-actions">
                <input type="submit" value="<?= t('Allow this user') ?>" class="btn btn-blue"/>
                <?= t('or') ?> <a href="?controller=project"><?= t('cancel') ?></a>
            </div>
        </form>
    <?php endif ?>

    <h3><?= t('List of authorized users') ?></h3>
    <?php if (empty($users['allowed'])): ?>
        <div class="alert alert-info"><?= t('Everybody have access to this project.') ?></div>
    <?php else: ?>
    <div class="listing">
        <p><?= t('Only those users have access to this project:') ?></p>
        <ul>
        <?php foreach ($users['allowed'] as $user_id => $username): ?>
            <li>
                <strong><?= Helper\escape($username) ?></strong>
                (<a href="?controller=project&amp;action=revoke&amp;project_id=<?= $project['id'] ?>&amp;user_id=<?= $user_id ?>"><?= t('revoke') ?></a>)
            </li>
        <?php endforeach ?>
        </ul>
        <p><?= t('Don\'t forget that administrators have access to everything.') ?></p>
    </div>
    <?php endif ?>

    </section>
</section>