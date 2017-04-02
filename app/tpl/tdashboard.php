<?php
include 'head_common.php';
?>
<section>
    <div class="row text-right">
        <button type="button" id="add_history" class="btn btn-primary" data-toggle="modal" data-target="#Modal_add" data-whatever="@mdo">Add Your history</button>
    </div>

    <!-- MODAL FOR ADD HISTORY-->
    <div class="modal fade" id="Modal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New History</h4>
                </div>
                <div class="modal-body">
                    <form id="form_add_history" action="dashboard/add_history">
                        <div class="form-group">
                            <label for="recipient-title" class="control-label">Title History</label>
                            <input type="text" class="form-control" id="recipient-title">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Tell us your history</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="recipient-tags" class="control-label">Tags about your history</label>
                            <input type="text" class="form-control" id="recipient-tags">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">History Done</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE STORIES-->
    <div class="row">
        <table class="table table-condensed">
            <tr class="active">
                <td></td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
                <td>...</td>
            </tr>
        </table>
    </div>


</section>