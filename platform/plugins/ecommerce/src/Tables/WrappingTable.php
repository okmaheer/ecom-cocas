<?php

namespace Botble\Ecommerce\Tables;

use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Repositories\Interfaces\WrappingInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class WrappingTable extends TableAbstract
{
    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * WrappingTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param WrappingInterface $wrappingRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, WrappingInterface $wrappingRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $wrappingRepository;
    }


    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            'created_at',
            'status',
            'price',
            'image',
        ]);

        return $this->applyScopes($query);
    }
}
