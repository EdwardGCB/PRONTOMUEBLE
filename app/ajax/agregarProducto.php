<div class="card">
    <div class="card-body">
        <h5 class="card-title">Add product</h5>
        <br>
        <div class="alert alert-danger" role="alert">
            * son obligatorios
        </div>
        <form>
            <div class="row">
                <div class="col-6">
                    <!-- name product -->
                    <div class="mb-3">
                        <label for="name-product" class="form-label">* Product name</label>
                        <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col-6">
                    <!-- image product-->
                    <div class="mb-3">
                        <label for="image-product" class="form-label">Product image</label>
                        <input type="file" class="form-control" name="image-product" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <!-- description product -->
            <div class="mb-3">
                <label for="description-product" class="form-label">* Product description</label>
                <input type="text" class="form-control" name="description-product" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="product-Type" class="form-label">* Product Type</label>
                <select class="form-select" name="product-Type" aria-label="Default select example">
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
            <button type="add-product" class="btn btn-danger">cancel</button>
            <button type="add-product" class="btn btn-success">add</button>

        </form>
        <div>
                <div class="row">
                    <div class="col-6">
                        <!-- name product -->
                        <div class="mb-3">
                            <label for="name-product" class="form-label">* Product name</label>
                            <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-6">
                        <!-- image product-->
                        <div class="mb-3">
                            <label for="image-product" class="form-label">Product image</label>
                            <input type="file" class="form-control" name="image-product" aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>
                <!-- description product -->
                <div class="mb-3">
                    <label for="description-product" class="form-label">* Product description</label>
                    <input type="text" class="form-control" name="description-product" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="product-Type" class="form-label">* Product Type</label>
                    <select class="form-select" name="product-Type" aria-label="Default select example">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <button type="add-product" class="btn btn-danger">cancel</button>
                <button type="add-product" class="btn btn-success">add</button>

        </div>
    </div>
</div>
</div>