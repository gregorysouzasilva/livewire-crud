<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait ActionConfirmations
{
    public function actionConfirm($method, $id, $confirmation = null)
    {
        // if no confirmation is needed, just run the method
        if (empty($confirmation)) {
             $this->actionRunModel($method, $id);
             return;
        }
            $this->confirmModel(
                type: 'warning',
                title: 'Are you sure?',
                message: $confirmation,
                id: $id,
                method: $method,
                modelClass: $this->modelClass ?? ''
            );
    }
 
     // Run model actions
    public function actionRunModel($method, $id, $modelClass = null)
    {
        if (!empty($modelClass) && str_replace('\\', '', $modelClass) != str_replace('\\', '', $this->modelClass)) {
             return;
        }
 
        $model = $this->modelClass::findOrFail($id);
        if (method_exists($model, $method)) {
            $this->canAction($method, $model);
            $model->{$method}($id);
            if (empty($model->errorMessage)) {
                $this->toastr(
                    type: 'success',
                    title: 'Success',  
                    message: substr($method, 2) . ' done!',   
                );
            } else {
                $this->toastr(
                    type: 'error',  
                    title: 'Error',
                    message: $model->errorMessage ?? 'Action not executed.', 
                );
            }
        } else {
            throw new \Exception('Method not found.');
        }
    }
 
    public function actionRun($method, $id, $modelClass = null)
    {
        if (!empty($modelClass) && str_replace('\\', '', $modelClass) != str_replace('\\', '', $this->modelClass)) {
             return;
        }
        if (method_exists($this, $method)) {
            $response = $this->{$method}(['id' => $id]);
            if (empty($response->errorMessage)) {
                $this->toastr(
                    type: 'success',
                    title: 'Success',
                    message: substr($method, 2) . ' done!',   
                );
            } else {
                $this->toastr(
                    type: 'error',  
                    title: 'Error',
                    message: $response->errorMessage ?? 'Action not executed.', 
                );
            }
        } else {
            throw new \Exception('Method not found.');
        }
    }

    public function canAction($action, $model = null)
    {
        if (!$model) {
            $model = $this->model;
        }

        // if action is integer, it's id, return true
        if (is_numeric($action)) {
            return true;
        }
        if (empty($this->pageInfo['title'])) {
            $this->loadPage();
        }
        // for now just model actions are supported
        if ($model->evalTags($this->pageInfo['permissions'][$action] ?? false)) {
            return true;
        }
        // check if it's action from buttons and if role is set check it
        $button = collect($this->pageInfo['table']['buttons'] ?? [])->firstWhere('action', $action);
        if ($button && $model->evalTags($button['show'] ?? false) && hasRole($button['role'] ?? '')) {
            return true;
        }
        abort(403, 'Unauthorized action.');
    }

    public function confirmReopen($id)
    {
        $this->confirm(
            type: 'warning',
            title: 'Are you sure you want to reopen?',
            message: 'Reopen will unlock ' . $id . ' for client users editing for this person.',
            method: 'onPageReopen',
            id: $id,
        );
    }

    public function confirmComplete($id)
    {
        $this->confirm(
            type: 'warning',
            title: 'Are you sure you want to complete?',
            message: 'Complete action will block ' . $id . ' from further editing for this person.',
            method: 'onPageComplete',
            id: $id,
       );
    }

    public function deleteConfirm($id)
    {
        $this->confirm( 
            type: 'warning',
            title: 'Are you sure?',
            message: 'you are about to delete this record',
            method: 'onDelete',
            id: $id,
            modelClass: $this->modelClass ?? '',
        );
    }
}