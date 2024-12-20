<?php
require('includes/header.php');
?>

<div>
    <h3>Thêm Thương Hiệu</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm Thương Hiệu Mới</h6>
        </div>
        <div class="card-body">
            <form action="../../demo/admin/chucnang/add_brand.php" method="POST">
                <div class="form-group">
                    <label for="brandName">Tên Thương Hiệu</label>
                    <input type="text" class="form-control" id="brandName" name="brandName" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô Tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Thêm Thương Hiệu</button>
            </form>
        </div>
    </div>
</div>

<?php
require('includes/footer.php');
?>