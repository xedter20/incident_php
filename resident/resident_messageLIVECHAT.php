<?php
include '../connection/config.php';
$db = new Database();

//display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

if($_SESSION['auth_user']['resident_id']==0){
  echo"<script>window.location.href='index.php'</script>";
  
}

if (isset($_POST['userUNIQUEid_receiver'])) {

    // $studId_sender = $_SESSION['auth_user']['student_id'];

    $uniqueId_receiver = $_POST['userUNIQUEid_receiver'];
    

    $results = $db->resident_messageLIVECHAT_selected_receiver($uniqueId_receiver);
}
?>
    <div class="py-2 px-4 border-bottom d-none d-lg-block">
        <div class="d-flex align-items-center py-1">
        <div class="position-relative">
            <img src="<?php echo $results['profile_picture']; ?>" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
        </div>
        <div class="flex-grow-1 pl-3">
            <strong><?php echo $results['first_name']; ?> <?php echo $results['middle_name']; ?> <?php echo $results['last_name']; ?></strong>
            <div class="text-muted small"><em>Typing...</em></div>
        </div>
        </div>
    </div>

    <?php
    if (isset($_POST['userUNIQUEid_receiver'])) {
    // Fetch messages between sender and receiver
    $senderId = $_SESSION['auth_user']['resident_uniqueID'];
    $receiverId = $_POST['userUNIQUEid_receiver'];

    // Modify your SQL query to fetch messages between sender and receiver
    $messages = $db->show_messages($senderId, $receiverId);
    ?>

    <div class="position-relative">
        <div class="chat-messages p-4" id="chatMessages">
            <?php foreach ($messages as $message) : ?>
                <?php if ($message['sender_id'] == $senderId) : ?>
                    <div class="chat-message-right pb-4">
                        <div>
                            <img src="<?= $message['profile_picture']; ?>" class="rounded-circle mr-1" alt="You" width="40" height="40">
                            <div class="text-muted small text-nowrap mt-2"><?= $message['time_only']; ?></div>
                            <div class="text-muted small text-nowrap mt-2"><?= $message['status']; ?></div>
                        </div>
                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                            <div class="font-weight-bold mb-1">You</div>
                            <?= $message['messages']; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="chat-message-left pb-4">
                        <div>
                            <img src="<?= $message['profile_picture']; ?>" class="rounded-circle mr-1" alt="<?= $message['first_name']; ?>" width="40" height="40">
                            <div class="text-muted small text-nowrap mt-2"><?= $message['time_only']; ?></div>
                            <div class="text-muted small text-nowrap mt-2"><?= $message['status']; ?></div>
                        </div>
                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                            <div class="font-weight-bold mb-1"><?= $message['first_name']; ?> <?= $message['middle_name']; ?> <?= $message['last_name']; ?></div>
                            <?= $message['messages']; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php
} else {
    // Handle the case where 'user_id_receiver' is not set
    echo "No receiver specified.";
}
?>

    <form action="" method="POST">
    <div class="flex-grow-0 py-3 px-4 border-top">
        <div class="input-group">
        <textarea class="form-control" name="message" placeholder="Type your message"></textarea>
        <button class="btn btn-primary" name="sendMessage">Send</button>
        </div>
    </div>
    </form>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
$(document).ready(function() {
    


    // Submitting a new message
    $("form").submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally
        var message = $("textarea[name='message']").val();
        var receiverId = <?php echo json_encode($receiverId); ?>;

        $.ajax({
            type: "POST",
            url: "send_user_chat.php",
            data: { message: message, receiver_id: receiverId },
            success: function(data) {
                
                    // Clear the textarea
                    $("textarea[name='message']").val("");
            }
        });
    });

           $(function(){
            var receiverId = <?php echo json_encode($receiverId); ?>;
             setInterval(function(){
              $.ajax({
                type: "POST",
                url: "load_NewMessage.php", // Create a separate PHP file to check for new messages
                data: { receiver_id: receiverId },
                success:function(data){
                    $("#chatMessages").html(data);
                }
              });   
             }, 100);
           });

           
    
});


</script>


    <script>
  // JavaScript to scroll to the bottom of the chat messages div
  var chatMessages = document.getElementById("chatMessages");
  chatMessages.scrollTop = chatMessages.scrollHeight;
</script>