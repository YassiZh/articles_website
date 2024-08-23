<?php
include 'main.php';
// Default comment values
$comment = [
    'article_id' => '',
    'parent_id' => -1,
    'name' => '',
    'content' => '',
    'submit_date' => date('Y-m-d\TH:i:s'),
    'votes' => 0,
    'img' => '',
    'approved' => 0
];
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    $page = 'Edit';
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('UPDATE comments SET article_id = ?, parent_id = ?, name = ?, content = ?, submit_date = ?, votes = ?, img = ?, approved = ? WHERE id = ?');
        $stmt->execute([ $_POST['article_id'], $_POST['parent_id'], $_POST['name'], $_POST['content'], date('Y-m-d H:i:s', strtotime($_POST['submit_date'])), $_POST['votes'], $_POST['img'], $_POST['approved'], $_GET['id'] ]);
        header('Location: comments.php');
        exit;
    }
    if (isset($_POST['delete'])) {
        $stmt = $pdo->prepare('DELETE FROM comments WHERE id = ?');
        $stmt->execute([ $_GET['id'] ]);
        header('Location: comments.php');
        exit;
    }
} else {
    $page = 'Create';
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('INSERT INTO comments (article_id,parent_id,name,content,submit_date,votes,img,approved) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->execute([ $_POST['article_id'], $_POST['parent_id'], $_POST['name'], $_POST['content'], date('Y-m-d H:i:s', strtotime($_POST['submit_date'])), $_POST['votes'], $_POST['img'], $_POST['approved'] ]);
        header('Location: comments.php');
        exit;
    }
}
?>
<?=template_admin_header($page . ' Comment', 'comments')?>

<h2><?=$page?> Comment</h2>

<div class="content-block">

    <form action="" method="post" class="form responsive-width-100">

        <label for="article_id">Page ID</label>
        <input id="article_id" type="text" name="article_id" placeholder="Page Identifier" value="<?=$comment['article_id']?>" required>

        <label for="parent_id">Parent Comment ID</label>
        <input id="parent_id" type="number" name="parent_id" placeholder="Parent Comment Identifier" value="<?=$comment['parent_id']?>" required>

        <label for="name">Name</label>
        <input id="name" type="text" name="name" placeholder="Name" value="<?=htmlspecialchars($comment['name'], ENT_QUOTES)?>" required>

        <label for="content">Content</label>
        <textarea id="content" name="content" placeholder="Comment content..."><?=htmlspecialchars($comment['content'], ENT_QUOTES)?></textarea>

        <label for="submit_date">Date Submitted</label>
        <input id="submit_date" type="datetime-local" name="submit_date" placeholder="Date" value="<?=date('Y-m-d\TH:i:s', strtotime($comment['submit_date']))?>" required>

        <label for="votes">Votes</label>
        <input id="votes" type="number" name="votes" placeholder="Votes" value="<?=$comment['votes']?>" required>

        <label for="img">Image URL</label>
        <input id="img" type="text" name="img" placeholder="Image" value="<?=htmlspecialchars($comment['img'], ENT_QUOTES)?>">

        <label for="approved">Approved</label>
        <select id="approved" name="approved" required>
            <option value="0"<?=$comment['approved']==0?' selected':''?>>No</option>
            <option value="1"<?=$comment['approved']==1?' selected':''?>>Yes</option>
        </select>
        <br>

        <div class="submit-btns">
            <input type="submit" name="submit" value="Submit">
            <?php if ($page == 'Edit'): ?>
            <input type="submit" name="delete" value="Delete" class="delete">
            <?php endif; ?>
        </div>

    </form>

</div>

<?=template_admin_footer()?>
