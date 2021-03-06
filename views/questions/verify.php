<?php
   use Helpers\Questions;

   $q = new Questions;
   $questions = $q->getQuestions($_SESSION['login']);
 ?>
<form method="post" action="helpers/PostQuestions.php">
   <div id="questions">
      <div class="form-group">
         <input type="text" class="form-control" id="qf1" name="qf1"/ disabled value="<?= $questions->q1 ?>">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" placeholder="Answer 1" id="q1" name="q1"/>
      </div>
      <div class="form-group">
         <input type="text" class="form-control" id="qf2" name="qf2"/ disabled value="<?= $questions->q2 ?>">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" placeholder="Answer 2" id="q2" name="q2"/>
      </div>
      <div class="form-group">
         <input type="text" class="form-control" id="qf3" name="qf3"/ disabled value="<?= $questions->q3 ?>">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" placeholder="Answer 3" id="q3" name="q3"/>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6"><p>Enter the SMS code sent to your mobile phone:</p></div>
      <div class="col-md-6">
         <input type="text" class="form-control" placeholder="SMS code" id="smscode" name="smscode"/>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12"><p><button class="btn btn-success" type="submit" role="button" id="button" >Access</button></p></div>
   </div>
</form>
<div id="error-message">
   <?php
      if(isset($_SESSION['error'])) {
         echo $_SESSION['error'];
         unset($_SESSION['error']);
      }
    ?>
</div>
