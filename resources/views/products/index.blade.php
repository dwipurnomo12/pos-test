<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Lists</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-4.0.0.min.js"
        integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.7/css/dataTables.dataTables.css" />
</head>

<body>
    <div class="container-fluid mt-4 p-4">
        <div class="row">
            <div class="col md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Product List
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h5>Filter</h5>

                        </div>
                        <div class="table-responsive">
                            <table id="productTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Supplier</th>
                                        <th>Unit Price</th>
                                        <th>Unit in Stock</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->product_id }}</td>
                                            <td>{{ $product->product_name }}</td>
                                            <td>{{ $product->category->category_name }}</td>
                                            <td>{{ $product->supplier->company_name }}</td>
                                            <td>{{ $product->unit_price }}</td>
                                            <td>{{ $product->units_in_stock }}</td>
                                            <td>
                                                @if ($product->discontinued)
                                                    <span class="badge bg-danger">Discontinued</span>
                                                @else
                                                    <span class="badge bg-success">Available</span>
                                                @endif
                                            <td>
                                                <a href="{{ route('products.show', $product->product_id) }}"
                                                    class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.js"></script>

    <script>
        let table = new DataTable('#productTable');
    </script>
</body>

</html>
