<?php

namespace Gregorysouzasilva\LivewireCrud;

use App\Libs\Crud\Table;
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
use Livewire\Attributes\Locked;

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

    #[Locked]
    public string $viewPath = 'livewire.crud.';
    
    #[Locked]
    protected string $paginationTheme = 'bootstrap';

    public $model;
    protected $collection;

    public ?Client $client = null;

    public string $search = '';
    public array $filters = [];
    public array $conditionalFilters = [];
    public array $file = [];

    #[Locked]
    public array $pageInfo = [
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
        'export_link' => null,
    ];

    #[Locked]
    public Table $tableInfo;

    #[Locked]
    public array $pageHeader = [];

    public array $tableErrors = [];
    public bool $condensed = false;
    public bool $hideCreateButton = false;

    public ?string $clientUuid = null;

    public bool $showForm = false;
    public ?string $returnUrl = null;

    protected $queryString = ['filters', 'conditionalFilters', 'search', 'action'];

    protected $listeners = ['actionRun' => 'actionRun'];

    public string $sortField = '';
    public string $sortDirection = 'desc';
    public int $limit = 50;

    public function render()
    {
        $this->convertBooleanFilters();
        if (!$this->redirects()) {
            $this->loadData($this->limit);
        }
        $this->loadTable();
        $this->AddFiltersToPrintAndExport();

        return view($this->viewPath . 'index', ['collection' => $this->collection])
            ->layout('layout.demo6.master', ['pageInfo' => $this->pageInfo, 'pageHeader' => $this->pageHeader]);
    }


    public function sortBy($field)
    {
        $this->sortField = $field;
        $this->sortDirection = $this->sortDirection == 'desc' ? 'asc' : 'desc';
    }

    // public function loadClient() {
    //     $this->clientUuid = request()->route()->parameter('client_uuid') ?? null;
    //     if ($this->clientUuid) {
    //         $this->client = Client::where('uuid', $this->clientUuid)->firstOrFail();
    //         $this->routeParams['client_uuid'] = $this->clientUuid;
    //     }

    //     $contactUuid = request()->route()->parameter('contact_uuid') ?? null;
    //     if ($contactUuid) {
    //         $this->contact = ClientContact::where('client_id', $this->client->id)->where('uuid', $contactUuid)->firstOrFail();
    //         $this->routeParams['contact_uuid'] = $contactUuid;
    //     }

    //     $this->routeParams['returnUrl'] = request()->fullUrl();

    //     if (request()->has('returnUrl')) {
    //         $this->returnUrl = request('returnUrl');
    //     }
    // }

    public function loadRequests($parameters) {
        foreach($parameters as $parameter) {
            if (!empty(request($parameter))) {
                $this->$parameter = request($parameter);
            }
        }
    }

    public function redirects() {
        if (request('action') == 'create') {
            $this->create();
            return true;
        } else if ((request('action'))) {
            $this->edit(request('action'));
            return true;
        } else {
            $this->loadPage();
        }
    }

    public function backDashboard() {
        $service = $this->client->getDefaultService();
        return redirect()->route('clients.dashboard', ['client_uuid' => $this->client->uuid, 'service_id' => $service->id]);
    }

    public function convertBooleanFilters() {
        if (!empty($this->filters)) {
            foreach($this->filters as $key => $value) {
                // if value is array
                if (is_array($value)) {
                    foreach($value as $k => $v) {
                        if ($v == 'true') {
                            $this->filters[$key][$k] = true;
                        } else if ($v == 'false') {
                            $this->filters[$key][$k] = false;
                        }
                    }
                } else {
                    if ($value == 'true') {
                        $this->filters[$key] = true;
                    } else if ($value == 'false') {
                        $this->filters[$key] = false;
                    }
                }
            }
        }

        if (!empty($this->conditionalFilters)) {
            foreach($this->conditionalFilters as $key => $value) {
                // if value is array
                if (is_array($value)) {
                    foreach($value as $k => $v) {
                        if ($v == 'true') {
                            $this->conditionalFilters[$key][$k] = true;
                        } else if ($v == 'false') {
                            $this->conditionalFilters[$key][$k] = false;
                        }
                    }
                } else {
                    if ($value == 'true') {
                        $this->conditionalFilters[$key] = true;
                    } else if ($value == 'false') {
                        $this->conditionalFilters[$key] = false;
                    }
                }
            }
        }
    }

    public function AddFiltersToPrintAndExport() {
        if (!empty($this->pageInfo['print_link'])) {
            // merge array of filters and conditional filters content
            $this->pageInfo['print_url'] = $this->pageInfo['print_link'] . '?' . http_build_query(array_merge($this->filters ?? [], $this->conditionalFilters ?? []));
        }
        if (!empty($this->pageInfo['export_link'])) {
            $this->pageInfo['export_url'] = $this->pageInfo['export_link'] . '?' . http_build_query(array_merge($this->filters ?? [], $this->conditionalFilters ?? []));
        }
    }
}