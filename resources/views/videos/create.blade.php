<form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label for="title">Title</label>
    <input type="text" name="title" id="title" required>

    <label for="subtitle">Subtitle</label>
    <textarea name="subtitle" id="subtitle" required></textarea>

    <label for="media">Media URL</label>
    <input type="text" name="media" id="media" required>

    <label for="slug">Slug</label>
    <input type="file" name="slug" id="slug" required>

    <label for="thumbnail">Thumbnail URL</label>
    <input type="text" name="thumbnail" id="thumbnail" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" required></textarea>

    <label for="user_id">User</label>
    <select name="user_id" id="user_id" required>
        @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <label for="category_id">Category</label>
    <select name="category_id" id="category_id" required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <button type="submit">Create Video</button>
</form>
