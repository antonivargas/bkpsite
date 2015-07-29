<section id="main">
    <div class="page-header">
        <h2><?= t('Automatic actions for the project "%s"', $project['name']) ?></h2>
        <ul>
            <li><a href="?controller=project"><?= t('All projects') ?></a></li>
        </ul>
    </div>
    <section>

    <?php if (! empty($actions)): ?>

    <h3><?= t('Defined actions') ?></h3>
    <table>
        <tr>
            <th><?= t('Event name') ?></th>
            <th><?= t('Action name') ?></th>
            <th><?= t('Action parameters') ?></th>
            <th><?= t('Action') ?></th>
        </tr>

        <?php foreach ($actions as $action): ?>
        <tr>
            <td><?= Helper\in_list($action['event_name'], $available_events) ?></td>
            <td><?= Helper\in_list($action['action_name'], $available_actions) ?></td>
            <td>
                <ul>
                <?php foreach ($action['params'] as $param): ?>
                    <li>
                        <?= Helper\in_list($param['name'], $available_params) ?> =
                        <strong>
                        <?php if (Helper\contains($param['name'], 'column_id')): ?>
                            <?= Helper\in_list($param['value'], $columns_list) ?>
                        <?php elseif (Helper\contains($param['name'], 'user_id')): ?>
                            <?= Helper\in_list($param['value'], $users_list) ?>
                        <?php elseif (Helper\contains($param['name'], 'project_id')): ?>
                            <?= Helper\in_list($param['value'], $projects_list) ?>
                        <?php elseif (Helper\contains($param['name'], 'color_id')): ?>
                            <?= Helper\in_list($param['value'], $colors_list) ?>
                        <?php endif ?>
                        </strong>
                    </li>
                <?php endforeach ?>
                </ul>
            </td>
            <td>
                <a href="?controller=action&amp;action=confirm&amp;action_id=<?= $action['id'] ?>"><?= t('Remove') ?></a>
            </td>
        </tr>
        <?php endforeach ?>

    </table>

    <?php endif ?>

    <h3><?= t('Add an action') ?></h3>
    <form method="post" action="?controller=action&amp;action=params&amp;project_id=<?= $project['id'] ?>" autocomplete="off">

        <?= Helper\form_hidden('project_id', $values) ?>

        <?= Helper\form_label(t('Event'), 'event_name') ?>
        <?= Helper\form_select('event_name', $available_events, $values) ?><br/>

        <?= Helper\form_label(t('Action'), 'action_name') ?>
        <?= Helper\form_select('action_name', $available_actions, $values) ?><br/>

        <div class="form-help">
            <?= t('When the selected event occurs execute the corresponding action.') ?>
        </div>

        <div class="form-actions">
            <input type="submit" value="<?= t('Next step') ?>" class="btn btn-blue"/>
        </div>
    </form>
    </section>
</section>