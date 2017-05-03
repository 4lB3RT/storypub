<?php
include 'head_common.php';
?>
<?php
    $user = $this->dataTable["user"];
    $user = $user[0];
?>
<section>


    <!-- PROFILE USERS-->
    <div class="container-fluid">
        <div class="row ">
            <div id="profile" class="col-md-2">
                <div class="row text-center">
                    <?php
                        if($user["roles"] == "3"){
                            echo'<div class="text-left">
                                    <h3>IMPORTANT:</h3><h4>If you want create story, first rate 10 strories</h4>
                                </div>';
                        }
                         ?>
                </div>
                <form>
                    <div class="row text-center">
                        <div class="user-info">
                            <?= $user["username"]; ?>
                        </div>
                        <div class="user-edit">
                            <label for="usename">Username</label>
                            <input type="text" class="form-control" id="usename" name="username" placeholder="username" required>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="user-info">
                            <?= $user["email"]; ?>
                        </div>
                        <div class="user-edit">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="user-edit">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" id="pass" name="passs" placeholder="password" required>
                        </div>
                    </div>
                    <div class="row text-center user-edit">
                        <input type="hidden" value="<?= $user["idusers"]?>" id="user_id" name="id_user">
                        <button id="save-user" class="btn btn-success">Save</button>
                        <button id="exit-button" class="btn btn-danger">Exit</button>
                    </div>
                   <div class="row text-center">
                       <?php
                       if(\X\Sys\Session::exist('user')){
                           echo'<button id="edit-profile" class="btn btn-info">Edit</button>';
                           echo'<a href="login/disconnect" id="disconnect" class="btn btn-danger">Disconnect</a>';
                       }
                       ?>
                   </div>
                </form>
            </div>
            <div class="col-lg-10 ">
                <?php

                    //if is user or admin for make modal
                    if($user["roles"] == "2" || $user["roles"] == "1" ){
                        echo '
                                <div class="row text-center">
                                    <a class="btn btn-success" data-toggle="modal" data-target="#modal_add" data-whatever="@mdo">Add Your Story</a>
                                    <button id="delete" class="btn btn-danger">DELETE</button>
                                </div>
                                <!-- MODAL FOR ADD STORY-->
                                <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modaladd">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="exampleModalLabel">Add Your Story</h4>
                                            </div>
                                            <form id="form_add_story" name="form_add_stories" action="dashboard/save_story" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-title" class="control-label">Title History</label>
                                                        <input id="title-add" type="text" class="form-control" id="recipient-title" name="title" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Tell us your history</label>
                                                        <textarea id="story-add" class="form-control" id="message-text" name="history" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-tags" class="control-label">Tags about your history</label>
                                                        <input id="tags-add" type="text" class="form-control" id="recipient-tags" name="tags" required>
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
                                <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modaledit">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="exampleModalLabel">Edit your stories</h4>
                                            </div>
                                            <form id="form_edit_history" action="/dashboard/save_story" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="recipient-title" class="control-label">Title History</label>
                                                        <input id="title-edit" type="text" class="form-control" id="recipient-title" name="title" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Tell us your history</label>
                                                        <textarea id="story-edit" class="form-control" id="message-text" name="history" required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="recipient-tags" class="control-label">Tags about your history</label>
                                                        <input id="tags-edit" type="text" class="form-control" id="recipient-tags" name="tags" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" id="id_reloadstory" name="id_story">
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
                        <?php
                            if( $user["roles"] == "2" || $user["roles"] == "1"){
                                echo '<td>CHECK</td>';
                            }
                        ?>
                        <td>USERNAME</td>
                        <td>TITLE</td>
                        <td>RATING</td>
                        <td>STORY</td>
                        <td>DATE</td>

                    </tr>
                </table>
                <div id="container-tab">
                    <table class="table table-condensed">
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
                                    echo "<td id='rate'>";
                                            for($j=0;$j < 5;$j++){
                                                if($j < $story["val"]){
                                                    echo "<a class='rate' ><i class='star fa fa-star' aria-hidden='true'><input class='story_id' type='hidden' value='".$story["idstory"]."'><input class='input-rate' type='hidden' value='$j'> </i></a>";
                                                }else{
                                                    echo "<a class='rate' ><i class='star fa fa-star-o' aria-hidden='true'><input class='story_id' type='hidden' value='".$story["idstory"]."'><input class='input-rate' type='hidden' value='$j'> </i></a>";

                                                }
                                            }

                                    echo "<td>".$story["date_in"]."</td>";

                                echo"</tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>

        </div>
    </div>

</section>