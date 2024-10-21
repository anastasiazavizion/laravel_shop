<?php

namespace App\Nova;
use App\Nova\Filters\ProductCategory;
use Laravel\Nova\Fields\File;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    public static $globalSearchResults = 5;

    public function subtitle ()
    {
        $categories = implode(',',$this->categories?->pluck('name')->toArray());
        return !empty($categories)? "Categories: $categories" : "";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','title', 'description', 'SKU'
    ];

    public static $tableStyle = 'tight';

    public static $showColumnBorders = true;

//    public static $clickAction = 'edit';

    public static $perPageOptions = [10, 20, 50];
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),
            Slug::make('Slug')->from('Title')->required(),
            Text::make('Title')
                ->required()
                ->sortable()
                ->showOnPreview()
                ->rules('required', 'max:255')
                ->updateRules('unique:products,title, {{resourceId}}')
                ->creationRules('unique:products,title, {{resourceId}}'),
            Text::make('SKU')->required()->help('SKU for Product. Min 5 symbols'),
            Currency::make('Price')->required()->sortable()->showOnPreview(),
            Number::make('Discount'),
            Number::make('Quantity')->required(),
            Text::make('Description'),
            File::make('Thumbnail'),
            BelongsToMany::make('Categories')->showOnIndex()->showOnDetail()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductCategory()
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }


    public static function usesScout()
    {
        return false;
    }

}
