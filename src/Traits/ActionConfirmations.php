<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait ActionConfirmations
{
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
        if ($button && $model->evalTags($button['show'] ?? false) 
            && (!empty($button['role']) && hasRole($button['role'] ?? '') || empty($button['role'])) ) {
            return true;
        }
        abort(403, 'Unauthorized action.');
    }
}