<?php

$commentsFounds = isset( $allComments );
if($commentsFound === false ){
  trigger_error('views/comments-html.php needs $allCommments');
}

$allCommentsHTML = "<ul id='comments'>";

while ($commentData = $allComments->fetchObject() ) {
  $allCommentsHTML .= "<li>
    $commentData->author wrote:
    <p>$commentData->txt</p>
    </li>";
}

$allCommentsHTML .= "</ul>";

return $allCommentsHTML;
