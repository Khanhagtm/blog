<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add user avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update an image set to your avatar.") }}
        </p>
    </header>

    <br>
    <form action="/profile-add-image" method="post" enctype="multipart/form-data">
        @csrf
        Select image to upload:
        <br>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br>
        <input type="submit" value="Upload Image" name="submit">
    </form>
</section>
