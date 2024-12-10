$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function (){

    $('.user-list').click(function (){
        $('.chat-container').append('');

        receiver_id=$(this).attr('data-id')
        $('.start-head').hide();
        $('.chat-section').show();
        loadChat();

    });
    $('#chat-form').submit(function (e){
        e.preventDefault();
         let $messgae=$('#message').val();




        $.ajax({
            type: 'POST',
            url: '/save-chat',
            data: { sender_id:sender_id,receiver_id:receiver_id,message:$messgae
    },
            success: function(response) {
                $('#message').val(' ');
                let chat=response.data.message;
                let html=`
                   <div class="current-user" id="`+response.data.id+`-chat">
<h3 id="sender">`+chat+`</h3>
<i class="fa fa-trash" aria-hidden="true" class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#basicModal" data-id="`+response.data.id+`"></i>
             <i class="fa fa-edit" aria-hidden="true" class="btn btn-primary "
            data-bs-toggle="modal"
            data-bs-target="#updateModal" id="chattrash"  data-id="`+chat[i].id+`" data-message="`+chat[i].message+`"></i>

                         </div>
                `
$('.chat-container').append(html);


            },
            error: function(error) {
                console.log(error);
            }
        });



    });
   function loadChat(){
     $.ajax({
         type: 'POST',
         url: '/load-chat',
         data: { sender_id:sender_id,receiver_id:receiver_id
         },
         success: function(response) {
if(response.success){
let chat=response.data;
let html='';
for (let i=0;i<chat.length;i++){
    let addClass='';
    if(chat[i].sender_id===sender_id){
        addClass='current-user'
    }else{
        addClass='distance-user-user'

    }
    html+=`
      <div class="`+addClass+`" id="`+chat[i].id+`-chat">
<h3 id="sender"><span>`+chat[i].message+`</span></h3>
<i class="fa fa-trash" aria-hidden="true" class="btn btn-primary "
            data-bs-toggle="modal"
            data-bs-target="#basicModal" id="chattrash"  data-id="`+chat[i].id+`"></i>


            <i class="fa fa-edit" aria-hidden="true" class="btn btn-primary "
            data-bs-toggle="modal"
            data-bs-target="#updateModal" id="chattrash"  data-id="`+chat[i].id+`" data-message="`+chat[i].message+`"></i>

                         </div>
    `

}

    $('.chat-container').append(html);

}
         }
     })
         }


         $(document).on('click','.fa-trash',(function (){
             let id= $(this).attr('data-id');
            $('#delete-chat-id').val(id);
         }));


$('#chat-form-delete').submit(function (e){
    e.preventDefault();
   let id= $('#delete-chat-id').val();
    $.ajax({
        type: 'POST',
        url: '/delete-chat',
        data: { id:id
        },
        success: function(response) {
            if (response.success){
$('#'+id+'-chat').remove();
            }
        }
    });

})
    $(document).on('click','.fa-edit',(function (){
        let id= $(this).attr('data-id');
        $('#update-chat-id').val(id);
    }));

    $('#update-chat-id').submit(function (e){
        e.preventDefault();
        let id= $('#update-chat-id').val();
        let message= $('#message').val();

        $.ajax({
            type: 'POST',
            url: '/update-chat',
            data: { id:id,message:message
            },
            success: function(response) {
                if (response.success){
                    $('#updateModal').hide();
                    $('#'+id+'-chat').find('span').text(message);
                }
            }
        });

    })




});
