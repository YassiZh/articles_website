<?php
include 'main.php';
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM comments WHERE id = ?');
    $stmt->execute([ $_GET['delete'] ]);
    header('Location: comments.php');
    exit;
}
if (isset($_GET['approve'])) {
    $stmt = $pdo->prepare('UPDATE comments SET approved = 1 WHERE id = ?');
    $stmt->execute([ $_GET['approve'] ]);
    header('Location: comments.php');
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM comments ORDER BY id DESC');
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_admin_header('Comments', 'comments')?>

<h2>Comments</h2>

<div class="links">
    <a href="comment.php">Create Comment</a>
</div>

<div class="content-block">
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td colspan="2">Name</td>
                    <td>Content</td>
                    <td class="responsive-hidden">Votes</td>
                    <td>Approved</td>
                    <td class="responsive-hidden">Date</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($comments)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no comments</td>
                </tr>
                <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?=$comment['id']?></td>
                    <td class="img">
                        <img src="<?=$comment['img'] ? htmlspecialchars($comment['img'], ENT_QUOTES) : '../default-profile-image.png'?>" width="32" height="32" alt="<?=htmlspecialchars($comment['name'], ENT_QUOTES)?>" style="border-radius:4px">
                    </td>
                    <td><?=htmlspecialchars($comment['name'], ENT_QUOTES)?></td>
                    <td><?=nl2br(htmlspecialchars($comment['content'], ENT_QUOTES))?></td>
                    <td class="responsive-hidden"><?=number_format($comment['votes'])?></td>
                    <td><?=$comment['approved']?'Yes':'No'?></td>
                    <td class="responsive-hidden"><?=date('F j, Y H:ia', strtotime($comment['submit_date']))?></td>
                    <td>
                        <a href="comment.php?id=<?=$comment['id']?>">Edit</a>
                        <a href="comments.php?delete=<?=$comment['id']?>">Delete</a>
                        <?php if (!$comment['approved']): ?>
                        <a href="comments.php?approve=<?=$comment['id']?>">Approve</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?=template_admin_footer()?>
