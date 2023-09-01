<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait ModalTrait {

    public $useModal = false;
    
    public function openModalPopover($modal = 'create')
    {
        $this->modal = $modal;
        $this->isModalOpen = true;
        $this->dispatch('showBootstrapModal');
    }
    
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
        $this->dispatch('hideModal');
    }
}
