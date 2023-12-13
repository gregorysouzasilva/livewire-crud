<?php

namespace Gregorysouzasilva\LivewireCrud;

use App\Livewire\BaseComponent;
use App\Models\Client;
use App\Models\ClientContact;
use Gregorysouzasilva\LivewireCrud\Traits\ActionConfirmations;
use Gregorysouzasilva\LivewireCrud\Traits\CustomValidations;
use Gregorysouzasilva\LivewireCrud\Traits\FormTrait;
use Gregorysouzasilva\LivewireCrud\Traits\LoadData;
use Gregorysouzasilva\LivewireCrud\Traits\ModalTrait;
use Gregorysouzasilva\LivewireCrud\Traits\ModelActionsTrait;
use Gregorysouzasilva\LivewireCrud\Traits\RowsTrait;
use Livewire\WithPagination;

class Crud extends BaseComponent
{
    use WithPagination,
        ModelActionsTrait,
        ActionConfirmations,
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

    public $pageInfo = [
        'title' => '',
        'permissions' => [
            'create' => false,
            'edit' => false,
            'table'=> false,
            'delete' => false,
            'duplicate' => false,
            'archive' => false,
            'complete' => false,
            'print' => false,
        ],
        'table' => [
            'search_fields' => [],
            'buttons' => [
                [
                    'show' => false,
                    'action' => '',
                    'icon' => '',
                    'label' => '',
                ],
            ],
            'show_id' => false,
        ],
        'is_editable' => false,
        'print_link' => null,
    ];
    
    public $tableErrors = [];
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
        $this->redirects();
        $this->loadData($this->limit);
        $this->loadTable();
        // $this->prepareModelJsonFields();

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

        $this->routeParams['returnUrl'] = request()->fullUrl();

        if (request()->has('returnUrl')) {
            $this->returnUrl = request('returnUrl');
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

    public function redirects() {
        if (request('action') == 'create') {
            $this->create();
        } else if ((request('action'))) {
            $this->edit(request('action'));
        } else {
            $this->loadPage();
        }
    }

    public function backDashboard() {
        $service = $this->client->getDefaultService();
        return redirect()->route('clients.dashboard', ['client_uuid' => $this->client->uuid, 'service_id' => $service->id]);
    }
}