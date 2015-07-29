<?php

namespace Controller;

require_once __DIR__.'/base.php';

/**
 * Automatic actions management
 *
 * @package controller
 * @author  Frederic Guillot
 */
class Action extends Base
{
    /**
     * List of automatic actions for a given project
     *
     * @access public
     */
    public function index()
    {
        $project_id = $this->request->getIntegerParam('project_id');
        $project = $this->project->getById($project_id);

        if (! $project) {
            $this->session->flashError(t('Project not found.'));
            $this->response->redirect('?controller=project');
        }

        $this->response->html($this->template->layout('action_index', array(
            'values' => array('project_id' => $project['id']),
            'project' => $project,
            'actions' => $this->action->getAllByProject($project['id']),
            'available_actions' => $this->action->getAvailableActions(),
            'available_events' => $this->action->getAvailableEvents(),
            'available_params' => $this->action->getAllActionParameters(),
            'columns_list' => $this->board->getColumnsList($project['id']),
            'users_list' => $this->project->getUsersList($project['id'], false),
            'projects_list' => $this->project->getList(false),
            'colors_list' => $this->task->getColors(),
            'menu' => 'projects',
            'title' => t('Automatic actions')
        )));
    }

    /**
     * Define action parameters (step 2)
     *
     * @access public
     */
    public function params()
    {
        $project_id = $this->request->getIntegerParam('project_id');
        $project = $this->project->getById($project_id);

        if (! $project) {
            $this->session->flashError(t('Project not found.'));
            $this->response->redirect('?controller=project');
        }

        $values = $this->request->getValues();
        $action = $this->action->load($values['action_name'], $values['project_id']);

        $this->response->html($this->template->layout('action_params', array(
            'values' => $values,
            'action_params' => $action->getActionRequiredParameters(),
            'columns_list' => $this->board->getColumnsList($project['id']),
            'users_list' => $this->project->getUsersList($project['id'], false),
            'projects_list' => $this->project->getList(false),
            'colors_list' => $this->task->getColors(),
            'project' => $project,
            'menu' => 'projects',
            'title' => t('Automatic actions')
        )));
    }

    /**
     * Create a new action (last step)
     *
     * @access public
     */
    public function create()
    {
        $project_id = $this->request->getIntegerParam('project_id');
        $project = $this->project->getById($project_id);

        if (! $project) {
            $this->session->flashError(t('Project not found.'));
            $this->response->redirect('?controller=project');
        }

        $values = $this->request->getValues();

        list($valid, $errors) = $this->action->validateCreation($values);

        if ($valid) {

            if ($this->action->create($values)) {
                $this->session->flash(t('Your automatic action have been created successfully.'));
            }
            else {
                $this->session->flashError(t('Unable to create your automatic action.'));
            }
        }

        $this->response->redirect('?controller=action&action=index&project_id='.$project['id']);
    }

    /**
     * Confirmation dialog before removing an action
     *
     * @access public
     */
    public function confirm()
    {
        $this->response->html($this->template->layout('action_remove', array(
            'action' => $this->action->getById($this->request->getIntegerParam('action_id')),
            'available_events' => $this->action->getAvailableEvents(),
            'available_actions' => $this->action->getAvailableActions(),
            'menu' => 'projects',
            'title' => t('Remove an action')
        )));
    }

    /**
     * Remove an action
     *
     * @access public
     */
    public function remove()
    {
        $action = $this->action->getById($this->request->getIntegerParam('action_id'));

        if ($action && $this->action->remove($action['id'])) {
            $this->session->flash(t('Action removed successfully.'));
        } else {
            $this->session->flashError(t('Unable to remove this action.'));
        }

        $this->response->redirect('?controller=action&action=index&project_id='.$action['project_id']);
    }
}
