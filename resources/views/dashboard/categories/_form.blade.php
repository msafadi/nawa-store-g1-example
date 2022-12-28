{{--
<input type="hidden" name="_token" value="{{ csrf_token() }}">
{{ csrf_field() }}
--}}
@csrf

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <x-form.input :data-x="$category->id" class="form-control-lg" id="name" name="name" label="Category Name" :value="$category->name" />
        </div>
        <div class="mb-3">
            <x-form.input id="slug" name="slug" label="URL Slug" :value="$category->slug" />
        </div>
        <div class="mb-3">
            <x-form.select id="parent_id" name="parent_id" label="Category Parent" :value="$category->parent_id" :options="$parents" />

        </div>
        <div class="mb-3">
            <x-form.input type="file" name="image" id="image" label="Image" />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <div class="col-md-4">
        <img src="{{ $category->image_url }}" class="img-fluid" alt="">
    </div>
</div>