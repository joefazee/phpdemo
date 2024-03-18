<?php include VIEW_PATH . 'header.php'; ?>
<div class="container">
    <?php
    if (isset($error)) {
        echo '<div class="alert-danger">' . $error . '</div>';
    }
    ?>

    <form action="/new-entry" method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control">
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="title">Thumbnail</label>
            <input type="text" id="title" name="thumbnail" value="https://via.placeholder.com/150" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</div>
</body>
</html>
