<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait UpdatePageTrait {

    public function addTableButton($page, $button) {
        $button = array_merge($this->buttonsDefault, $button);
        $page['tabela']['buttons'][] = $button;
        return $page;
    }
}