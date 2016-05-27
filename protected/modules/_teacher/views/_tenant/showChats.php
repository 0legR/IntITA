

<div class="col-lg-12">
    <br>
    <ul class="list-inline">

    </ul>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="allChatsTable">
                    <thead>
                    <tr>
                        <th style="width:30%;" >Розмови</th>

                        <th style="width:12%;">Інформація</th>

                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
initListOfChats('<?=$user1?>','<?=$user2?>')
function initListOfChats(user1,user2){

        $jq('#allChatsTable').DataTable({
            "autoWidth": false,
            "ajax": {
                "url": basePath + "/_teacher/_tenant/tenant/FindChats?user1="+user1+"&user2="+user2,
                "dataSrc": "data"
            },
            "columns": [
                {   type: 'text', targets: 1 ,
                    "data": "name"
                   }
            ],
            "createdRow": function (row, data, index) {
                $jq(row).addClass('gradeX');
            },
            language: {
                "url": basePath+"/scripts/cabinet/Ukranian.json",
            },
            processing : true,
        });

}
    </script>