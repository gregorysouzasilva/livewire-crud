<?php

namespace Gregorysouzasilva\LivewireCrud;

use App\Livewire\BaseComponent;
use Gregorysouzasilva\LivewireCrud\Traits\FormTrait;
use Gregorysouzasilva\LivewireCrud\Traits\LoadData;
use Gregorysouzasilva\LivewireCrud\Traits\ModalTrait;
use Gregorysouzasilva\LivewireCrud\Traits\ModelActionsTrait;
use App\Models\Client;
use App\Models\ClientContact;
use App\Models\Service;
use Livewire\WithPagination;
use Gregorysouzasilva\LivewireCrud\Traits\RowsTrait;
use Gregorysouzasilva\LivewireCrud\Traits\CustomValidations;

class Crud extends BaseComponent
{
    use WithPagination,
        ModelActionsTrait,
        ModalTrait,
        LoadData,
        CustomValidations,
        RowsTrait,
        FormTrait;

    public $viewPath = 'livewire.crud.';
    protected $paginationTheme = 'bootstrap';

    public $model;
    protected $collection;

    public $search = '';
    public $filters;
    public $conditionalFilters;
    public $file = [];

    public $pageInfo = [];
    public $tableInfo = [];
    public $condensed = false;
    public $hideCreateButton = false;
    public $routeParams = [];

    public $clientId = null;
    public $clientUuid = null;
    public $serviceId = null;
    public $client = null;
    public $contact = null;
    public $service = null;

    public $showForm = false;
    public $returnUrl;

    protected $queryString = ['filters', 'conditionalFilters', 'search'];

    protected $listeners = ['actionRunModel' => 'actionRunModel', 'actionRun' => 'actionRun'];

    public $sortField = '';
    public $sortDirection = 'desc';
    public $limit = 50;

    public function mount()
    {   
        $this->model = new $this->tela['model_class'];
        $this->modelClass = $this->tela['model_class'];

        $this->loadClient();
    }

    public function render()
    {
        $this->Redirects();
        $this->loadPage();
        $this->loadData($this->limit);
        $this->loadTable();

        return view($this->viewPath . 'index', ['collection' => $this->collection])
            ->layout('layout.demo6.master', ['client' => $this->client, 'contact' => $this->contact, 'pageInfo' => $this->pageInfo]);
    }


    public function sortBy($field)
    {
        $this->sortField = $field;
        $this->sortDirection = $this->sortDirection == 'desc' ? 'asc' : 'desc';
    }

    public function loadClient() {
        $this->clientUuid = request()->route()->parameter('client_uuid') ?? null;
        if ($this->clientUuid) {
            $this->client = Client::where('uuid', $this->clientUuid)->firstOrFail();
            $this->clientId = $this->client->id;
            $this->routeParams['client_uuid'] = $this->clientUuid;
        }

        $contactUuid = request()->route()->parameter('contact_uuid') ?? null;
        if ($contactUuid) {
            $this->contact = ClientContact::where('client_id', $this->client->id)->where('uuid', $contactUuid)->firstOrFail();
            $this->routeParams['contact_uuid'] = $contactUuid;
        }
    }

    public function loadRequests($parameters) {
        foreach($parameters as $parameter) {
            if (!empty(request($parameter))) {
                $this->$parameter = request($parameter);
                if ($parameter == 'client_id') {
                    $this->client = Client::where('id', $this->client_id)->select(['uuid', 'name'])->firstOrFail();
                }
            }
        }
    }

    public function Redirects() {
        if (request('action') == 'create') {
            $this->create();
        } else if ((request('action'))) {
            $this->edit(request('action'));
        }
    }

    public function backDashboard() {
        $service = $this->client->getDefaultService();
        return redirect()->route('clients.dashboard', ['client_uuid' => $this->client->uuid, 'service_id' => $service->id]);
    }
}