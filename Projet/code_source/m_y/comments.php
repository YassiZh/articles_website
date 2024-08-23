<?php
include 'config.php';
try {
    $pdo = new PDO('mysql:host=' . db_host . ';dbname=' . db_name . ';charset=' . db_charset, db_user, db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    exit('Failed to connect to database!');
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function show_comment($comment, $comments = []) {
    $content = nl2br(htmlspecialchars($comment['content'], ENT_QUOTES));
    
    $content = str_ireplace(
        ['&lt;i&gt;', '&lt;/i&gt;', '&lt;b&gt;', '&lt;/b&gt;', '&lt;u&gt;', '&lt;/u&gt;', '&lt;code&gt;', '&lt;/code&gt;', '&lt;pre&gt;', '&lt;/pre&gt;'],
        ['<i>', '</i>', '<b>', '</b>', '<u>', '</u>', '<code>', '</code>', '<pre>', '</pre>'],
        $content
    );
   
    $html = '
    <div class="comment">
        <div class="img">
            <img src="' . (!empty($comment['img']) ? htmlspecialchars($comment['img'], ENT_QUOTES) : default_profile_image) . '" width="48" height="48" alt="Comment Profile Image">
        </div>
        <div class="con">
            <div>
                <h3 class="name">' . htmlspecialchars($comment['name'], ENT_QUOTES) . '</h3>
                <span class="date">' . time_elapsed_string($comment['submit_date']) . '</span>
            </div>
            <p class="comment_content">
                ' . $content . '
                ' . ($comment['approved'] ? '' : '<br><br><i>(Awaiting approval)</i>') . '
            </p>
            <div class="comment_footer">
                <span class="num">' . $comment['votes'] . '</span>
                <a href="#" class="vote" data-vote="up" data-comment-id="' . $comment['id'] . '">
                    <i class="arrow up"></i>
                </a>
                <a href="#" class="vote" data-vote="down" data-comment-id="' . $comment['id'] . '">
                    <i class="arrow down"></i>
                </a>
                <a class="reply_comment_btn" href="#" data-comment-id="' . $comment['id'] . '">Reply</a>
            </div>
            ' . show_write_comment_form($comment['id']) . '
            <div class="replies">
            ' . show_comments($comments, $comment['id']) . '
            </div>
        </div>
    </div>';
    return $html;
}
function show_comments($comments,$parent_id = -1) {
    $html = '';
    if ($parent_id != -1) {
        array_multisort(array_column($comments, 'submit_date'), SORT_ASC, $comments);
    }
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $parent_id) {
            $html .= show_comment($comment, $comments);
        }
    }
    return $html;
}
function show_write_comment_form($parent_id = -1) {
    $html = '
    <div class="write_comment" data-comment-id="' . $parent_id . '">
        <form>
            <input name="parent_id" type="hidden" value="' . $parent_id . '">
            <input name="name" type="text" placeholder="Your Name" required>
            <textarea name="content" placeholder="Write your comment here..." required></textarea>
            <input name="img_url" type="url" placeholder="Photo Icon URL (optional)">
            <button type="submit">Submit</button>
        </form>
    </div>
    ';
    return $html;
}
if (isset($_GET['article_id'])) {
    
    if (isset($_POST['name'], $_POST['content'], $_POST['parent_id'], $_POST['img_url'])) {
        // Insert a new comment
        $stmt = $pdo->prepare('INSERT INTO comments (article_id, parent_id, name, content, submit_date, img, approved) VALUES (?,?,?,?,NOW(),?,?)');
        $approved = comments_approval_required ? 0 : 1;
        $stmt->execute([ $_GET['article_id'], $_POST['parent_id'], $_POST['name'], $_POST['content'], $_POST['img_url'], $approved ]);
        // Retrieve the comment
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute([ $pdo->lastInsertId() ]);
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        // Output the comment
        exit(show_comment($comment));
    }
    // IF the user clicks one of the vote buttons
    if (isset($_GET['vote'], $_GET['comment_id'])) {
        // Check if the cookie exists for this comment
        if (!isset($_COOKIE['vote_' . $_GET['comment_id']])) {
            // Cookie does not exists, update the votes column and increment/decrement the value
            $stmt = $pdo->prepare('UPDATE comments SET votes = votes ' . ($_GET['vote'] == 'up' ? '+' : '-') . ' 1 WHERE id = ?');
            $stmt->execute([ $_GET['comment_id'] ]);
            // Set vote cookie, this will prevent the users from voting multiple times on the same comment, cookie expires in 10 years
            setcookie('vote_' . $_GET['comment_id'], 'true', time() + (10 * 365 * 24 * 60 * 60), '/');
        }
        // Retrieve the number of votes from the comments table
        $stmt = $pdo->prepare('SELECT votes FROM comments WHERE id = ?');
        $stmt->execute([ $_GET['comment_id'] ]);
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        // Output the votes
        exit($comment['votes']);
    }
    // If the limit variables exist, add the LIMIT clause to the SQL statement
    $comments_per_pagination_page = isset($_GET['comments_to_show']) ? $_GET['comments_to_show'] : 30;
    $limit = isset($_GET['current_pagination_page']) ? 'LIMIT :current_pagination_page' : '';
    // By default, order by the submit data (newest)
    $sort_by = 'ORDER BY votes DESC, submit_date DESC';
    if (isset($_GET['sort_by'])) {
        // User has changed the sort by, update the sort_by variable
        $sort_by = $_GET['sort_by'] == 'newest' ? 'ORDER BY submit_date DESC' : $sort_by;
        $sort_by = $_GET['sort_by'] == 'oldest' ? 'ORDER BY submit_date ASC' : $sort_by;
        $sort_by = $_GET['sort_by'] == 'votes' ? 'ORDER BY votes DESC, submit_date DESC' : $sort_by;
    }
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE article_id = :article_id AND approved = 1 ' . $sort_by . ' ' . $limit);
    if ($limit) {
        $stmt->bindValue(':current_pagination_page', (int)$_GET['current_pagination_page']*(int)$comments_per_pagination_page, PDO::PARAM_INT);
    }
    $stmt->bindValue(':article_id', $_GET['article_id'], PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Get the overall rating and total number of comments
    $stmt = $pdo->prepare('SELECT COUNT(*) AS total_comments FROM comments WHERE article_id = ? AND approved = 1');
    $stmt->execute([ $_GET['article_id'] ]);
    $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    exit('No page ID specified!');
}
?>

<div class="comment_header">
    <span class="total"><?=$comments_info['total_comments']?> comments</span>
    <form>
        <label for="sort_by"></label>
        <select name="sort_by" id="sort_by">
            <option value="" disabled<?=!isset($_GET['sort_by']) ? ' selected' : ''?>>Sort By</option>
            <option value="votes"<?=isset($_GET['sort_by']) && $_GET['sort_by'] == 'votes' ? ' selected' : ''?>>Votes</option>
            <option value="newest"<?=isset($_GET['sort_by']) && $_GET['sort_by'] == 'newest' ? ' selected' : ''?>>Newest</option>
            <option value="oldest"<?=isset($_GET['sort_by']) && $_GET['sort_by'] == 'oldest' ? ' selected' : ''?>>Oldest</option>
        </select>
    </form>
    <a href="#" class="write_comment_btn" data-comment-id="-1">Write Comment</a>
</div>

<?=show_write_comment_form()?>

<div class="comments_wrapper">
    <?=show_comments($comments)?>
</div>

<?php if (count($comments) < $comments_info['total_comments']): ?>
<a href="#" class="show_more_comments">Show More</a>
<?php endif; ?>
