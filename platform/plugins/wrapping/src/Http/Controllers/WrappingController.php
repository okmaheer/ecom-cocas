<?php

namespace Botble\Wrapping\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Wrapping\Http\Requests\WrappingRequest;
use Botble\Wrapping\Repositories\Interfaces\WrappingInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Botble\Wrapping\Tables\WrappingTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Wrapping\Forms\WrappingForm;
use Botble\Base\Forms\FormBuilder;
use Illuminate\View\View;
use Throwable;

class WrappingController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var WrappingInterface
     */
    protected $wrappingRepository;

    /**
     * WrappingController constructor.
     * @param WrappingInterface $wrappingRepository
     */
    public function __construct(WrappingInterface $wrappingRepository)
    {
        $this->wrappingRepository = $wrappingRepository;
    }

    /**
     * @param WrappingTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(WrappingTable $table)
    {

        page_title()->setTitle(trans('plugins/wrapping::wrapping.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/wrapping::wrapping.create'));

        return $formBuilder->create(WrappingForm::class)->renderForm();
    }

    /**
     * @param WrappingRequest $request
     * @return BaseHttpResponse
     */
    public function store(WrappingRequest $request, BaseHttpResponse $response)
    {
        $wrapping = $this->wrappingRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(WRAPPING_MODULE_SCREEN_NAME, $request, $wrapping));

        return $response
            ->setPreviousUrl(route('wrapping.index'))
            ->setNextUrl(route('wrapping.edit', $wrapping->id))
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
        $wrapping = $this->wrappingRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $wrapping));

        page_title()->setTitle(trans('plugins/wrapping::wrapping.edit') . ' "' . $wrapping->name . '"');

        return $formBuilder->create(WrappingForm::class, ['model' => $wrapping])->renderForm();
    }

    /**
     * @param $id
     * @param WrappingRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, WrappingRequest $request, BaseHttpResponse $response)
    {
        $wrapping = $this->wrappingRepository->findOrFail($id);

        $wrapping->fill($request->input());

        $this->wrappingRepository->createOrUpdate($wrapping);

        event(new UpdatedContentEvent(WRAPPING_MODULE_SCREEN_NAME, $request, $wrapping));

        return $response
            ->setPreviousUrl(route('wrapping.index'))
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
            $wrapping = $this->wrappingRepository->findOrFail($id);

            $this->wrappingRepository->delete($wrapping);

            event(new DeletedContentEvent(WRAPPING_MODULE_SCREEN_NAME, $request, $wrapping));

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
        return $this->executeDeleteItems($request, $response, $this->wrappingRepository,
            WRAPPING_MODULE_SCREEN_NAME);
    }
}
