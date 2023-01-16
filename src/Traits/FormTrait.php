<?php
namespace Gregorysouzasilva\LivewireCrud\Traits;

trait FormTrait {
    public function clearForm() {
        $this->emit('clearForm');
    }
}