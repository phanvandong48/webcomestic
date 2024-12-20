<?php
require('includes/header.php');
?>

<div>
    <h3>Thêm danh mục mới</h3>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm danh mục mới</h6>
        </div>
        <div class="card-body">
            <form action="../../demo/admin/chucnang/add_category.php" method="POST">
                <div class="form-group">
                    <label for="CategoryName">Tên danh mục</label>
                    <input type="text" class="form-control" id="CategoryName" name="CategoryName" required>
                </div>
                <div class="form-group">
                    <label for="Description">Mô tả</label>
                    <textarea class="form-control" id="Description" name="Description" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Thêm danh mục</button>
            </form>
        </div>
    </div>
</div>

<?php
require('includes/footer.php');
?>