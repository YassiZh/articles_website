<?php
include 'main.php';
$stmt = $pdo->prepare('SELECT * FROM comments WHERE cast(submit_date as DATE) = cast(now() as DATE) ORDER BY submit_date DESC');
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM comments WHERE approved = 0');
$stmt->execute();
$awaiting_approval = $stmt->fetchColumn();
$stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM comments');
$stmt->execute();
$comments_total = $stmt->fetchColumn();
$stmt = $pdo->prepare('SELECT COUNT(article_id) AS total FROM comments GROUP BY article_id');
$stmt->execute();
$comments_page_total = $stmt->fetchAll(PDO::FETCH_ASSOC);
$comments_page_total = count($comments_page_total);
$stmt = $pdo->prepare('SELECT * FROM comments WHERE approved = 0 ORDER BY submit_date DESC');
$stmt->execute();
$comments_awaiting_approval = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_admin_header('Dashboard', 'dashboard')?>

<h2>Dashboard</h2>

<div class="dashboard">
    <div class="content-block stat">
        <div>
            <h3>Today's Comments</h3>
            <p><?=number_format(count($comments))?></p>
        </div>
        <i class="fas fa-comments"></i>
    </div>

    <div class="content-block stat">
        <div>
            <h3>Awaiting Approval</h3>
            <p><?=number_format($awaiting_approval)?></p>
        </div>
        <i class="fas fa-clock"></i>
    </div>

    <div class="content-block stat">
        <div>
            <h3>Total Comments</h3>
            <p><?=number_format($comments_total)?></p>
        </div>
        <i class="fas fa-comments"></i>
    </div>

    <div class="content-block stat">
        <div>
            <h3>Total Pages</h3>
            <p><?=number_format($comments_page_total)?></p>
        </div>
        <i class="fas fa-file-alt"></i>
    </div>
</div>

<h2>Today's Comments</h2>

<div class="content-block">
    <div class="table">
        <table>
            <thead>
                <tr>
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
                    <td colspan="8" style="text-align:center;">There are no recent comments</td>
                </tr>
                <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td class="img">
                        <img src="<?=$comment['img'] ? $comment['img'] : '../default-profile-image.png'?>" width="32" height="32" alt="<?=htmlspecialchars($comment['name'], ENT_QUOTES)?>" style="border-radius:4px">
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

<h2 style="margin-top:40px">Awaiting Approval</h2>

<div class="content-block">
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Name</td>
                    <td>Content</td>
                    <td class="responsive-hidden">Votes</td>
                    <td>Approved</td>
                    <td class="responsive-hidden">Date</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($comments_awaiting_approval)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no recent comments</td>
                </tr>
                <?php else: ?>
                <?php foreach ($comments_awaiting_approval as $comment): ?>
                <tr>
                    <td class="img">
                        <img src="<?=$comment['img'] ? $comment['img'] : '../default-profile-image.png'?>" width="32" height="32" alt="<?=htmlspecialchars($comment['name'], ENT_QUOTES)?>" style="border-radius:4px">
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
