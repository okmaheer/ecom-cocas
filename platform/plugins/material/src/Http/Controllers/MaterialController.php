<?php

namespace Botble\Material\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Material\Http\Requests\MaterialRequest;
use Botble\Material\Repositories\Interfaces\MaterialInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Botble\Material\Tables\MaterialTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Material\Forms\MaterialForm;
use Botble\Base\Forms\FormBuilder;
use Illuminate\View\View;
use Throwable;

class MaterialController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var MaterialInterface
     */
    protected $materialRepository;

    /**
     * MaterialController constructor.
     * @param MaterialInterface $materialRepository
     */
    public function __construct(MaterialInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * @param MaterialTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(MaterialTable $table)
    {

        page_title()->setTitle(trans('plugins/material::material.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/material::material.create'));

        return $formBuilder->create(MaterialForm::class)->renderForm();
    }

    /**
     * @param MaterialRequest $request
     * @return BaseHttpResponse
     */
    public function store(MaterialRequest $request, BaseHttpResponse $response)
    {
        $material = $this->materialRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(MATERIAL_MODULE_SCREEN_NAME, $request, $material));

        return $response
            ->setPreviousUrl(route('material.index'))
            ->setNextUrl(route('material.edit', $material->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $material = $this->materialRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $material));

        page_title()->setTitle(trans('plugins/material::material.edit') . ' "' . $material->name . '"');

        return $formBuilder->create(MaterialForm::class, ['model' => $material])->renderForm();
    }

    /**
     * @param $id
     * @param MaterialRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, MaterialRequest $request, BaseHttpResponse $response)
    {
        $material = $this->materialRepository->findOrFail($id);

        $material->fill($request->input());

        $this->materialRepository->createOrUpdate($material);

        event(new UpdatedContentEvent(MATERIAL_MODULE_SCREEN_NAME, $request, $material));

        return $response
            ->setPreviousUrl(route('material.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $material = $this->materialRepository->findOrFail($id);

            $this->materialRepository->delete($material);

            event(new DeletedContentEvent(MATERIAL_MODULE_SCREEN_NAME, $request, $material));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->materialRepository,
            MATERIAL_MODULE_SCREEN_NAME);
    }
}
