<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category</th>
                <th scope="col">Slug</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            @forelse ($category as $categories)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $categories->name }}</td>
                    <td>{{ $categories->slug }}</td>
                    <td>
                        <a id="{{ route('category.edit', $categories->slug) }}"
                            class="btn btn-warning btn-circle btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a id="{{ route('category.destroy', $categories->slug) }}"
                            class="btn btn-danger btn-circle btn-sm delete">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</div>
