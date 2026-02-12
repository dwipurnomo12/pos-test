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
                        <div class="row">
                            <div class="col-md-6">
                                Product List
                            </div>
                            <div class="col-md-6 float-end text-end">
                                <a href="/products" class="btn btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h5>Product Details</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Product ID:</strong> {{ $product->product_id }}</p>
                                <p><strong>Product Name:</strong> {{ $product->product_name }}</p>
                                <p><strong>Category:</strong> {{ $product->category->category_name }}</p>
                                <p><strong>Supplier:</strong> {{ $product->supplier->company_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Unit Price:</strong> {{ $product->unit_price }}</p>
                                <p><strong>Units in Stock:</strong> {{ $product->units_in_stock }}</p>
                                <p><strong>Status:</strong>
                                    @if ($product->discontinued)
                                        <span class="badge bg-danger">Discontinued</span>
                                    @else
                                        <span class="badge bg-success">Available</span>
                                    @endif
                                </p>
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
