<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tag</th>
                <th scope="col">Slug</th>
                <th scope="col">Action</th>
            </tr>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Tag</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </tfoot>
        </thead>
        <tbody>
            @forelse ($tag as $tags)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tags->name }}</td>
                    <td>{{ $tags->slug }}</td>
                    <td>
                        <a id="{{ route('tag.edit', $tags->slug) }}" class="btn btn-warning btn-circle btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a id="{{ route('tag.destroy', $tags->slug) }}" class="btn btn-danger btn-circle btn-sm delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
