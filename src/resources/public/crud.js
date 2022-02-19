$(document).ready(function(){
    // Activate tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Select/Deselect checkboxes
    var checkbox = $('table tbody input[type="checkbox"]');
    $("#selectAll").click(function(){
        if(this.checked){
            checkbox.each(function(){
                this.checked = true;
            });
        } else{
            checkbox.each(function(){
                this.checked = false;
            });
        }
    });
    checkbox.click(function(){
        if(!this.checked){
            $("#selectAll").prop("checked", false);
        }
    });
});
const getFormData = (selector)=>{
    let requestData = {};
    document.querySelector(selector);
    // console.
};
const resetErrors = ()=>{
    $('.form-group.has-error span.error').html('');
    $('.form-group.has-error').removeClass('has-error');
};
const addError = (selector, error,prefix='')=>{
    let parent = $(`#${prefix}${selector}`).parent();
    console.log({parent})
    parent.addClass('has-error');
    parent.find('span.error').html(error)
};
const getRequestData = (formSelector)=>{
    let requestParams = {};
    for (const pair of new FormData(document.querySelector(formSelector))) {
        requestParams[pair[0]] =  pair[1];
    }
    return requestParams;
}
const showDeleteModal = (context,event)=>{
    $('#deleteModal').modal('show')
    $('#delete-id').val($(context).attr('data-pri'));
};

const showEditWindow = (context,event)=>{
    // $(context).text('Fetching');
    resetErrors();
    fetch(`?id=${$(context).attr('data-pri')}`,{
        headers:{
            'Content-Type': 'application/json'
        },
        method:'GET'
    }).then(r=>{
        let statusCode = r.status;
        r.json().then(json=>{
            switch(statusCode){
                case 200:
                    let form = document.querySelector('form#edit-form');
                    console.log(json);
                    $(form).find('input,select,textarea').each((i,element)=>{
                        console.log({
                            element,
                            name:$(element).attr('name'),val:json[$(element).attr('name')]});
                        $(element).val(json[$(element).attr('name')])
                    });
                    $('#editModal').modal('show');
                    break;
                default:
                    alert(json);
                    break;
            }
        }).catch(error=>{
            console.log({error});
        })
    })
};
const addEntry = (e)=>{
    e.preventDefault();
    let requestParams = getRequestData('form#add');
    resetErrors();
    fetch(``,{
        headers:{
            'Content-Type': 'application/json'
        },
        body:JSON.stringify(requestParams),
        method:'POST'
    }).then(r=>{
        let statusCode = r.status;
        r.json().then(json=>{
            switch(statusCode){
                case 200:
                    document.querySelector('form#add').reset();
                    $('#addModal').modal('hide');
                    alert(json.message);
                    window.location.reload();
                 break;
                case 400:
                    for (let field in json){
                        addError(field,json[field]);
                    }
                    break;
                default:
                    alert(json);
                    break;
            }
        }).catch(error=>{
            console.log({error});
        })
    })
};
const editEntry = (e)=>{
    e.preventDefault();
    let requestParams = getRequestData('form#edit-form');
    requestParams._method = 'PATCH';
    resetErrors();
    fetch(``,{
        headers:{
            'Content-Type': 'application/json'
        },
        body:JSON.stringify(requestParams),
        method:'PATCH'
    }).then(r=>{
        let status = r.status;
        r.json().then(json=>{
            switch (status){
                case 200:
                    alert('Edited Successfully');
                    $('#editModal').modal('hide');
                    window.location.reload();
                    break;
                case 400:
                    console.log(json)
                    for (let field in json){
                        addError(field,json[field],'edit-');
                    }
                    break;
                default:
                    break;
            }
        })
    })
};
const deleteEntry = (e)=>{
    e.preventDefault();
    let deletedIds = $('#delete-id').val();
    if(deletedIds==='' || deletedIds.length===0){
        let checkedItems = $('.deleting-ids:checked');
        if(checkedItems.length===0){
            alert('Please select any row');
            $('#deleteModal').modal('hide');
            return;
        }
        deletedIds = [];
        checkedItems.each((i,item)=>{
            deletedIds.push($(item).val())
        });
    } else {
        deletedIds =  deletedIds.split('');
    }
   console.log(deletedIds)
    fetch(``,{
        headers:{
            'Content-Type': 'application/json'
        },
        body:JSON.stringify({deletedIds,_method:'DELETE'}),
        method:'POST'
    }).then(r=>{
        let status = r.status;
        switch (status){
            case 201:
                alert('Deleted successfully');
                $('#deleteModal').modal('hide');
                window.location.reload();
                break;
            default:
                break;
        }
    })
};