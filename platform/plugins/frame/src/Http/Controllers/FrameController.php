<?php

namespace Botble\Frame\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Frame\Http\Requests\FrameRequest;
use Botble\Frame\Repositories\Interfaces\FrameInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Botble\Frame\Tables\FrameTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Frame\Forms\FrameForm;
use Botble\Base\Forms\FormBuilder;
use Illuminate\View\View;
use Throwable;

class FrameController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var FrameInterface
     */
    protected $frameRepository;

    /**
     * FrameController constructor.
     * @param FrameInterface $frameRepository
     */
    public function __construct(FrameInterface $frameRepository)
    {
        $this->frameRepository = $frameRepository;
    }

    /**
     * @param FrameTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(FrameTable $table)
    {

        page_title()->setTitle(trans('plugins/frame::frame.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/frame::frame.create'));

        return $formBuilder->create(FrameForm::class)->renderForm();
    }

    /**
     * @param FrameRequest $request
     * @return BaseHttpResponse
     */
    public function store(FrameRequest $request, BaseHttpResponse $response)
    {
        $frame = $this->frameRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(FRAME_MODULE_SCREEN_NAME, $request, $frame));

        return $response
            ->setPreviousUrl(route('frame.index'))
            ->setNextUrl(route('frame.edit', $frame->id))
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
        $frame = $this->frameRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $frame));

        page_title()->setTitle(trans('plugins/frame::frame.edit') . ' "' . $frame->name . '"');

        return $formBuilder->create(FrameForm::class, ['model' => $frame])->renderForm();
    }

    /**
     * @param $id
     * @param FrameRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, FrameRequest $request, BaseHttpResponse $response)
    {
        $frame = $this->frameRepository->findOrFail($id);

        $frame->fill($request->input());

        $this->frameRepository->createOrUpdate($frame);

        event(new UpdatedContentEvent(FRAME_MODULE_SCREEN_NAME, $request, $frame));

        return $response
            ->setPreviousUrl(route('frame.index'))
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
            $frame = $this->frameRepository->findOrFail($id);

            $this->frameRepository->delete($frame);

            event(new DeletedContentEvent(FRAME_MODULE_SCREEN_NAME, $request, $frame));

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
        return $this->executeDeleteItems($request, $response, $this->frameRepository,
            FRAME_MODULE_SCREEN_NAME);
    }
}
