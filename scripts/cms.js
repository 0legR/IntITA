var content = document.getElementById("cms_content_generate");
if(content != null){
    $jq("#save_cms").click(function(){
        $jq("#sliderBlock").remove();
        var slider='<div ng-controller="sliderGeneratedCtrl" id="sliderBlock" ng-app="cmsAppNew">\n' +
            '    <div  id="slider" class="owl-carousel" style="opacity: 1; display: block;">\n' +
            '        <div uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">\n' +
            '            <div uib-slide class="slide" ng-repeat="slide in slides track by slide.id" index="slide.id">\n' +
            '                <div>\n' +
            '                    <img ng-src="{{slide.image}}">\n' +
            '                    <p>{{slide.text}}</p>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>'
        $jq("#headerCms").after(slider);
        $jq.ajax({
            method: "POST",
            url: basePath + '/_teacher/_admin/cms/generatePage',
            dataType : 'html',
            data: {data: content.innerHTML},
            success : function() {
                location.reload();
            }
        });

    });
}

function changeColorOff (e) {
    element= $(e).children();
    element.css("color", e.getAttribute("data-link"));
}

function changeColorOn (e) {
    element= $(e).children();
    element.css("color",e.getAttribute("data-hover"));
}
