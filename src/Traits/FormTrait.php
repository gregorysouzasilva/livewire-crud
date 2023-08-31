<?php
namespace Gregorysouzasilva\LivewireCrud\Traits;

trait FormTrait {
    // cannot be using when closing the modal or form. Using just on comment.
    public function clearForm() {
        $this->emit('clearForm');
    }
}