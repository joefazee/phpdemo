<?php include VIEW_PATH . 'header.php'; ?>
<div class="container">

    <div class="posts">
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <div>
                    <h3><a href="/posts?id=<?php echo $post->getId() ?>"><?= $post->getTitle() ?></a></h3>
                    <p>
                        <a href="/posts?id=<?php echo $post->getId() ?>">
                            <?php
                            $content = $post->getContent();
                            if (strlen($content) > 1000) {
                                echo substr($content, 0, 1000) . '...';
                            } else {
                                echo $content;
                            }
                            ?>
                        </a>
                    </p>
                    <p>Author: <?= $post->getAuthor()->getUsername() ?></p>
                    <p>Published on: <?= $post->getCreatedAt()->format('Y-m-d') ?></p>
                    <p>Comments: <?= $post->getCommentCount() ?></p>
                </div>

                <div>
                    <img src="<?= $post->getThumbnail() ?>" alt="<?= $post->getTitle() ?>">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="paginate">

        <?php if ($page > 1): ?>
            <a href="/?page=<?= $page - 1 ?>">Previous</a>
        <?php endif; ?>

        <?php if ($page < $totalPages): ?>
            <a href="/?page=<?= $page + 1 ?>">Next</a>
        <?php endif; ?>

    </div>

    <footer>
        <p>&copy; 2021 Simple Blog</p>
    </footer>
</div>
</body>
</html>
