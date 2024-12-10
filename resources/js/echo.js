
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});
window.Echo.join('status')
    .here((users) => {

        for(let x=0;x<users.length;x++){
            if (sender_id!==users[x]['id']){

                $('#'+users[x]['id']+'-status').removeClass('offline-status');
            $('#'+users[x]['id']+'-status').addClass('online-status');
            $('#'+users[x]['id']+'-status').text('online');
            }
        }
    })
    .joining((user) => {
        $('#'+user.id+'-status').removeClass('offline-status');
        $('#'+user.id+'-status').addClass('online-status');
        $('#'+user.id+'-status').text('online');
    })
    .leaving((user) => {
        $('#'+user.id+'-status').addClass('offline-status');
        $('#'+user.id+'-status').removeClass('online-status');
    })
    .error((error) => {
        console.error(error);
    });

window.Echo.private(`send-message`)

.listen('MessageEvent',(data)=>{


if(sender_id===data.chat.receiver_id ){
    let html=`
                           <div class="distance-user" id="`+data.chat.id+`">

<h3 id="sender"><span>`+data.chat.message+`</span></h3>
                         </div>
                `
    $('.chat-container').append(html);
}

    });



window.Echo.private(`message-deleted`)

    .listen('MessageDeleteEvent',(data)=>{
        $('#'+data.id+'-chat').remove();

    });
window.Echo.private(`update-message`)

    .listen('MessageUpdatedEvent',(data)=>{
        $('#'+data.data.id+'-chat').find('span').text(data.data.message);

    });
