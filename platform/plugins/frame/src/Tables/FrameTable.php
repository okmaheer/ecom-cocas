<?php

namespace Botble\Frame\Tables;

use BaseHelper;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Frame\Repositories\Interfaces\FrameInterface;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FrameTable extends TableAbstract
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
     * FrameTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param FrameInterface $frameRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        FrameInterface $frameRepository
    ) {
        parent::__construct($table, $urlGenerator);

        $this->repository = $frameRepository;

        if (!Auth::user()->hasAnyPermission(['frame.edit', 'frame.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('image', function ($item) {
                return $this->displayThumbnail($item->image, ['width' => 70]);
            })
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('frame.edit')) {
                    return $item->name;
                }

                return Html::link(route('frame.edit', $item->id), $item->name);
            })
			 ->editColumn('price', function ($item) {
                return Html::link(route('frame.edit', $item->id), '₹'.number_format($item->price,2));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->addColumn('operations', function ($item) {
                return table_actions('frame.edit', 'frame.destroy', $item);
            });

        return $this->toJson($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
			'price',
            'created_at',
            'image',
        ]);

        return $this->applyScopes($query);
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id'         => [
                'title' => trans('core/base::tables.id'),
                'width' => '100px',
            ],
            'image'      => [
                'title' => trans('core/base::tables.image'),
                'width' => '100px',
            ],
            'name'       => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
			'price'       => [
                'title' => 'Price',
                'class' => 'text-left',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        return $this->addCreateButton(route('frame.create'), 'frame.create');
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('frame.deletes'), 'frame.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
