<?php

namespace Gregorysouzasilva\LivewireCrud\Traits;

trait ModalTrait {

    public $useModal = false;
    
    public function openModalPopover($modal = 'create')
    {
        $this->modal = $modal;
        $this->isModalOpen = true;
        $this->emit('showBootstrapModal');
    }
    
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
        $this->emit('hideModal');
    }
}
