<div class="form-group">
    <label class="control-label">Featured Products Title</label>
    <input type="text" name="featured_product_title" value="{{ Arr::get($attributes, 'featured_product_title') }}"
           class="form-control" placeholder="Featured Products Title">
</div>

<div class="form-group">
    <label class="control-label">Top Rated Products Title</label>
    <input type="text" name="top_rated_product_title" value="{{ Arr::get($attributes, 'top_rated_product_title') }}"
           class="form-control" placeholder="Top Rated Products Title">
</div>

<div class="form-group">
    <label class="control-label">On Sale Products Title</label>
    <input type="text" name="on_sale_product_title" value="{{ Arr::get($attributes, 'on_sale_product_title') }}"
           class="form-control" placeholder="On Sale Products Title">
</div>
