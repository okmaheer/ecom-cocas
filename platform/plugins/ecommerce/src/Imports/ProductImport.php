<?php

namespace Botble\Ecommerce\Imports;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Ecommerce\Enums\StockStatusEnum;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Models\ProductVariation;
use Botble\Ecommerce\Repositories\Interfaces\BrandInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductLabelInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductTagInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Botble\Ecommerce\Repositories\Interfaces\TaxInterface;
use Botble\Ecommerce\Services\Products\StoreAttributesOfProductService;
use Botble\Ecommerce\Services\Products\StoreProductService;
use Botble\Ecommerce\Services\StoreProductTagService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use RvMedia;

class ProductImport implements  ToModel,
                                WithHeadingRow,
                                WithMapping,
                                WithValidation,
                                SkipsOnFailure,
                                SkipsOnError,
                                WithChunkReading
{
    use Importable, SkipsFailures, SkipsErrors, ImportTrait;

    /**
     * @var ProductInterface
     */
    protected $productRepository;

    /**
     * @var ProductCategoryInterface
     */
    protected $productCategoryRepository;

    /**
     * @var ProductTagInterface
     */
    protected $productTagRepository;

    /**
     * @var ProductLabelInterface
     */
    protected $productLabelRepository;

    /**
     * @var TaxInterface
     */
    protected $taxRepository;

    /**
     * @var ProductCollectionInterface
     */
    protected $productCollectionRepository;

    /**
     * @var ProductAttributeInterface
     */
    protected $productAttributeRepository;

    /**
     * @var ProductVariationInterface
     */
    protected $productVariationRepository;

    /**
     * @var BrandInterface
     */
    protected $brandRepository;

    /**
     * @var StoreProductService
     */
    protected $storeProductService;

    /**
     * @var StoreProductTagService
     */
    protected $storeProductTagService;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var mixed
     */
    protected $validatorClass;

    /**
     * @var Collection
     */
    protected $brands;

    /**
     * @var Collection
     */
    protected $categories;

    /**
     * @var Collection
     */
    protected $tags;

    /**
     * @var Collection
     */
    protected $taxes;

    /**
     * @var Collection
     */
    protected $labels;

    /**
     * @var Collection
     */
    protected $productCollections;

    /**
     * @var string
     */
    protected $importType = 'all';

    /**
     * @var Collection
     */
    protected $productAttributeSets;

    /**
     * @param ProductInterface $productRepository
     * @param Request $request
     */
    public function __construct(
        ProductInterface $productRepository,
        ProductCategoryInterface $productCategoryRepository,
        ProductTagInterface $productTagRepository,
        ProductLabelInterface $productLabelRepository,
        TaxInterface $taxRepository,
        ProductCollectionInterface $productCollectionRepository,
        ProductAttributeSetInterface $productAttributeSetRepository,
        ProductAttributeInterface $productAttributeRepository,
        ProductVariationInterface $productVariationRepository,
        BrandInterface $brandRepository,
        StoreProductService $storeProductService,
        StoreProductTagService $storeProductTagService,
        Request $request
    )
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productTagRepository = $productTagRepository;
        $this->productLabelRepository = $productLabelRepository;
        $this->taxRepository = $taxRepository;
        $this->productCollectionRepository = $productCollectionRepository;
        $this->storeProductService = $storeProductService;
        $this->storeProductTagService = $storeProductTagService;
        $this->brandRepository = $brandRepository;
        $this->productAttributeSetRepository = $productAttributeSetRepository;
        $this->request = $request;
        $this->categories = collect([]);
        $this->brands = collect([]);
        $this->taxes = collect([]);
        $this->labels = collect([]);
        $this->productCollections = collect([]);
        $this->productAttributeSets = $this->productAttributeSetRepository->all(['attributes']);
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    /**
     * @param string $importType
     * @return self
     */
    public function setImportType($importType)
    {
        $this->importType = $importType;

        return $this;
    }

    /**
     * @return string
     */
    public function getImportType()
    {
        return $this->importType;
    }

    /**
     * @param array $row
     *
     * @return Product|ProductVariation
     */
    public function model(array $row)
    {
        $importType = $this->getImportType();

        $name = $this->request->input('name');

        if ($importType == 'products' && $row['import_type'] == 'product') {
            return $this->storeProduction();
        }

        if ($importType == 'variations' && $row['import_type'] == 'variation') {
            $product = $this->getProductByName($name);

            return $this->storeVariant($product);
        }

        if ($row['import_type'] == 'variation') {
            $product = $this->successes()
                ->where('import_type', 'product')
                ->where('name', $name)
                ->first();

            if (!$product) {
                $product = $this->getProductByName($name);
            }

            return $this->storeVariant($product);
        }

        return $this->storeProduction();
    }

    /**
     * @return Product|\Eloquent|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    protected function getProductByName($name)
    {
        return $this->productRepository
                            ->getModel()
                            ->where('name', $name)
                            ->orWhere('id', $name)
                            ->where('is_variation', 0)
                            ->first();
    }

    /**
     * @return Product
     */
    public function storeProduction()
    {
        $product = $this->productRepository->getModel();

        $images = array_values(array_filter($this->request->input('images', [])));
		
        foreach ($images as $key => $image) {
            $images[$key] = str_replace(RvMedia::getUploadURL() . '/', '', trim($image));
        }
		
        $this->request->merge(['images' => $images]);
		
        $product = (new StoreProductService($this->productRepository))->execute($this->request, $product);
        $this->storeProductTagService->execute($this->request, $product);

        $product->import_type = 'product';
        $product->attribute_sets = $this->request->input('attribute_sets', []);
        $storeAttr = new StoreAttributesOfProductService($this->productAttributeRepository, $this->productVariationRepository);
        $storeAttr->execute($product, $product->attribute_sets);
        $this->onSuccess($product);

        return $product;
    }

    /**
     * @return ProductVariation|null
     */
    public function storeVariant($product)
    {
        if (!$product) {
            $failures[] = new Failure(
                0,
                'Product Name',
                [__('Product name "' . $this->request->input('name') . '" is not exists')],
                []
            );
            $this->onFailure(...$failures);

            return null;
        }

        $addedAttributes = $this->request->input('attribute_sets', []);
        $result = $this->productVariationRepository->getVariationByAttributesOrCreate($product->id, $addedAttributes);
        if (!$result['created']) {
            $failures[] = new Failure(
                0,
                'variation',
                [trans('plugins/ecommerce::products.form.variation_existed')],
                []
            );
            $this->onFailure(...$failures);

            return null;
        }

        $variation = $result['variation'];

        $version = array_merge($variation->toArray(), $this->request->toArray());
        $version['variation_default_id'] = Arr::get($version, 'is_variation_default') ? $version['id'] : null;
		
        $version['attribute_sets'] = $addedAttributes;

        $isUpdateProduct = true;
        if (!$variation->product_id || $isUpdateProduct) {
            $productRelatedToVariation = $this->productRepository->getModel();
            $productRelatedToVariation->fill($version);

            $productRelatedToVariation->name = $product->name;
            $productRelatedToVariation->status = $product->status;
            $productRelatedToVariation->category_id = $product->category_id;
            $productRelatedToVariation->brand_id = $product->brand_id;
            $productRelatedToVariation->is_variation = 1;

            $productRelatedToVariation->is_variation = 1;

            $productRelatedToVariation->sku = Arr::get($version, 'sku');
            if (!$productRelatedToVariation->sku && Arr::get($version, 'auto_generate_sku')) {
                $productRelatedToVariation->sku = $product->sku;
                foreach ($version['attribute_sets'] as $setId => $attributeId) {
                    $attributeSet = $this->productAttributeSets->firstWhere('id', $setId);
                    if ($attributeSet) {
                        $attribute = $attributeSet->attributes->firstWhere('id', $attributeId);
                        if ($attribute) {
                            $productRelatedToVariation->sku .= '-' . Str::upper($attribute->slug);
                        }
                    }
                }
            }

            $productRelatedToVariation->price = Arr::get($version, 'price', $product->price);
            $productRelatedToVariation->sale_price = Arr::get($version, 'sale_price', $product->sale_price);
            $productRelatedToVariation->description = Arr::get($version, 'description');

            $productRelatedToVariation->length = Arr::get($version, 'length', $product->length);
            $productRelatedToVariation->wide = Arr::get($version, 'wide', $product->wide);
            $productRelatedToVariation->height = Arr::get($version, 'height', $product->height);
            $productRelatedToVariation->weight = Arr::get($version, 'weight', $product->weight);

            $productRelatedToVariation->with_storehouse_management = Arr::get($version,
                'with_storehouse_management', 0);
            $productRelatedToVariation->stock_status = Arr::get($version,
                'stock_status', StockStatusEnum::IN_STOCK);
            $productRelatedToVariation->quantity = Arr::get($version, 'quantity', $product->quantity);
            $productRelatedToVariation->allow_checkout_when_out_of_stock = Arr::get($version,
                'allow_checkout_when_out_of_stock', 0);

            $productRelatedToVariation->sale_type = (int)Arr::get($version, 'sale_type', $product->sale_type);

            if ($productRelatedToVariation->sale_type == 0) {
                $productRelatedToVariation->start_date = null;
                $productRelatedToVariation->end_date = null;
            } else {
                $productRelatedToVariation->start_date = Arr::get($version, 'start_date', $product->start_date);
                $productRelatedToVariation->end_date = Arr::get($version, 'end_date', $product->end_date);
            }

            $images = array_values(array_filter(Arr::get($version, 'images') ? Arr::get($version, 'images') : []));

            foreach ($images as $key => $image) {
                $images[$key] = str_replace(RvMedia::getUploadURL() . '/', '', trim($image));
            }

            $productRelatedToVariation->images = json_encode($images);

            $productRelatedToVariation = $this->productRepository->createOrUpdate($productRelatedToVariation);

            event(new CreatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $this->request, $productRelatedToVariation));

            $variation->product_id = $productRelatedToVariation->id;
        }

        $variation->is_default = Arr::get($version, 'variation_default_id', 0) == $variation->id;

        $this->productVariationRepository->createOrUpdate($variation);

        if ($version['attribute_sets']) {
            $variation->productAttributes()->sync($version['attribute_sets']);
        }

        $this->onSuccess($variation);

        return $variation;
    }

    /**
     * Change value before insert to model
     *
     * @param array row
     */
    public function map($row): array
    {
        $row = $this->mapLocalization($row);
        $row = $this->setCategoriesToRow($row);
        $row = $this->setBrandToRow($row);
        $row = $this->setTaxToRow($row);

        $this->request->merge($row);

        return $row;
    }

    /**
     * @param array $row
     * @return array
     */
    protected function setTaxToRow(array $row) : array
    {
        $row['tax_id'] = 0;
        if (!empty($row['tax'])) {
            $tax = $this->taxes->firstWhere('keyword', $row['tax']);
            if ($tax) {
                $taxId = $tax['tax_id'];
            } else {
                if (is_numeric($row['tax'])) {
                    $tax = $this->taxRepository->findById($row['tax']);
                } else {
                    $tax = $this->taxRepository->getFirstBy(['title' => $row['tax']]);
                }

                $taxId = $tax ? $tax->id : 0;
                $this->taxes->push([
                    'keyword' => $row['tax'],
                    'tax_id'  => $taxId
                ]);
            }

            $row['tax_id'] = $taxId;
        }

        return $row;
    }

    /**
     *
     * @param array $row
     * @return array
     */
    protected function setBrandToRow(array $row) : array
    {
        $row['brand_id'] = 0;
        if (!empty($row['brand'])) {
            $brand = $this->brands->firstWhere('keyword', $row['brand']);
            if ($brand) {
                $brandId = $brand['brand_id'];
            } else {
                if (is_numeric($row['brand'])) {
                    $brand = $this->brandRepository->findById($row['brand']);
                } else {
                    $brand = $this->brandRepository->getFirstBy(['name' => $row['brand']]);
                }

                $brandId = $brand ? $brand->id : 0;
                $this->brands->push([
                    'keyword'  => $row['brand'],
                    'brand_id' => $brandId
                ]);
            }

            $row['brand_id'] = $brandId;
        }

        return $row;
    }

    /**
     *
     * @param array $row
     * @return array
     */
    protected function setCategoriesToRow(array $row) : array
    {
        if ($row['categories']) {
            $categories = $row['categories'];
            $categoryIds = [];
			$parentCategory = 0;
            foreach ($categories as $value) {
                $category = $this->categories->firstWhere('keyword', $value);
                if ($category) {
                    $categoryId = $category['category_id'];
                } else {
                    if (is_numeric($value)) {
                        $category = $this->productCategoryRepository->findById($value);
                    } else {
                        $category = $this->productCategoryRepository->getFirstBy(['name' => $value, 'parent_id' => $parentCategory]);
                    }
										
					if($parentCategory == 0){ 
						$parentCategory = $category ? $category->id : 0;
					}
                    $categoryId = $category ? $category->id : 0;
                    $this->categories->push([
                        'keyword'     => $value,
                        'category_id' => $categoryId
                    ]);
                }
                $categoryIds[] = $categoryId;
            }

            $row['categories'] = array_filter($categoryIds);
        }

        return $row;
    }

    /**
     *
     * @param array $row
     * @return array
     */
    protected function setLabelsToRow(array $row) : array
    {
        if ($row['product_labels']) {
            $labels = $row['product_labels'];
            $productLabelIds = [];
            foreach ($labels as $value) {
                $productLabel = $this->labels->firstWhere('keyword', $value);
                if ($productLabel) {
                    $productLabelId = $productLabel['product_collection_id'];
                } else {
                    if (is_numeric($value)) {
                        $productLabel = $this->productLabelRepository->findById($value);
                    } else {
                        $productLabel = $this->productLabelRepository->getFirstBy(['name' => $value]);
                    }
                    $productLabelId = $productLabel ? $productLabel->id : 0;
                    $this->labels->push([
                        'keyword'          => $value,
                        'product_label_id' => $productLabelId
                    ]);
                }

                $productLabelIds[] = $productLabelId;
            }
            $row['product_labels'] = array_filter($productLabelIds);
        }

        return $row;
    }

    /**
     *
     * @param array $row
     * @return array
     */
    protected function setProductCollectionsToRow(array $row) : array
    {
        if ($row['product_collections']) {
            $productCollections = $row['product_collections'];
            $productCollectionIds = [];
            foreach ($productCollections as $value) {
                $productCollection = $this->productCollections->firstWhere('keyword', $value);
                if ($productCollection) {
                    $productCollectionId = $productCollection['product_collection_id'];
                } else {
                    if (is_numeric($value)) {
                        $productCollection = $this->productCollectionRepository->findById($value);
                    } else {
                        $productCollection = $this->productCollectionRepository->getFirstBy(['name' => $value]);
                    }
                    $productCollectionId = $productCollection ? $productCollection->id : 0;
                    $this->productCollections->push([
                        'keyword'               => $value,
                        'product_collection_id' => $productCollectionId
                    ]);
                }
                $productCollectionIds[] = $productCollectionId;
            }
            $row['product_collections'] = array_filter($productCollectionIds);
        }

        return $row;
    }

    /**
     * @param array $row
     * @return array
     */
    public function mapLocalization($row): array
    {
        $row['stock_status'] = (string) Arr::get($row, 'stock_status');
        if (!in_array($row['stock_status'], StockStatusEnum::values())) {
            $row['stock_status'] = StockStatusEnum::IN_STOCK;
        }

        $row['status'] = Arr::get($row, 'status');
        if (!in_array($row['status'], BaseStatusEnum::values())) {
            $row['status'] = BaseStatusEnum::PENDING;
        }

        $row['import_type'] = Arr::get($row, 'import_type');
        if ($row['import_type'] != 'variation') {
            $row['import_type'] = 'product';
        }

        $row['name'] = Arr::get($row, 'product_name');

        $this->setValues($row, [
            ['key' => 'sku', 'type' => 'string'],
            ['key' => 'price', 'type' => 'number'],
            ['key' => 'weight', 'type' => 'number'],
            ['key' => 'length', 'type' => 'number'],
            ['key' => 'wide', 'type' => 'number'],
            ['key' => 'height', 'type' => 'number'],
            ['key' => 'is_featured', 'type' => 'bool'],
            ['key' => 'is_direction', 'type' => 'bool'],
            ['key' => 'product_labels'],
            ['key' => 'images'],
            ['key' => 'categories'],
            ['key' => 'product_collections'],
            ['key' => 'product_attributes'],
            ['key' => 'is_variation_default', 'type' => 'bool'],
            ['key' => 'auto_generate_sku', 'type' => 'bool'],
            ['key' => 'with_storehouse_management', 'type' => 'bool'],
            ['key' => 'allow_checkout_when_out_of_stock', 'type' => 'bool'],
            ['key' => 'quantity', 'type' => 'number'],
            ['key' => 'sale_price', 'type' => 'number'],
            ['key' => 'start_date', 'type' => 'datetime', 'from' => 'start_date_sale_price'],
            ['key' => 'end_date', 'type' => 'datetime', 'from' => 'end_date_sale_price'],
			['key' => 'product_colors'],
			['key' => 'is_materials', 'type' => 'bool'],
			['key' => 'is_frames', 'type' => 'bool'],
			['key' => 'is_wrappings', 'type' => 'bool'],
        ]);
		
		$row['product_colors'] = '';
		$colors = Arr::get($row, 'color');
		if($colors != ''){
			$proColor = [
				"Black||#000000" => "Black", "Grey||#d4d2d4" => "Grey", "Violet New||#663399" => "Violet New", 
				"Fuchsia Pink||#ef2095" => "Fuchsia Pink", "Rose Pink||#f792c6" => "Rose Pink", "White||#ffffff" => "White", 
				"Pearl Grey||#e3e1e3" => "Pearl Grey", "Cloud Grey||#cbcfd1" => "Cloud Grey", "Cement Grey||#acb4b7" => "Cement Grey", 
				"Basalt Grey||#687377" => "Basalt Grey", "Stone Grey||#c4c5b8" => "Stone Grey", "Ivory Beige||#efdfc6" => "Ivory Beige", 
				"Beige||#efdfad" => "Beige", "Lemon Yellow||#ffff66" => "Lemon Yellow", "Autumn-Yellow||#f7e031" => "Autumn Yellow", 
				"Light Orange||#ff9900" => "Light Orange", "Deep Orange||#f60" => "Deep Orange", "Tomato Red||#f33" => "Tomato Red", 
				"Strawberry Red||#ca0000" => "Strawberry Red", "Brick Red||#910000" => "Brick Red", "Burgundy||#7b1010" => "Burgundy", 
				"Nut Brown||#331400" => "Nut Brown", "Leather Brown||#934a00" => "Leather Brown", "Leaf Green||#50db00" => "Leaf Green", 
				"Grass-Green||#21be53" => "Grass Green", "Pine Green||#18794a" => "Pine Green", "Moss Green||#14653f" => "Moss Green", 
				"Turquoise||#00a29d" => "Turquoise", "Mint||#8ce3c6" => "Mint", "Ice Blue||#6bc3de" => "Ice Blue", 
				"Ocean Blue||#00a1d6" => "Ocean Blue", "Bright Blue||#427dd6" => "Bright Blue", "Jeans Blue||#184594" => "Jeans Blue", 
				"Sapphire Blue||#0028c6" => "Sapphire Blue", "Royal Blue||#000c6b" => "Royal Blue", "Berry Blue||#00004f" => "Berry Blue"
			]; 	
			$colors = explode(',',$colors);		
			
			$colorsArray = array();
			foreach($proColor as $key => $proColorData){
				
				if(in_array(ucwords('All'), $colors)){
					$colorsArray[] = $key;
				}else{
					if(in_array($proColorData, $colors)){
						$colorsArray[] = $key;
					}
				}
			}
			$row['product_colors'] = json_encode($colorsArray);
		}
		

        if ($row['import_type'] == 'product' && !$row['sku'] && $row['auto_generate_sku']) {
            $row['sku'] = Str::upper(Str::random(7));
        }

        $row['sale_type'] = 0;
        if ($row['start_date'] || $row['end_date']) {
            $row['sale_type'] = 1;
        }
		$row['is_direction'] = 0;
		if (Arr::get($row, 'direction') == 'Yes' ) {
            $row['is_direction'] = 1;
        }
		
		$row['is_materials'] = 0;
		if (Arr::get($row, 'material') == 'Yes' ) {
            $row['is_materials'] = 1;
        }
		$row['is_frames'] = 0;
		if (Arr::get($row, 'frame') == 'Yes' ) {
            $row['is_frames'] = 1;
        }
		$row['is_wrappings'] = 0;
		if (Arr::get($row, 'wrappings') == 'Yes' ) {
            $row['is_wrappings'] = 1;
        }

        if (!$row['with_storehouse_management']) {
            $row['quantity'] = null;
            $row['allow_checkout_when_out_of_stock'] = false;
        }

        $attributeSets = Arr::get($row, 'product_attributes');
        $row['attribute_sets'] = [];
        $row['product_attributes'] = [];
		
        if ($row['import_type'] == 'variation') {
            foreach ($attributeSets as $attrSet) {
                $attrSet = explode(':', $attrSet);
                $title = Arr::get($attrSet, 0);
                $valueX = Arr::get($attrSet, 1);

                $attribute = $this->productAttributeSets->filter(function ($value) use ($title) {
                    return $value['title'] == $title || $value['id'] == $title;
                })->first();

                if ($attribute) {
                    $attr = $attribute->attributes->filter(function ($value) use ($valueX) {
                        return $value['title'] == $valueX || $value['id'] == $valueX;
                    })->first();

                    if ($attr) {
                        $row['attribute_sets'][$attribute->id] = $attr->id;
                    }
                }
            }
        }

        if ($row['import_type'] == 'product') {
            foreach ($attributeSets as $attrSet) {
                $attribute = $this->productAttributeSets->filter(function ($value) use ($attrSet) {
                    return $value['title'] == $attrSet || $value['id'] == $attrSet;
                })->first();

                if ($attribute) {
                    $row['attribute_sets'][] = $attribute->id;
                }
            }
        }

        return $row;
    }

    /**
     * @param $row
     * @param array $attributes
     * @return $this
     */
    protected function setValues(&$row, $attributes = [])
    {
        foreach ($attributes as $attribute) {
            $this->setValue($row,
                Arr::get($attribute, 'key'),
                Arr::get($attribute, 'type', 'array'),
                Arr::get($attribute, 'default'),
                Arr::get($attribute, 'from'));
        }
        return $this;
    }

    /**
     * @param $row
     * @param string $key
     * @param string $type
     * @param null $default
     * @return $this
     */
    protected function setValue(&$row, $key, $type = 'array', $default = null, $from = null)
    {
        $value = Arr::get($row, $from ?: $key, $default);

        switch ($type) {
            case 'array':
                $value = $value ? explode(',', $value) : [];
                break;
            case 'bool':
                if (Str::lower($value) == 'false' || $value == '0' || Str::lower($value) == 'no'){
                    $value = false;
                }
                $value = (bool) $value;
                break;
            case 'datetime':
                if ($value){
                    if (in_array(gettype($value), ['integer', 'double'])){
                        $value = $this->transformDate($value);
                    } else {
                        $value = $this->getDate($value);
                    }
                }
                break;
        }

        Arr::set($row, $key, $value);

        return $this;
    }

    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return method_exists($this->getValidatorClass(), 'messages') ? $this->getValidatorClass()->messages() : [];
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return method_exists($this->getValidatorClass(), 'rules') ? $this->getValidatorClass()->rules() : [];
    }

    /**
     * @return mixed
     */
    public function getValidatorClass()
    {
        return $this->validatorClass;
    }

    /**
     * @param mixed $validatorClass
     * @return self
     */
    public function setValidatorClass($validatorClass): self
    {
        $this->validatorClass = $validatorClass;

        return $this;
    }

    /**
     * @return array
     */
    public function customValidationAttributes()
    {
        return method_exists($this->getValidatorClass(), 'attributes') ? $this->getValidatorClass()->attributes() : [];
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 100;
    }
}
