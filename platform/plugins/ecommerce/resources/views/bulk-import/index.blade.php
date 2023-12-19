@extends('core/base::layouts.master')
@section('content')
    {!! Form::open(['class' => 'form-import-data', 'files' => 'true']) !!}
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-sm-12">
                <div class="alert alert-warning alert-dismissible my-2 hidden fade show" role="alert" data-alert-id="bulk-import">
                    <strong>{{ trans('plugins/ecommerce::bulk-import.note') }}</strong>
                    <span>{{ trans('plugins/ecommerce::bulk-import.warning_before_importing') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="widget meta-boxes">
                    <div class="widget-title pl-2">
                        <h4>{{ trans('plugins/ecommerce::bulk-import.menu') }}</h4>
                    </div>
                    <div class="widget-body">
                        <div class="form-group @if ($errors->has('type')) has-error @endif">
                            <label class="control-label required" for="type">
                                {{ __('Type') }}
                            </label>
                            {!! Form::customSelect('type', [
                                'all'        => __('All'),
                                'products'   => __('Products'),
                                'variations' => __('Variations')
                            ], null, ['required' => true]) !!}
                            {!! Form::error('type', $errors) !!}
                        </div>
                        <div class="form-group @if ($errors->has('file')) has-error @endif">
                            <label class="control-label required" for="input-group-file">
                                {{ trans('plugins/ecommerce::bulk-import.choose_file')}}
                            </label>
                            <div class="custom-file">
                                {!! Form::file('file', [
                                    'required'         => true,
                                    'class'            => 'custom-file-input',
                                    'id'               => 'input-group-file',
                                    'aria-describedby' => 'input-group-addon',
                                ]) !!}
                                <label class="custom-file-label" id="custom-file-label" for="input-group-file">
                                    {{ trans('plugins/ecommerce::bulk-import.choose_file_with_mime', ['types' =>  implode(', ', config('plugins.ecommerce.general.bulk-import.mimes', []))])}}
                                </label>
                            </div>
                            {!! Form::error('file', $errors) !!}
                            <div class="mt-3 text-center p-2 border bg-light">
                                <a href="#" class="download-template"
                                    data-url="{{ route('ecommerce.bulk-import.download-template') }}"
                                    data-extension="csv"
                                    data-filename="template_products_import.csv"
                                    data-downloading="<i class='fas fa-spinner fa-spin'></i> {{ trans('plugins/ecommerce::bulk-import.downloading') }}">
                                    <i class="fas fa-file-csv"></i>
                                    {{ trans('plugins/ecommerce::bulk-import.download-csv-file') }}
                                </a> &nbsp; | &nbsp;
                                <a href="#" class="download-template"
                                    data-url="{{ route('ecommerce.bulk-import.download-template') }}"
                                    data-extension="xlsx"
                                    data-filename="template_products_import.xlsx"
                                    data-downloading="<i class='fas fa-spinner fa-spin'></i> {{ trans('plugins/ecommerce::bulk-import.downloading') }}">
                                    <i class="fas fa-file-excel"></i>
                                    {{ trans('plugins/ecommerce::bulk-import.download-excel-file') }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"
                                    data-choose-file="{{ trans('plugins/ecommerce::bulk-import.please_choose_the_file')}}"
                                    data-loading-text="{{ trans('plugins/ecommerce::bulk-import.loading_text') }}"
                                    data-complete-text="{{ trans('plugins/ecommerce::bulk-import.imported_successfully') }}"
                                    id="input-group-addon">
                                {{ trans('plugins/ecommerce::bulk-import.start_import') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="hidden main-form-message">
                    <p id="imported-message"></p>
                    <div class="show-errors hidden">
                        <h3 class="text-warning text-center">{{ trans('plugins/ecommerce::bulk-import.failures') }}</h3>
                        <ul id="imported-listing"></ul>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="widget meta-boxes">
        <div class="widget-title pl-2">
            <h4 class="text-info">{{ trans('plugins/ecommerce::bulk-import.template') }}</h4>
        </div>
        <div class="widget-body">
            <div class="table-responsive">
                <table class="table text-left table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Categories</th>
                        <th scope="col">Status</th>
                        <th scope="col">Is featured?</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Product collections</th>
                        <th scope="col">Labels</th>
                        <th scope="col">Tax</th>
                        <th scope="col">Images</th>
                        <th scope="col">Price</th>
                        <th scope="col">Product Attributes</th>
                        <th scope="col">Import type</th>
                        <th scope="col">Is Variation Default?</th>
                        <th scope="col">With storehouse management?</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Allow checkout when out of stock?</th>
                        <th scope="col">Stock Status</th>
                        <th scope="col">Sale price</th>
                        <th scope="col">Start date sale off</th>
                        <th scope="col">End date sale off</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Length</th>
                        <th scope="col">Wide</th>
                        <th scope="col">Height</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lettuce - Baby Salad Greens</td>
                            <td>Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.</td>
                            <td></td>
                            <td>2,3</td>
                            <td>published</td>
                            <td>1</td>
                            <td>Pure</td>
                            <td>1</td>
                            <td></td>
                            <td>VAT</td>
                            <td></td>
                            <td>12</td>
                            <td>Size,Color</td>
                            <td>product</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td>Lettuce - Baby Salad Greens</td>
                            <td>Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim.</td>
                            <td></td>
                            <td>2,3</td>
                            <td>published</td>
                            <td></td>
                            <td>Pure</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>14</td>
                            <td>Size:S,Color:Black</td>
                            <td>variation</td>
                            <td>1</td>
                            <td>1</td>
                            <td>20</td>
                            <td>true</td>
                            <td>in_stock</td>
                            <td>11</td>
                            <td>2021-08-06 01:00:00</td>
                            <td>2021-09-06 01:00:00</td>
                            <td>20</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <td>Soup - Campbells, Minestrone</td>
                            <td>In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.</td>
                            <td></td>
                            <td>4,5</td>
                            <td>pending</td>
                            <td>1</td>
                            <td>Automotive</td>
                            <td></td>
                            <td></td>
                            <td>None</td>
                            <td></td>
                            <td>15</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>0</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>30</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="widget meta-boxes mt-4">
        <div class="widget-title pl-2">
            <h4 class="text-info">{{ trans('plugins/ecommerce::bulk-import.rules') }}</h4>
        </div>
        <div class="widget-body">
            <table class="table text-left table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Column</th>
                        <th scope="col">Rules</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Product Name</th>
                        <td>(required)</td>
                    </tr>
                    <tr>
                        <th scope="row">Description</th>
                        <td>(nullable)</td>
                    </tr>
                    <tr>
                        <th scope="row">Slug</th>
                        <td>(nullable)</td>
                    </tr>
                    <tr>
                        <th scope="row">Categories</th>
                        <td>(nullable|multiple)</td>
                    </tr>
                    <tr>
                        <th scope="row">Status</th>
                        <td>(required|enum:{{ implode(',', Botble\Base\Enums\BaseStatusEnum::values()) }}|default:{{ Botble\Base\Enums\BaseStatusEnum::PENDING }})</td>
                    </tr>
                    <tr>
                        <th scope="row">Is featured?</th>
                        <td>(nullable|bool|default:false)</td>
                    </tr>
                    <tr>
                        <th scope="row">Brand</th>
                        <td>(nullable|[Brand name | Brand ID])</td>
                    </tr>
                    <tr>
                        <th scope="row">Product collections</th>
                        <td>(nullable|[Product collection name | Product collection ID]|multiple)</td>
                    </tr>
                    <tr>
                        <th scope="row">Labels</th>
                        <td>(nullable|[Product collection name | Product collection ID]|multiple)</td>
                    </tr>
                    <tr>
                        <th scope="row">Tax</th>
                        <td>(nullable|[Tax name | Tax ID]|default:0)</td>
                    </tr>
                    <tr>
                        <th scope="row">Images</th>
                        <td>(nullable|string|multiple)</td>
                    </tr>
                    <tr>
                        <th scope="row">Price</th>
                        <td>(nullable|number)</td>
                    </tr>
                    <tr>
                        <th scope="row">Product Attributes</th>
                        <td>(nullable|string)</td>
                    </tr>
                    <tr>
                        <th scope="row">Import Type</th>
                        <td>(nullable|enum:product,variation|default:product)</td>
                    </tr>
                    <tr>
                        <th scope="row">Is Variation Default?</th>
                        <td>(nullable|bool|default:false)</td>
                    </tr>
                    <tr>
                        <th scope="row">Stock status</th>
                        <td>(nullable|enum:{{ implode(',', Botble\Ecommerce\Enums\StockStatusEnum::values()) }}|default:{{ Botble\Ecommerce\Enums\StockStatusEnum::IN_STOCK }})</td>
                    </tr>
                    <tr>
                        <th scope="row">With storehouse management</th>
                        <td>(nullable|bool|default:0)</td>
                    </tr>
                    <tr>
                        <th scope="row">Quantity</th>
                        <td>(nullable|number)</td>
                    </tr>
                    <tr>
                        <th scope="row">Allow checkout when out of stock</th>
                        <td>(nullable|bool|default:0)</td>
                    </tr>
                    <tr>
                        <th scope="row">Sale price</th>
                        <td>(nullable|number)</td>
                    </tr>
                    <tr>
                        <th scope="row">Start date sale price</th>
                        <td>(nullable|datetime|date_format:Y-m-d H:i:s)</td>
                    </tr>
                    <tr>
                        <th scope="row">End date sale price</th>
                        <td>(nullable|datetime|date_format:Y-m-d H:i:s)</td>
                    </tr>
                    <tr>
                        <th scope="row">Weight</th>
                        <td>(nullable|number)</td>
                    </tr>
                    <tr>
                        <th scope="row">Length</th>
                        <td>(nullable|number)</td>
                    </tr>
                    <tr>
                        <th scope="row">Wide</th>
                        <td>(nullable|number)</td>
                    </tr>
                    <tr>
                        <th scope="row">Height</th>
                        <td>(nullable|number)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
