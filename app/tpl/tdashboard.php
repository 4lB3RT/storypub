<?php
include 'head_common.php';
?>
<section>


    <!-- TABLE STORIES-->
    <div class="container-fluid">
        <div class="row">
            <div id="profile" class="col-md-2">
                <div class="row">
                    <?php
                    $user = $this->dataTable["user"];
                    $user = $user[0];
                    echo $user["email"];
                    ?>
                </div>

               <div class="row">
                   <?php
                   if(\X\Sys\Session::exist('user')){
                       echo'<a href="login/disconnect" id="disconnect" class="btn btn-danger">Disconnect</a>';
                   }
                   ?>
               </div>

            </div>
        </div>
        <div class="row tab-feed">
            <div class="col-lg-10 col-lg-offset-2">
                <?php

                    if($user["roles"] == "2" || $user["roles"] == "1" ){
                        echo '
                                <div class="row text-center">
                                    <button type="button" id="add_history" class="btn btn-success" data-toggle="modal" data-target="#Modal_add" data-whatever="@mdo">Add Your history</button>
                                    <button id=\'delete\' class=\' btn btn-danger\'>DELETE</button>
                                </div>
                                <!-- MODAL FOR ADD STORY-->
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
                                                        <div class="form-group">
                                                            <label for="exampleInputFile">File input</label>
                                                            <input name="image" type="file" id="exampleInputFile">
                                                            <p class="help-block">Example block-level help text here.</p>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">History Done</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- MODAL EDIT STORY-->
                                <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="exampleModalLabel">Edit your stories</h4>
                                            </div>
                                            <form id="form_add_history" action="" method="post">
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
                                </div>';
                    }

                ?>




                <!-- TABLE  -->
                <table class="tab-main table table-condensed">
                    <tr>
                        <td>CHECK</td>
                        <td>USERNAME</td>
                        <td>TITLE</td>
                        <td>STORY</td>
                        <td>DATE</td>

                    </tr>
                    <?php
                        for($i=0;$i<count($this->dataTable["stories"]);$i++){
                            if($i == 0){
                                echo "<tr class='success'>";
                            }else{
                                echo "<tr class='active'>";
                            }
                            $stories = $this->dataTable["stories"];
                            $story = $stories[$i];

                            if($user["idusers"] == $story["idusers"] || $user["roles"] == "1"){
                                echo "
                                       <label for='id'>
                                            <td class='yours' >
                                                    <input id='id' type='checkbox'  name='storyid' value='".$story["idstory"]."'>
                                                    <a class='edit' data-toggle='modal' data-target='#modal_edit' data-whatever='@mdo'>
                                                        <input type='hidden' value='".$story["idstory"]."' class='id' >
                                                        <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i>
                                                    </a>
                                            </td>
                                       </label>";
                            }else {
                                echo "<td></td>";
                            }
                                echo "<td >".$story["username"]."</td>";
                                echo "<td>".$story["title"]."</td>";
                                echo "<td>".$story["history"]."</td>";
                                echo "<td>".$story["date_in"]."</td>";

                            echo"</tr>";
                        }
                    ?>
                </table>
            </div>

        </div>
    </div>

</section>