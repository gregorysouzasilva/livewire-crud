<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait ActionConfirmations
{
    // Run model actions
    public function actionConfirm($method, $id, $confirmation = null)
    {
        // if no confirmation is needed, just run the method
        if (empty($confirmation)) {
             $this->actionRunModel([$method, $id]);
             return;
        }
             // otherwise, show the confirmation modal
            $this->dispatchBrowserEvent(
                'swal:confirmModel', [
                 'type' => 'warning',
                 'title' => 'Are you sure?',
                 'text' => $confirmation,
                 'id' => $id,
                 'method' => $method,
                 'modelClass' => $this->modelClass ?? '',
                 ]
            );
    }
 
    public function actionRunModel($array)
    {
        if (!empty($array[2]) && $array[2] != $this->modelClass) {
            return;
        }
        $method = $array[0];
        $id = $array[1];
        $model = $this->modelClass::findOrFail($id);
 
        if (method_exists($model, $method)) {
            $this->canAction($method, $model);
            $model->{$method}($id);
            if (empty($model->errorMessage)) {
                $this->dispatchBrowserEvent(
                    'alert', [
                    'type' => 'success',  
                    'message' => substr($method, 2) . ' done!',   
                     ]
                );
            } else {
                $this->dispatchBrowserEvent(
                    'swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $model->errorMessage ?? 'Action not executed.',
                     ]
                );
            }
        } else {
            throw new \Exception('Method not found.');
        }
    }
 
    public function actionRun($array)
    {
        if (!empty($array['modelClass']) && $array['modelClass'] != $this->modelClass) {
            return;
        }
        if (method_exists($this, $array['method'])) {
            $this->{$array['method']}($array);
            if (empty($this->errorMessage)) {
                $this->dispatchBrowserEvent(
                    'alert', [
                    'type' => 'success',  
                    'message' => substr($array['method'], 2) . ' done!',   
                     ]
                );
            } else {
                $this->dispatchBrowserEvent(
                    'swal:modal', [
                    'type' => 'error',
                    'title' => 'Error',
                    'text' => $this->errorMessage ?? 'Action not executed.',
                     ]
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
        if (empty($this->pageInfo)) {
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
        $this->dispatchBrowserEvent(
            'swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure you want to reopen?',
            'text' => 'Reopen will unlock ' . $id . ' for client users editing for this person.',
            'data' => [
                'method' => 'onPageReopen',
                'id' => $id,
            ]
            ]
        );
    }

    public function confirmComplete($id)
    {
        $this->dispatchBrowserEvent(
            'swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure you want to complete?',
            'text' => 'Complete action will block ' . $id . ' from further editing for this person.',
            'data' => [
               'method' => 'onPageComplete',
                'id' => $id,
            ]
            ]
        );
    }

    public function deleteConfirm($id)
    {
        $this->dispatchBrowserEvent(
            'swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => 'you are about to delete this record',
            'data' => [
               'method' => 'onDelete',
                'id' => $id,
                'modelClass' => $this->modelClass ?? '',
            ]
            ]
        );
    }

}