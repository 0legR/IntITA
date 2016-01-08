/**
 * Created by Quicks on 21.11.2015.
 */
    function getInvoicesList(url)
    {
        var user = document.getElementById('findUser');
        var agreement = document.getElementsByName('agreement');
        var agreementId = '';
        for(var j = 0 ;j < agreement.length; j++)
        {
            if(agreement[j].checked)
            {
               agreementId  = agreement[j].value;
                break;
            }
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id': agreementId
            },
            cache: false,
            success: function(response) {
                //alert(user.style.display);
                if (user.style.display == 'none') {
                    document.getElementById('selectInvoices').style.display = 'block';
                    document.getElementById('selectUserInvoices').style.display = 'none';
                    $('div[name="selectInvoices"]').html(response);
                }
                else {
                    document.getElementById('selectUserInvoices').style.display = 'block';
                    user.style.display = 'none';

                    $('div[name="selectUserInvoices"]').html(response);
                }
            }
        });
    }

function getAgreementsList(url){

    var agreement = document.getElementById('agreementNumber').value;
    document.getElementById('selectInvoices').style.display = 'none';
    if(agreement[2] != undefined)
    {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'agreement': agreement
            },
            cache: false,
            success: function(response)
            {
                if(response)
                $('div[name="selectAgreement"]').html(response);

                else
                    alert('По Вашому запиту нічого не знайдено');
            }
        });
    }
}

//function showOperation(id)
//{
//    var offer = document.getElementById('findOffer');
//    var operation = document.getElementById('findOperation');
//    var user = document.getElementById('findUser');
//
//    var arr = [];
//    arr.push(offer);
//    arr.push(operation);
//    arr.push(user);
//
//    for(var i = 0;i < arr.length; i++)
//    {
//        if(i == id)
//            arr[i].style.display = 'block';
//
//        else
//            arr[i].style.display = 'none';
//
//    }
//
//}

function checkInvoices()
{
    var list = document.getElementsByName('invoices[]');
        for(var i = 0; i < list.length; i++)
        {
            if(list[i].checked)
                return true;
        }
    alert("Виберіть хоча б один рахунок");
    return false;
}

function getInvoicesListByNumber(url)
{
    var number = document.getElementById('invoiceNumber').value;
    if(number[2] != undefined)
    {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'invoiceNumber': number
            },
            cache: false,
            success: function(response)
            {
                if(response)
                $('div[name="selectInvoicesByNumber"]').html(response);

                else
                    alert('По Вашому запиту нічого не знайдено');
            }
        });
    }
}

function getAgreementsListByUser(url)
{
    document.getElementById('selectUserInvoices').style.display = 'none';
    document.getElementById('userAgreement').style.display = 'none';

    var user = document.getElementsByName('user');
    var userId = '';
    for(var j = 0 ;j < user.length; j++)
    {
        if(user[j].checked)
        {
            userId  = user[j].value;
            break;
        }
    }

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'userId': userId
        },
        cache: false,
        success: function(response){
            document.getElementById('userAgreement').style.display = 'block';
            $('div[name="userAgreement"]').html(response); }
    });
}

function getUserList(url)
{

    var number = document.getElementById('userEmail').value;
    if(number[2] != undefined)
    {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'userEmail': number
            },
            cache: false,
            success: function(response)
            {
                if(response)
                    $('div[name="userList"]').html(response);

                else
                    alert('По Вашому запиту нічого не знайдено');
            }
        });
    }
}



