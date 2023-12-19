<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\Fields\MultiCheckListField;
use Botble\Base\Forms\Fields\TagField;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Forms\Fields\CategoryMultiField;
use Botble\Ecommerce\Http\Requests\ProductRequest;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Interfaces\BrandInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductLabelInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductVariationItemInterface;
use Botble\Ecommerce\Repositories\Interfaces\TaxInterface;
use EcommerceHelper;
use Illuminate\Support\Collection;

class ProductForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {
        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }

        $brands = app(BrandInterface::class)->pluck('name', 'id');

        $brands = [0 => trans('plugins/ecommerce::brands.no_brand')] + $brands;

        $frameSizes = [0 => "Select Frame Size", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6", 7 => "7", 8 => "8", 9 => "9", 10 => "10"];
         
        $frameTypes = [
            "Select Frame Type",
            '3-panel-display-wall-display-36-42-type-1' => '3 Panel Displays (36"x42") Type 1',
            '3-panel-display-wall-display-36-42-type-2' => '3 Panel Displays (36"x42") Type 2',
            '3-panel-display-wall-display-36-42-type-3' => '3 Panel Displays (36"x42") Type 3',

            "3-panel-display-wall-display-30-64-type-1" => '3 Panel Displays (30"x64") Type 1',
            "3-panel-display-wall-display-30-64-type-2" => '3 Panel Displays (30"x64") Type 2',
            "3-panel-display-wall-display-30-64-type-3" => '3 Panel Displays (30"x64") Type 3',

            "3-panel-display-wall-display-26-40-type-1" => '3 Panel Displays (26"x40") Type 1',
            "3-panel-display-wall-display-26-40-type-2" => '3 Panel Displays (26"x40") Type 2',
            "3-panel-display-wall-display-26-40-type-3" => '3 Panel Displays (26"x40") Type 3',

            "4-panel-display-wall-display-32-32-type-1" => '4 Panel Displays (32"x32") Type 1',
            "4-panel-display-wall-display-25-36-type-1" => '4 Panel Displays (25"x36") Type 1',
            "4-panel-display-wall-display-34-35-type-1" => '4 Panel Displays (34"x35") Type 1',

            "5-panel-display-wall-display-24-50-type-1" => '5 Panel Displays (24"x50") Type 1',
            "5-panel-display-wall-display-37-54-type-1" => '5 Panel Displays (37"x54") Type 1',

            "7-panel-display-wall-display-44-46-type-1" => '7 Panel Displays (44"x46") Type 1',
            "7-panel-display-wall-display-32-48-type-1" => '7 Panel Displays (32"x48") Type 1',

            "10-panel-display-wall-display-46-72-type-1" => '10 Panel Displays (46"x72") Type 1',


            "5-square-photo-collage-design-1" => '5 Square Photo Collage Design 1',
            "5-square-photo-collage-design-2" => '5 Square Photo Collage Design 2',

            "2-split-photo-collage-8-8" => '2 Split Photo (8"x8")',
            "2-split-photo-collage-16-16" => '2 Split Photo (16"x16")',
 
        ];
		
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
        
        $productCollections = app(ProductCollectionInterface::class)->pluck('name', 'id');

        $selectedProductCollections = [];
        if ($this->getModel()) {
            $selectedProductCollections = $this->getModel()->productCollections()->pluck('product_collection_id')
                ->all();
        }

        $productLabels = app(ProductLabelInterface::class)->pluck('name', 'id');

        $selectedProductLabels = [];
        if ($this->getModel()) {
            $selectedProductLabels = $this->getModel()->productLabels()->pluck('product_label_id')
                ->all();
        }
		
		$selectedProductColors = [];  
        if ($this->getModel()) {
			$valueClr = $this->getModel()->product_colors;
			if(!empty($valueClr)){
				$selectedProductColors = json_decode((string)$valueClr, true);
				if (is_array($selectedProductColors)) {
					$selectedProductColors = array_filter($selectedProductColors);
            	}
			}
            
			
        }

        $productId = $this->getModel() ? $this->getModel()->id : null;

        $productAttributeSets = app(ProductAttributeSetInterface::class)->getAllWithSelected($productId);

        $productVariations = [];

        if ($this->getModel()) {
            $productVariations = app(ProductVariationInterface::class)->allBy([
                'configurable_product_id' => $this->getModel()->id,
            ]);
        }

        $tags = null;

        if ($this->getModel()) {
            $tags = $this->getModel()->tags()->pluck('name')->all();
            $tags = implode(',', $tags);
        }

        $this
            ->setupModel(new Product)
            ->setValidatorClass(ProductRequest::class)
            ->withCustomFields()
            ->addCustomField('categoryMulti', CategoryMultiField::class)
            ->addCustomField('multiCheckList', MultiCheckListField::class)
            ->addCustomField('tags', TagField::class)
            ->add('name', 'text', [
                'label'      => trans('plugins/ecommerce::products.form.name'),
                'label_attr' => ['class' => 'text-title-field required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'editor', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 2,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 1000,
                ],
            ])
            ->add('content', 'editor', [
                'label'      => trans('plugins/ecommerce::products.form.content'),
                'label_attr' => ['class' => 'text-title-field'],
                'attr'       => [
                    'rows'            => 4,
                    'with-short-code' => true,
                ],
            ])
            ->add('images[]', 'mediaImages', [
                'label'      => trans('plugins/ecommerce::products.form.image'),
                'label_attr' => ['class' => 'control-label'],
                'values'     => $productId ? $this->getModel()->images : [],
            ])
            ->addMetaBoxes([
                'with_related' => [
                    'title'    => null,
                    'content'  => '<div class="wrap-relation-product" data-target="' . route('products.get-relations-boxes',
                            $productId ?: 0) . '"></div>',
                    'wrap'     => false,
                    'priority' => 9999,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('categories[]', 'categoryMulti', [
                'label'      => trans('plugins/ecommerce::products.form.categories'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => get_product_categories_with_children(),
                'value'      => old('categories', $selectedCategories),
            ])
			->add('product_colors[]', 'multiCheckList', [
                'label'      => 'Colors',
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $proColor,
                'value'      => old('product_colors', $selectedProductColors),
            ])
            ->add('brand_id', 'customSelect', [
                'label'      => trans('plugins/ecommerce::products.form.brand'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $brands,
            ])
            ->add('frame_size', 'customSelect', [
                'label'      => trans('Wall Display Frame Size'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $frameSizes,
            ])
            ->add('frame_type', 'customSelect', [
                'label'      => trans('Wall Display Frame Type'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $frameTypes,
            ])
			->add('is_materials', 'onOff', [
                'label'         => 'Materials',
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
			->add('is_frames', 'onOff', [
                'label'         => 'Frames',
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
			->add('is_wrappings', 'onOff', [
                'label'         => 'Wrappings',
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
			->add('is_direction', 'onOff', [
                'label'         => 'Direction',
                'label_attr'    => ['class' => 'control-label onoffBoxes'],
                'default_value' => false, 
            ])
            ->add('product_collections[]', 'multiCheckList', [
                'label'      => trans('plugins/ecommerce::products.form.collections'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $productCollections,
                'value'      => old('product_collections', $selectedProductCollections),
            ])
            ->add('product_labels[]', 'multiCheckList', [
                'label'      => trans('plugins/ecommerce::products.form.labels'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $productLabels,
                'value'      => old('product_labels', $selectedProductLabels),
            ]);

        if (EcommerceHelper::isTaxEnabled()) {
            $taxes = app(TaxInterface::class)->pluck('title', 'id');

            $taxes = [0 => trans('plugins/ecommerce::tax.select_tax')] + $taxes;

            $this->add('tax_id', 'customSelect', [
                'label'      => trans('plugins/ecommerce::products.form.tax'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $taxes,
            ]);
        }

        $this
            ->add('tag', 'tags', [
                'label'      => trans('plugins/ecommerce::products.form.tags'),
                'label_attr' => ['class' => 'control-label'],
                'value'      => $tags,
                'attr'       => [
                    'placeholder' => trans('plugins/ecommerce::products.form.write_some_tags'),
                    'data-url'    => route('product-tag.all'),
                ],
            ])
            ->setBreakFieldPoint('status');

        if (empty($productVariations) || $productVariations->isEmpty()) {
            $attributeSetId = $productAttributeSets->first() ? $productAttributeSets->first()->id : 0;
            $this
                ->removeMetaBox('variations')
                ->addMetaBoxes([
                    'general'    => [
                        'title'          => trans('plugins/ecommerce::products.overview'),
                        'content'        => view('plugins/ecommerce::products.partials.general',
                            [
                                'product' => $productId ? $this->getModel() : null,
                                'isVariation' => false,
                            ])
                            ->render(),
                        'before_wrapper' => '<div id="main-manage-product-type">',
                        'priority'       => 2,
                    ],
                    'attributes' => [
                        'title'         => trans('plugins/ecommerce::products.attributes'),
                        'content'       => view('plugins/ecommerce::products.partials.add-product-attributes', [
                            'productAttributeSets' => $productAttributeSets,
                            'productAttributes'    => $this->getProductAttributes($attributeSetId),
                            'attributeSetId'       => $attributeSetId,
                            'product'              => $this->getModel(),
                        ])->render(),
                        'after_wrapper' => '</div>',
                        'priority'      => 3,
                    ],
                ]);
        } elseif ($productId) {
            $productVariationsInfo = [];
            $productsRelatedToVariation = [];

            if ($this->getModel()) {
                $productVariationsInfo = app(ProductVariationItemInterface::class)
                    ->getVariationsInfo($productVariations->pluck('id')->toArray());

                $productsRelatedToVariation = app(ProductInterface::class)->getProductVariations($productId);
            }
            $this
                ->removeMetaBox('general')
                ->removeMetaBox('attributes')
                ->addMetaBoxes([
                    'variations' => [
                        'title'          => trans('plugins/ecommerce::products.product_has_variations'),
                        'content'        => view('plugins/ecommerce::products.partials.configurable', [
                            'productAttributeSets'       => $productAttributeSets,
                            'productVariations'          => $productVariations,
                            'productVariationsInfo'      => $productVariationsInfo,
                            'productsRelatedToVariation' => $productsRelatedToVariation,
                            'product'                    => $this->getModel(),
                        ])->render(),
                        'before_wrapper' => '<div id="main-manage-product-type">',
                        'after_wrapper'  => '</div>',
                        'priority'       => 4,
                    ],
                ]);
        }
    }

    /**
     * @return Collection
     */
    public function getProductAttributes($attributeSetId)
    {
        $params = ['order_by' => ['order' => 'ASC']];

        if ($attributeSetId) {
            $params['condition'] = [
                ['attribute_set_id', '=', $attributeSetId],
            ];
        }

        return app(ProductAttributeInterface::class)->advancedGet($params);
    }
}
