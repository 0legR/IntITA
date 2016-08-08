function initAboutusSliderList(){
    $jq('#aboutusSliderTable').DataTable({
        "ajax": {
            "url": basePath + "/_teacher/_admin/aboutusSlider/getItemsList",
            "dataSrc": "data"
        },
        "columns": [
            {
                "width": "8%",
                "data": "order"
            },
            {
                "data": "photo",
                "render": function (photo) {
                    return '<a href="#" onclick="load('  + photo["link"] + ')"><img class="carouselImage" src="'  + photo["image"] + '"></a>'+
                    '<div>'+photo["text"]+'</div>';
                }
            },
            {
                "width": "10%",
                "data": "order",
                "render": function (order) {
                    return '<a href="#/aboutusSlider/up/'+order+ '">вверх</a>';
                }
            },
            {
                "width": "10%",
                "data": "order",
                "render": function (order) {
                    return '<a href="#/aboutusSlider/down/'+order+ '">вниз</a>';
                }
            },
            {
                "width": "10%",
                "data": "order",
                "render": function (order) {
                    return '<a href="#/aboutusSlider/textUp/'+order+ '">вверх</a>';
                }
            },
            {
                "width": "10%",
                "data": "order",
                "render": function (order) {
                    return '<a href="#/aboutusSlider/textDown/'+order+ '">вниз</a>';
                }
            }
        ],
        "createdRow": function (row, data, index) {
            $jq(row).addClass('gradeX');
        },
        language: {
            "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
        }
    });
}