<?php include VIEW_PATH . 'header.php'; ?>
<div class="container">

<div class="post">
   <div>
       <h3><a href="/posts?id=<?php echo $post->getId() ?>"><?= $post->getTitle() ?></a></h3>
       <p>
           <a href="/posts?id=<?php echo $post->getId() ?>">
               <?php
                echo nl2br($post->getContent());
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



</div>
</body>
</html>
