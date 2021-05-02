<?php use App\Core\Helper;?>
<div class="row mt-4">
    <div class="col-6">
    <h2>Students</h2>
    </div>
    <div class="col-6 text-end">
        <a href="<?= Helper::getSiteUrl()?>student/add" class="btn btn-success">Add</a>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <table id="students" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Grade</th>
                    <th scope="col">City</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<?php
$GLOBAL_JS .= <<<JS
$(document).ready(function() {
    $('#students').DataTable({
        processing: true,
        serverSide:true,
        ajax: {
            url: '/students/',
        },
        columns: [
            {
                data: 'id',
                name: 'id'
            },
            {
                data: 'photo',
                name: 'photo',
                orderable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'grade',
                name: 'grade'
            },
            {
                data: 'city',
                name: 'city',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false
            }
        ]
    });
} );
JS;
Helper::setGlobalVariable("GLOBAL_JS", $GLOBAL_JS);
?>