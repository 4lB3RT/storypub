<?php
include 'head_common.php';
?>
<section>


    <!-- TABLE STORIES-->
    <div class="row">
        <div id="profile" class="col-md-2">
           <?php
                $user = $this->dataTable["user"];
                $user = $user[0];
                echo $user["email"];
           ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-2">
            <div class="row text-right">
                <button type="button" id="add_history" class="btn btn-primary" data-toggle="modal" data-target="#Modal_add" data-whatever="@mdo">Add Your history</button>
                <button id='delete' class=' btn btn-danger'>DELETE</button>
                <button class='btn btn-info'>UPDATE</button>
            </div>

            <!-- MODAL FOR ADD HISTORY-->
            <div class="modal fade" id="Modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">New History</h4>
                        </div>
                        <form id="form_add_history" action="dashboard/add_history" method="post">
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label for="recipient-title" class="control-label">Title History</label>
                                        <input type="text" class="form-control" id="recipient-title" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="control-label">Tell us your history</label>
                                        <textarea class="form-control" id="message-text" name="history" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-tags" class="control-label">Tags about your history</label>
                                        <input type="text" class="form-control" id="recipient-tags" name="tags" required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">History Done</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLE  -->
            <table class="table table-condensed">
                <tr>
                    <td>CHECK</td>
                    <td>USERNAME</td>
                    <td>TITLE</td>
                    <td>STORY</td>
                    <td>DATE</td>

                </tr>
                <?php
                    for($i=0;$i<count($this->dataTable["stories"]);$i++){
                        echo "
                        <tr class='active'>";
                        $stories = $this->dataTable["stories"];
                        $story = $stories[$i];

                        if($user["idusers"] == $story["idusers"]){
                            echo "<label for='id'><td ></labelfor><input id='id' type='checkbox' name='storyid' value='".$story["idstory"]."'></td></label>";
                        }else {
                            echo "<td></td>";
                        }
                            echo "<td>".$story["username"]."</td>";
                            echo "<td>".$story["title"]."</td>";
                            echo "<td>".$story["history"]."</td>";
                            echo "<td>".$story["date_in"]."</td>";

                        echo"</tr>";
                    }
                ?>
            </table>
        </div>

    </div>


</section>