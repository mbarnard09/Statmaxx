// jQuery for handling upvoting

$('#update').click(function() {
    if (!login) {
        alert("You must be logged in to do that")
    }
    $.ajax({
        url: 'upvote.php',
        type: 'POST',
        data: {
            post_id: id,
            vote_type: 'u',
            user: login
        }, 
        success: function() {
            location.reload();
            
        }                  
    });
});

$('#downvote').click(function() {
    if (!login) {
        alert("You must be logged in to do that")
    }
    $.ajax({
        url: 'upvote.php',
        type: 'POST',
        data: {
            post_id: id,
            vote_type: 'd',
            user: login
        }, 
        success: function() {
            location.reload();
            
        }                  
    });
});


