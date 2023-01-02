@csrf

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <x-form.input :data-x="$product->id" class="form-control-lg" id="name" name="name" label="Product Name" :value="$product->name" />
        </div>
        <div class="mb-3">
            <x-form.input id="slug" name="slug" label="URL Slug" :value="$product->slug" />
        </div>
        <div class="mb-3">
            <x-form.select id="category_id" name="category_id" label="Category" :value="$product->category_id" :options="$categories" />

        </div>
        <div class="mb-3">
            <x-form.input type="file" name="image" id="image" label="Image" />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <div class="col-md-4">
        <img src="{{ $product->image_url }}" class="img-fluid" alt="">
    </div>
</div>