<?php $title = "Le blog de l'AVBN"; ?>

<?php ob_start(); ?>
<h1>Le super blog de l'AVBN !</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post['title']) ?>
        <em>le <?= $post['french_creation_date'] ?></em>
    </h3>

    <p>
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </p>
</div>

<h2>Commentaires</h2>
<form action="index.php?action=addComment&id=<?= $post['identifier'] ?>" method="post">
    <label for="author">Auteur</label>
    <input type="text" name="author" id="author"><br><br>
    <label for="comment">Commentaire</label>
    <textarea name="comment" id="comment" cols="11" rows="5"></textarea><br><br>
    <input type="submit">
</form>

<?php
foreach ($comments as $comment) {
?>
    <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['french_creation_date'] ?></p>
    <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
<?php
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php') ?>